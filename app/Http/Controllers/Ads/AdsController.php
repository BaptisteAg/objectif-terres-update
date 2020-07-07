<?php

namespace App\Http\Controllers\Ads;

use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\User;
use App\Notifications\NewAdToModerateNotification;
use App\Presenters\AdPresenter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;


class AdsController extends BaseController
{
	public const PUBLISHED_AD_LIMIT_PER_USER = 5;

	/**
	 * Display the ad creation form
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('pages.ads.new', $this->getCreateFormVars());
	}

    /**
     * Display the ad edit form
     * @return \Illuminate\View\View
     * @throws \Exception
     */
	public function edit(int $id)
	{
	    $ad = $this->adService->find($id);

	    if(auth()->id() !== $ad->user_pp_id) {
	        return abort(404);
        }

        $selected_zones = json_encode(array_filter(array_merge(
            array_map($this->locationService->getResultRenderer('regions'), $ad->regions->toArray()),
            array_map($this->locationService->getResultRenderer('departments'), $ad->departments->toArray()),
            array_map($this->locationService->getResultRenderer('cities'), $ad->cities->toArray())
        )));
	    $locationable = array_filter([
	        "cities" => $ad->cities->pluck('id')->toArray(),
	        "departments" => $ad->departments->pluck('id')->toArray(),
	        "regions" => $ad->regions->pluck('id')->toArray()
        ]);
	    $locationable_radius = $ad->cities->count() ? $ad->cities->first()->radius : '';

	    $documents = $ad->documents->toJson();
	    $document_ids = $ad->documents->pluck("id")->toArray();

	    $vars = $this->getCreateFormVars();

	    if(!old('ad_type')) {
	        $vars["old"] = array_merge(
                [
                    'ad_type'        => $this->adService->getAdType($ad),

                    'land_seek'      => $ad->landSeekAd  ?
                        array_merge($ad->landSeekAd->toArray(),[
                            "buildings" => $ad->landSeekAd->buildings->pluck("requirement.id", "buildingType.id")->toArray(),
                            "production_genres" => $ad->landSeekAd->productionGenres->pluck("id")->toArray()
                        ]) : null,

                    'land_offer'     => $ad->landOfferAd ?
                        array_merge($ad->landOfferAd->toArray(),[
                            "bio_certifications" => $ad->landOfferAd->bioCertifications->pluck("id")->toArray(),
                            "production_genres" => $ad->landOfferAd->productionGenres->pluck("id")->toArray(),
                            "production_genres_wanted" => $ad->landOfferAd->productionGenresPossible->pluck("id")->toArray(),
                            "offer_genres" => $ad->landOfferAd->offerGenres->pluck("id")->toArray(),
                        ]) : null,

                    'job_offer'      => $ad->jobOfferAd  ?
                        array_merge($ad->jobOfferAd->toArray(),[
                            "offer_types" => $ad->jobOfferAd->jobOfferTypes->pluck("id")->toArray(),
                            "education_levels" => $ad->jobOfferAd->educationLevels->pluck("id")->toArray(),
                        ]) : null,

                    'job_seek'       => $ad->jobSeekAd   ?
                        array_merge($ad->jobSeekAd->toArray(),[
                            "offer_types" => $ad->jobSeekAd->jobOfferTypes->pluck("id")->toArray(),
                            "education_levels" => $ad->jobSeekAd->educationLevels->pluck("id")->toArray(),
                        ]) : null,
                ],
                $ad->only(["id", "title", "about_content", "about_project_content", "accept_share_contact_infos"]),
                compact("selected_zones", "locationable", "locationable_radius", "documents", "document_ids")
            );
        }

	    //dd($vars);

		return view('pages.ads.new', $vars);
	}

	/**
	 * @param AdRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function requestPublishing(AdRequest $request)
	{
	    /** @var User $user */
	    $user = auth()->user();
		$publishedAdsCount = $this->adService->getUserPublishedAdsCount($user);

		if ($publishedAdsCount >= self::PUBLISHED_AD_LIMIT_PER_USER) {
			return $this->store($request)
				->withErrors(
					"Vous ne pouvez publier que " . self::PUBLISHED_AD_LIMIT_PER_USER . " annonces en même temps.
                    Votre annonce a été sauvegardée mais ne sera pas soumise à modération."
				);
		}

		$data = $request->validated();

		/** @var $ad Ad $ad */
        try {
            $ad = $this->adService->requestPublishing($data);
            $ad->attributionAd->userModerator->notify(new NewAdToModerateNotification($ad, auth()->user()));
        }
        catch(\Exception $exception) {
            report($exception);
            if(env('APP_DEBUG')) {
                //throw $exception;
            }
            return back()->withInput()->withErrors($exception->getMessage());
        }

		return redirect()->route('ads.show', [$ad->id])
			->with('success', 'Votre annonce a bien été soumise à modération. Vous receverez une réponse très bientôt ! ');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function save(AdRequest $request)
	{
		return $this->store($request, 1)
			->with('success', 'Votre annonce a bien été sauvegardée.');
	}

	/**
	 * @param int $adId
	 * @return Factory|\Illuminate\View\View
	 * @throws \Exception
	 */
	public function show($adId)
	{
		$ad = $this->adService->find($adId);
		if (!isset($ad->userPp)) {
			return view('pages.errors.unavailable-page', ['message' => "Contacter un administrateur du site pour plus d'informations"]);
		}

		

		//Throw error 404 if a visitor try to show an ad is not validated
		//TODO display only ads who are not in draft mode and if  $ad->attributionAd->adStatus->name === "Validée" ;
		//TODO not display projects unless user logged is the author of the ad or the user logged is an supervisor or an advisor
		session()->put('url.intended', URL::current());
		return view('pages.ads.show', $this->getShowVars($ad));
	}

	/**
	 * @return Factory|\Illuminate\View\View
	 */
	public function list()
	{
		$ads = $this->adService->findAllByUser(auth()->id());
		return view('pages.ads.listUserAds', compact('ads'));
	}


	/**
	 * @param Ad $ad
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete(Ad $ad)
	{
		if ($ad->user_pp_id !== auth()->id()) {
			abort(404);
		}
		$this->adService->delete($ad);
		return back()->with('success', 'Votre annonce a bien été supprimée');
	}

	/**
	 * @param AdRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	protected function store(AdRequest $request, $isDraft = 1)
	{
		$data = $request->validated();

		$data["is_draft"] = $isDraft;

		$ad = $this->adService->store($data);

		return redirect()->route('ads.list', [$ad->id]);
	}
}
