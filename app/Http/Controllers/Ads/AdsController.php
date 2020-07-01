<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\BuildingType;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobOfferType;
use App\Models\OfferGenre;
use App\Models\RefusalType;
use App\Models\Requirement;
use App\Models\ResponseTemplate;
use App\Models\SurfaceRange;
use App\Notifications\NewAdToModerateNotification;
use App\Repositories\FavoriteAds\FavoriteAdRepository;
use App\Services\Ads\AdService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class AdsController extends BaseController
{
	public const PUBLISHED_AD_LIMIT_PER_USER = 3;

	/**
	 * Display the ad creation form
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('pages.ads.new', $this->getCreateFormVars());
	}

	/**
	 * @param AdRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function requestPublishing(AdRequest $request)
	{
		$numberOfAdsPublishedToday = auth()->user()->ads()->whereHas('attributionAd', function (Builder $builder) {
			$builder->where('created_at', '=', Carbon::now());
		})->count();

		if ($numberOfAdsPublishedToday >= self::PUBLISHED_AD_LIMIT_PER_USER) {
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

		//Throw error 404 if a visitor try to show an ad is not validated
		//TODO display only ads who are not in draft mode and if  $ad->attributionAd->adStatus->name === "Validée" ;
		//TODO not display projects unless user logged is the author of the ad or the user logged is an supervisor or an advisor
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
	protected function store(AdRequest $request, $isDraft = 0)
	{
		$data = $request->validated();

		$ad = $this->adService->create($data);

		if ($isDraft) {
			$ad->is_draft = 1;
			$ad->save();
		}

		return redirect()->route('ads.show', [$ad->id]);
	}
}
