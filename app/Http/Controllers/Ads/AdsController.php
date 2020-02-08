<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\AdRequest;
use App\Models\AgriculturalActivity;
use App\Models\BioCertification;
use App\Models\EducationLevel;
use App\Models\InstallationType;
use App\Models\JobStatus;
use App\Models\OfferGenre;
use App\Models\PriceRange;
use App\Models\ProductionGenre;
use App\Models\SurfaceRange;
use App\Services\AdMessages\AdMessagesService;
use App\Services\Ads\AdService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Request;


class AdsController extends Controller
{
    /**
     * @var AdService
     */
    protected $adService;
    protected $adMessageService;

    public function __construct(AdService $adService, AdMessagesService $adMessageService)
    {
        $this->adService = $adService;
		$this->adMessageService = $adMessageService;
    }

    /**
     * @return \Illuminate\View\View
     */
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

		return redirect()->route('ads.show', [$ad->id])->with('success', 'Votre annonce a bien été publiée.');
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
        return view('pages.ads.show', compact('ad'));
	}

    /**
     * @return Factory|\Illuminate\View\View
     */
    public function list()
	{
		$ads = $this->adService->findAllByUser(auth()->id());

		return view('pages.ads.listUserAds', compact('ads'));
	}
}
