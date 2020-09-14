<?php

namespace App\Http\Controllers\Ads;


use App\Exceptions\AttributionAdException;
use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\CmsPage;
use App\Models\Territory;
use App\Models\User;
use App\Notifications\NewSupportRequestNotification;
use App\Notifications\SupportRequestAttributionNotification;

class SupportRequestsController extends BaseController
{
    public const SUPPORT_REQUESTS_LIMIT_PER_USER = 1;

    /**
     * Display the ad edit form
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function edit()
    {

        /** @var User $user */
        $user = auth()->user();

        $ad = $user->supportRequest;

        $vars = array_merge($this->getEditFormVars($ad), [
            'isSupportRequest' => 1
        ]);

        $vars["old"]["land_seek"]["offer_genres"] = $ad->landSeekAd->offerGenres->pluck("id")->toArray();
        $vars["old"]["land_seek"]["education_levels"] = $ad->landSeekAd->educationLevels->pluck("id")->toArray();

        return view('pages.ads.new', $vars);
    }

    /**
     * Display the ad creation form
     * @return \Illuminate\View\View
     */
    public function start()
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user && $user->supportRequests()->count() >= self::SUPPORT_REQUESTS_LIMIT_PER_USER) {
            return back()->withErrors(
                "Vous avez déjà rempli une demande d’accompagnement. Pour mettre à jour votre projet ou nous contacter, allez dans votre compte"
            );
        }

        $vars = array_merge($this->getCreateFormVars(), [
            'isSupportRequest' => 1,
			'territories' => Territory::all(),
			'pageContent' => CmsPage::where('slug', 'like', "%etre-accompagne%")->get()->keyBy('slug')
        ]);
        return view('pages.ads.support-request', $vars);
    }

    /**
     * Display the ad creation form
     */
    public function processStart()
    {

        session()->put([
            'support-request.text' => request('support_request_text'),
            'support-request.territory_id' => request('support_request_territory_id')
        ]);

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

        if(empty($vars["old"]["support_request_text"])) {
            $vars["old"]["support_request_text"] = session('support-request.text');
        }

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
            // If this is an update, we'll skip the publishing/attribution part
            if(!empty($data["id"])) {
                $ad = $this->adService->update($data["id"], $data);
                $success = "Votre demande a bien été mise à jour.";
            }
            else {
                $ad = $this->adService->requestPublishing($data, true);
                $success = 'Votre demande a bien été soumise. Vous receverez une réponse très bientôt !';

                if ($ad->attributionAd->userAdvisor) {
                    $ad->attributionAd->userAdvisor->notify(new SupportRequestAttributionNotification($ad));
                }
                else {
                    // send a notification to each related supervisor
                    foreach($this->adService->getAdSupervisors($ad) as $supervisor) {
                        $supervisor->notify(new NewSupportRequestNotification($ad));
                    }
                }
            }
            session()->forget('support-request');
        }
        catch(AttributionAdException $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
        /** Probably an unexpected error */
        catch(\Exception $exception) {
            logger()->error($exception->getMessage(), $exception->getTrace());
            return back()->withInput()->withErrors(
                "Une erreur imprévu a eu lieu. Merci de nous contacter en précisant le message d'erreur suivant : '
                [".date('d/m/Y H:i:s')."]' ".$exception->getMessage()
            );
        }

        return redirect()->route('support-request.show')
            ->with('success', $success);
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
