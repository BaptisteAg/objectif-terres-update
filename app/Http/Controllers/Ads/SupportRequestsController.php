<?php

namespace App\Http\Controllers\Ads;


use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\User;
use App\Notifications\NewAdToModerateNotification;
use App\Notifications\NewSupportRequestNotification;

class SupportRequestsController extends BaseController
{
    public const SUPPORT_REQUESTS_LIMIT_PER_USER = 1;

    /**
     * Display the ad creation form
     * @return \Illuminate\View\View
     */
    public function start()
    {
        $vars = array_merge($this->getCreateFormVars(), [
            'isSupportRequest' => 1
        ]);
        return view('pages.ads.support-request', $vars);
    }

    /**
     * Display the ad creation form
     * @return \Illuminate\View\View
     */
    public function processStart()
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user && $user->supportRequests()->count() >= self::SUPPORT_REQUESTS_LIMIT_PER_USER) {
            return back()->withErrors(
                "Vous avez déjà fait une demande d’accompagnement. Pour mettre à jour votre projet ou nous contacter, allez dans votre compte"
            );
        }

        session()->put('support-request.text', request('support_request_text'));
        return redirect()->route('support-request.create');
    }

    /**
     * Display the ad creation form
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $vars = array_merge($this->getCreateFormVars(), [
            'isSupportRequest' => 1
        ]);
        return view('pages.ads.new', $vars);
    }

    /**
     * @param AdRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function submitRequest(AdRequest $request)
    {

        $data = $request->validated();

        /** @var $ad Ad $ad */
        try {

            $ad = $this->adService->requestPublishing($data, true);
            // send a notification to each related supervisor
            foreach($this->adService->getAdSupervisors($ad) as $supervisor) {
                $supervisor->notify(new NewSupportRequestNotification($ad));
            }
        }
        catch(\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }

        return redirect()->route('ads.show', [$ad->id])
            ->with('success', 'Votre demande a bien été soumise. Vous receverez une réponse très bientôt ! ');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show()
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();
        $ad = $this->adService->getUserSupportRequest($currentUser);

        $vars = $this->getShowVars($ad);

        $vars["isSupportRequest"] = true;

        return view('pages.ads.show', $vars);
    }
}
