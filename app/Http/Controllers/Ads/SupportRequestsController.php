<?php

namespace App\Http\Controllers\Ads;


use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Notifications\NewAdToModerateNotification;

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
        $ad = $this->adService->requestPublishing($data);
        //TODO if the new ad is a project, send a notification to the related supervisor. Otherwise, it's an ad, send a message to the related moderator
//		$ad->attributionAd->userSupervisor->notify(new NewProjectsNotification($ad, auth()->user()));
        $ad->attributionAd->userModerator->notify(new NewAdToModerateNotification($ad, auth()->user()));


        return redirect()->route('ads.show', [$ad->id])
            ->with('success', 'Votre annonce a bien été soumise à modération. Vous receverez une réponse très bientôt ! ');
    }
}
