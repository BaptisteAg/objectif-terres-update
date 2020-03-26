<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
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
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class AdsController extends Controller
{
	/**
	 * @var AdService
	 */
	protected $adService;
	protected $threadService;
	protected $favoriteAdRepository;

	public function __construct(AdService $adService, ThreadService $threadService, FavoriteAdRepository $favoriteAdRepository)
	{
		$this->adService = $adService;
		$this->threadService = $threadService;
		$this->favoriteAdRepository = $favoriteAdRepository;

	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		$surfaceRanges = SurfaceRange::all();
		$installationTypes = InstallationType::all();
		$bioCertifications = BioCertification::all();
		$jobOfferTypes = JobOfferType::all();
		$offerGenres = OfferGenre::all();
		$agriculturalActivities = AgriculturalActivity::all();
		$educationLevels = EducationLevel::all();
		$buildingTypes = BuildingType::all();
		$requirements = Requirement::all();
		$productionGenres = $this->adService->getProductionGenresFlattened();
		$productionGenresWithOther = clone $this->adService->getProductionGenresFlattened()
			->concat([[
				'id' => 'other',
				'name' => 'Autre',
				'children' => []
			]]);

		return view('pages.ads.new', compact(
			'installationTypes',
			'surfaceRanges',
			'bioCertifications',
			'jobOfferTypes',
			'offerGenres',
			'educationLevels',
			'productionGenres',
			'productionGenresWithOther',
			'agriculturalActivities',
			'buildingTypes',
			'requirements'
		));
	}

	/**
	 * @param AdRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function store(AdRequest $request)
	{
		$data = $request->validated();

		/** @var $ad Ad $ad */
		$ad = $this->adService->create($data);
		$ad->attributionAd->userModerator->notify(new NewAdToModerateNotification($ad, auth()->user()));


		return redirect()->route('ads.show', [$ad->id])->with('success', 'Votre annonce a bien été soumise à modération. Vous receverez une réponse très bientôt ! ');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function saveDraft(Request $request)
	{
		$data = $request->all();

		$ad = $this->adService->create($data);

		return redirect()->route('ads.show', [$ad->id]);
	}

	/**
	 * @param int $adId
	 * @return Factory|\Illuminate\View\View
	 */
	public function show(int $adId)
	{

		$ad = $this->adService->find($adId);
		$userMessage = null;
		$favoriteAdAlreadyExist = false;
		$threads = [];
		$threadsWithUnreadMessages = null;
		$responseTemplates = '';
		$refusalTypes = '';
		$isAdToModerate = false;
		$isLoggedUserModeratorAd = false;


		if (Auth::user()) {
			if ($ad->attributionAd->adStatus->id === 4) {
				$isAdToModerate = true;
			}
			if (auth()->user()->id === $ad->attributionAd->user_moderator_id) {
				$isLoggedUserModeratorAd = true;
				//set to read if notification about moderation task about the ad exist
				if (!auth()->user()->unreadNotifications->isEmpty()) {
					$notification = auth()->user()->unreadNotifications()->where('data->ad_id', $ad->id)->first();
					if (!is_null($notification)) {
						$notification->markAsRead();
						$notification->delete();
					}
				}
			}
			if (auth()->user()->id === $ad->user_pp_id) {
				$threads = $this->threadService->findThreadsByAd($adId);
				$threadsWithUnreadMessages = $this->threadService->findThreadsByUnreadMessageAndAdId($ad->id);
			} else {
				if (auth()->user()->role === 1) {
					$responseTemplates = ResponseTemplate::all();
					$refusalTypes = RefusalType::all();
				}
				$threads = $this->threadService->findThreadAlreadyExist($adId);
				$data = array(
					"ad_id" => $adId,
					"user_id" => auth()->user()->id,
				);
				$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);
			}

		}

		//Throw error 404 if a visitor try to show an ad is not validated
		//TODO display only ads who are not in draft mode and if  $ad->attributionAd->adStatus->name === "Validé" ;

		return view('pages.ads.show', compact('ad', 'userMessage', 'favoriteAdAlreadyExist', 'threads', 'threadsWithUnreadMessages', 'responseTemplates', 'refusalTypes', 'isAdToModerate', 'isLoggedUserModeratorAd'));
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
}
