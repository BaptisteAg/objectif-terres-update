<?php

namespace App\Http\Controllers\Ads;


use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Notifications\NewAdToModerateNotification;
use App\Notifications\NewProjectsNotification;

class SupportRequestsController extends BaseController
{
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
        $ad = $this->adService->requestPublishing($data, true);
        // send a notification to the related supervisor
        $ad->attributionAd->userSupervisor->notify(new NewProjectsNotification($ad, auth()->user()));


        return redirect()->route('ads.show', [$ad->id])
            ->with('success', 'Votre annonce a bien été soumise à modération. Vous receverez une réponse très bientôt ! ');
    }
}
