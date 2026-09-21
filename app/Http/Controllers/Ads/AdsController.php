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
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;


class  AdsController extends BaseController
{
    public const PUBLISHED_AD_LIMIT_PER_USER = 50;

    /**
     * Vrai lorsque le dernier store() portait sur une annonce déjà en ligne.
     * @var bool
     */
    protected $updatedAnOnlineAd = false;

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

        // Une annonce en ligne modifiée repart en modération et n'est plus publique : on renvoie
        // vers sa page (visible du seul propriétaire) avec le message adéquat, pas vers la preview.
        if ($this->updatedAnOnlineAd) {
            return redirect()->route('ads.show', ["id" => $ad->id])
                ->with('success', 'Vos modifications ont été soumises à modération. Votre annonce ne sera plus visible publiquement le temps de la re-validation.');
        }

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
    public function edit(int $id): \Illuminate\View\View
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

        // Une annonce déjà en ligne repart en modération (et n'est plus publique) sans passer par
        // le circuit de première publication.
        if ($ad->attributionAd && $ad->attributionAd->isOnline()) {
            $this->adService->flagPendingUpdate($ad);

            return redirect()->route('ads.show', [$ad->id])
                ->with('success', 'Vos modifications ont été soumises à modération. Votre annonce ne sera plus visible publiquement le temps de la re-validation.');
        }

        /** @var $ad Ad $ad */
        try {
            $ad = $this->adService->requestPublishing($ad);

        } catch (\Exception $exception) {

            $exceptionMessage = "[51] Désolé, une erreur s'est produite. Nous avons été informé du problème.";

            if (is_a($exception, AttributionAdException::class)) {
                $exceptionMessage = $exception->getMessage();
            }

            report($exception);
            if (config('app.env') !== 'production') {
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

            if ($this->updatedAnOnlineAd) {
                return redirect()->route('ads.show', ["id" => $ad->id])
                    ->with('success', 'Vos modifications ont été soumises à modération. Votre annonce ne sera plus visible publiquement le temps de la re-validation.');
            }

            return redirect()->route('ads.list', [$ad->id])->with('success', 'Votre annonce a bien été sauvegardée.');
        } catch (HttpException $exception) {
            // Les abort() (403 sur une annonce qui n'appartient pas à l'utilisateur) doivent
            // remonter tels quels, et non être transformés en message d'erreur générique.
            throw $exception;
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
        if ($ad->trashed() || !$ad->userPp) {
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

            return redirect()->route('user.index')
                ->with('success', 'Votre annonce a bien été supprimée');
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
            $formUrl = Ad::SALESFORCE_FORM_BY_AD_TYPE[$ad->type] ?? '';

            return back()
                ->with('success', 'Votre annonce a bien été archivée')
                ->with('display_survey', $formUrl);
        }
        return redirect()->route('user.index')->with('success', 'Votre demande d\'accomapgnement a été archivée avec succès');
    }


    /**
     * Republish an archived ad
     *
     * @param Ad $ad
     * @return \Illuminate\Http\RedirectResponse
     */
    public function republish(Ad $ad)
    {
        if (!$ad->canEdit()) {
            abort(404);
        }

        if (!$ad->isArchived()) {
            return back()->with('error', 'Cette annonce n\'est pas archivée');
        }

        $this->adService->republish($ad);

        return back()->with('success', 'Votre annonce a été republiée avec succès');
    }

    /**
     * Handle survey submission before archive or delete
     *
     * @param \Illuminate\Http\Request $request
     * @param Ad $ad
     * @param string $action
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function survey(\Illuminate\Http\Request $request, Ad $ad, string $action)
    {
        // Check if user can edit this ad
        if (!$ad->canEdit()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate action
        if (!in_array($action, ['archive', 'delete'])) {
            return response()->json(['error' => 'Invalid action'], 400);
        }

        // Validate survey response
        $request->validate([
            'survey_success_via_platform' => 'required|in:oui,non',
            'survey_comments' => 'nullable|string|max:5000'
        ]);

        // Store survey data
        $ad->survey_success_via_platform = $request->input('survey_success_via_platform');
        $ad->survey_comments = $request->input('survey_comments');
        $ad->survey_submitted_at = now();
        $ad->save();

        // Execute the action (archive or delete)
        if ($action === 'archive') {
            $this->adService->archive($ad);
            $message = 'Votre annonce a bien été archivée';
        } else {
            $this->adService->delete($ad);
            $message = 'Votre annonce a bien été supprimée';
        }

        // Return success with redirect
        return response()->json([
            'success' => true,
            'message' => $message,
            'redirect' => route('ads.list')
        ]);
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
    protected function store(AdRequest $request, $isDraft = 1): Ad
    {
        $data = $request->validated();
        $data["is_draft"] = $isDraft;

        $onlineAd = $this->findOnlineAdForUpdate($data["id"] ?? null);
        $this->updatedAnOnlineAd = (bool)$onlineAd;

        // Une annonce en ligne ne doit jamais être dépubliée par un simple enregistrement :
        // elle reste visible et repasse en file de modération (cf. show() et flagPendingUpdate()).
        if ($onlineAd) {
            $data["is_draft"] = 0;
        }

        if ($data["is_draft"]) {
            $data['ad_status'] = AdStatus::PENDING_MODERATION_STATUS_ID;
        }

        $ad = $this->adService->store($data);

        if ($onlineAd) {
            $this->adService->flagPendingUpdate($ad);
        }

        return $ad;
    }

    /**
     * Retourne l'annonce ciblée par une mise à jour si elle est actuellement en ligne, sinon null.
     *
     * @param int|string|null $adId
     */
    protected function findOnlineAdForUpdate($adId): ?Ad
    {
        if (empty($adId)) {
            return null;
        }

        $ad = $this->adService->find((int)$adId);

        if (!$ad->canEdit()) {
            abort(403);
        }

        return $ad->attributionAd && $ad->attributionAd->isOnline() ? $ad : null;
    }
}
