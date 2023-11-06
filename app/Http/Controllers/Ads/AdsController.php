<?php

namespace App\Http\Controllers\Ads;

use App\Exceptions\AttributionAdException;
use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\User;
use App\Notifications\BasicNotification;
use App\Notifications\NewAdToModerateNotification;
use App\Notifications\NewSupportRequestNotification;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class AdsController extends BaseController
{
    public const PUBLISHED_AD_LIMIT_PER_USER = 50;

    /**
     * Display the ad creation form
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $supportRequests = [];
        if (auth()->user()->supportRequest) {
            $supportRequests = [auth()->user()->supportRequest];
        }
        return view('pages.ads.new', array_merge($this->getCreateFormVars(), compact("supportRequests")));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function save(AdRequest $request)
    {
        $ad = $this->store($request, 0);

        return redirect()->route('ads.preview', ["id" => $ad->id]);
    }

    /**
     * Display the ad edit form
     * @return \Illuminate\View\View
     * @throws \Exception
     * @throws \Throwable
     */
    public function preview(int $id)
    {
        $ad = $this->adService->find($id);
        $currentUser = auth()->user();
        $isPreview = true;

        return view('pages.ads.show', compact('ad', 'currentUser', 'isPreview'));
    }

    /**
     * Display the ad edit form
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function edit(int $id)
    {
        $ad = $this->adService->find($id);

        $vars = $this->getEditFormVars($ad);
        return view('pages.ads.new', $vars);
    }

    /**
     * @param AdRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function requestPublishing(int $id)
    {
        /** @var User $user */
        $user = auth()->user();
        $publishedAdsCount = $this->adService->getUserPublishedAdsCount($user);

        if ($publishedAdsCount >= self::PUBLISHED_AD_LIMIT_PER_USER) {
            return back()->withErrors(
                "Vous ne pouvez publier que " . self::PUBLISHED_AD_LIMIT_PER_USER . " annonces en même temps.
                Votre annonce a été sauvegardée mais ne sera pas soumise à modération."
            );
        }

        $ad = $this->adService->find($id);

        /** @var $ad Ad $ad */
        try {
            $ad = $this->adService->requestPublishing($ad);

        } catch (\Exception $exception) {

            $exceptionMessage = "[51] Désolé, une erreur s'est produite. Nous avons été informé du problème.";

            if (is_a($exception, AttributionAdException::class)) {
                $exceptionMessage = $exception->getMessage();
            }

            report($exception);
            if(config('app.env') !== 'production') {
                throw $exception;
            }
            return back()->withInput()->withErrors($exceptionMessage);
        }

        return redirect()->route('ads.show', [$ad->id])
            ->with('success', 'Votre annonce a bien été soumise à modération. Vous recevrez une réponse très bientôt ! ');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function saveDraft(AdRequest $request)
    {
        try {
            $ad = $this->store($request, 1);
            return redirect()->route('ads.list', [$ad->id])->with('success', 'Votre annonce a bien été sauvegardée.');
        } catch (\Exception $exception) {
            report($exception);
            return back()->withInput()->withErrors("[52] Désolé, une erreur s'est produite. Nous avons été informé du problème.");
        }
    }

    /**
     * @param int $adId
     * @return Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show($adId)
    {
        $ad = $this->adService->find($adId);

        $moderatorInChargeOfModeration = $this->attributionAdService->moderatorIsChargeOfAdModeration($ad);
        if ($ad->trashed()) {
            if ($moderatorInChargeOfModeration) {
                return view('errors.deleted_ad', compact('ad'));
            } else {
                abort(404);
            }
        }

        if (!isset($ad->user_pp_id)) {
            abort(404);
        }

        if ($ad->is_draft !== 1) {
            if (is_null($ad->project_id) && $ad->attributionAd?->ad_status_id !== AdStatus::APPROVE_ID) {
                if (!Auth::user()) {
                    abort(404);
                }

                if (!$moderatorInChargeOfModeration && $ad->user_pp_id !== auth()->user()->id) {
                    abort(404);
                }
            }
        } else {
            if (!Auth::user()) {
                abort(404);
            }

            if (!$moderatorInChargeOfModeration && $ad->user_pp_id !== auth()->user()->id) {
                abort(404);
            }
        }

        if ($ad->origin === "spip") {
            session()->now('warning',
                "Ceci est une annonce de l’ancien site de petites annonces,
                l’affichage peut être minimal car toutes les informations sont contenues dans les champs de textes libres."
            );
        }
        //Throw error 404 if a visitor try to show an ad is not validated
        //TODO display only ads who are not in draft mode and if  $ad->attributionAd->adStatus->name === "Validée" ;
        //TODO not display projects unless user logged is the author of the ad or the user logged is an supervisor or an advisor
        //session()->put('url.intended', URL::current());
        return view('pages.ads.show', $this->getShowVars($ad));
    }

    /**
     * @param int $adId
     * @return Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function oldshow($adId)
    {
        $ad = $this->adService->find($adId);

        $moderatorInChargeOfModeration = $this->attributionAdService->moderatorIsChargeOfAdModeration($ad);
        if ($ad->trashed()) {
            if ($moderatorInChargeOfModeration) {
                return view('errors.deleted_ad', compact('ad'));
            } else {
                abort(404);
            }
        }

        if (!isset($ad->user_pp_id)) {
            abort(404);
        }

        if ($ad->is_draft !== 1) {
            if (is_null($ad->project_id) && $ad->attributionAd->ad_status_id !== AdStatus::APPROVE_ID) {
                if (!Auth::user()) {
                    abort(404);
                }

                if (!$moderatorInChargeOfModeration && $ad->user_pp_id !== auth()->user()->id) {
                    abort(404);
                }
            }
        } else {
            if (!Auth::user()) {
                abort(404);
            }

            if (!$moderatorInChargeOfModeration && $ad->user_pp_id !== auth()->user()->id) {
                abort(404);
            }
        }

        if ($ad->origin === "spip") {
            session()->now('warning',
                "Ceci est une annonce de l’ancien site de petites annonces,
                l’affichage peut être minimal car toutes les informations sont contenues dans les champs de textes libres."
            );
        }

        //Throw error 404 if a visitor try to show an ad is not validated
        //TODO display only ads who are not in draft mode and if  $ad->attributionAd->adStatus->name === "Validée" ;
        //TODO not display projects unless user logged is the author of the ad or the user logged is an supervisor or an advisor
        //session()->put('url.intended', URL::current());
        return view('pages.ads.showv1', $this->getShowVars($ad));
    }

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function list()
    {
        $ads = $this->adService->findAllAdsByUser(auth()->id());
        return view('pages.ads.listUserAds', compact('ads'));
    }


    /**
     * @param Ad $ad
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Ad $ad)
    {
        if (!$ad->canEdit()) {
            abort(404);
        }
        $this->adService->delete($ad);
        if (is_null($ad->project_id)) {
            return redirect()->route('user.index')->with('success', 'Votre annonce a bien été supprimée');
        }

        return redirect()->route('user.index')->with('success', 'Votre demande d\'accomapgnement a été supprimée avec succès');
    }

    /**
     * @param Ad $ad
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function archive(Ad $ad)
    {
        if (!$ad->canEdit()) {
            abort(404);
        }
        $this->adService->archive($ad);
        if (is_null($ad->project_id)) {
            return back()->with('success', 'Votre annonce a bien été archivée');
        }
        return redirect()->route('user.index')->with('success', 'Votre demande d\'accomapgnement a été archivée avec succès');
    }

    /**
     * @param int $adId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extendPublish(int $adId)
    {
        $ad = $this->adService->find($adId);

        if (!$ad || $ad->user_pp_id !== auth()->id()) {
            abort(403);
        }

        if (!$ad->attributionAd->published_on) {
            return redirect()
                ->route('ads.show', ["id" => $ad->id])
                ->withErrors("Impossible d'étendre la durée de cette annonce, car elle n'est pas publiée.");
        }

        $ad->attributionAd->published_on = Carbon::now();
        $ad->attributionAd->save();

        return redirect()
            ->route('ads.show', ["id" => $ad->id])
            ->with("success", "La durée de publication de de votre annonce a été étendue de 6 mois.");
    }

    /**
     * @throws \Throwable
     */
    protected function store(AdRequest $request, $isDraft = 1) : Ad
    {
        $data = $request->validated();
        $data["is_draft"] = $isDraft;

        if ($isDraft) {
            $data['ad_status'] = AdStatus::PENDING_MODERATION_STATUS_ID;
        }
        $ad = $this->adService->store($data);

//        dd($ad);
        return $ad;
    }
}
