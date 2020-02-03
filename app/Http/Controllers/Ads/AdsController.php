<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
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
use App\Services\Ads\AdService;
use Illuminate\Support\Facades\Request;


class AdsController extends Controller
{
    /**
     * @var AdService
     */
    protected $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
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

        return view('pages.ads.show', compact('ad'));
	}
}
