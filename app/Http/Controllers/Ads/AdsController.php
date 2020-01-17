<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
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


class AdsController extends Controller
{
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


		return view('pages.ads.new', compact('installationTypes',
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
			'educationLevels'));
	}

	/**
	 * @param AdRequest $request
	 * @param AdService $adService
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Throwable
	 */
	public function store(AdRequest $request, AdService $adService)
	{
		$data = $request->validated();

		$ad = $adService->create($data);

		return redirect('/annonces/' . $ad->id);
	}

	public function show($id)
	{
		$ad = Ad::where('id', $id)->first();

		if ($ad->jobAd()->exists()){
			$jobAd  = $ad;
			return view('pages.ads.show', compact('jobAd'));
		} else if ($ad->landSeekAd()->exists()) {
			$landSeekAd  = $ad;
			return view('pages.ads.show', compact('landSeekAd'));
		} else if ($ad->landOfferAd()->exists()){
			$landOfferAd  = $ad;
			return view('pages.ads.show', compact('landOfferAd'));
		}
	}
}
