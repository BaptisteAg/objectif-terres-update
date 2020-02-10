<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Repositories\Ads\AdRepository;
use App\Http\Requests\Ads\AdRequest;
use App\Models\Ad;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\City;
use App\Models\Department;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobStatus;
use App\Models\OfferGenre;
use App\Models\PriceRange;
use App\Models\ProductionGenre;
use App\Models\Region;
use App\Models\SurfaceRange;
use App\Repositories\FavoriteAds\FavoriteAdRepository;
use App\Services\AdMessages\AdMessagesService;
use App\Services\Ads\AdService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class AdsController extends Controller
{
	/**
	 * @var AdService
	 */
	protected $adService;
	protected $adMessageService;
	protected $favoriteAdRepository;

	public function __construct(AdService $adService, AdMessagesService $adMessageService, FavoriteAdRepository $favoriteAdRepository)
	{
		$this->adService = $adService;
		$this->adMessageService = $adMessageService;
		$this->favoriteAdRepository = $favoriteAdRepository;

	}

	public function create()
	{
		$surfaceRanges = SurfaceRange::all();
		$priceRanges = PriceRange::all();
		$installationTypes = InstallationType::all();
		$bioCertifications = BioCertification::all();
		$jobStatus = JobStatus::all();
		$offerGenres = OfferGenre::all();
		$offerGenresLandSeek = OfferGenre::where('offer_genre_model', 'LandSeekAd')->get();
		$offerGenresHouse = OfferGenre::where('offer_genre_model', 'House')->get();
		$offerGenresBuilding = OfferGenre::where('offer_genre_model', 'Building')->get();
		$offerGenresLand = OfferGenre::where('offer_genre_model', 'Land')->get();
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$productionGenres = ProductionGenre::all();
		$agriculturalActivities = AgriculturalActivity::all();
		$educationLevels = EducationLevel::all();


		return view('pages.ads.new', compact(
			'installationTypes',
			'surfaceRanges',
			'priceRanges',
			'bioCertifications',
			'jobStatus',
			'offerGenres',
			'cities',
			'departments',
			'regions',
			'offerGenresLandSeek',
			'offerGenresHouse',
			'offerGenresBuilding',
			'offerGenresLand',
			'productionGenres',
			'agriculturalActivities',
			'educationLevels',
			'productionGenres',
			'agriculturalActivities',
			'educationLevels'
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

		$ad = $this->adService->create($data);

		return redirect()->route('ads.show', [$ad->id]);
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

	public function show(int $adId)
	{
		$ad = $this->adService->find($adId);

		if (Auth::user()) {
			//if the user connected has send a response to an ad, get the first message
			$userMessage = $this->adMessageService->findByUserAndAd((auth()->user()->id), $adId);

			$data = array(
				"ad_id" => $adId,
				"user_id" => auth()->user()->id,
			);
			$favoriteAdAlreadyExist = $this->favoriteAdRepository->findByUserAndAdId($data);

		}

		return view('pages.ads.show', compact('ad', 'userMessage', 'favoriteAdAlreadyExist'));
	}

	public function list()
	{

		$ads = $this->adService->findAllByUser(auth()->user()->id);
		return view('pages.ads.listUserAds', compact('ads'));
	}
}
