<?php

namespace App\Http\Controllers\Ads;

use App\Models\BioCertification;
use App\Models\City;
use App\Models\Department;
use App\Models\InstallationType;
use App\Models\JobStatus;
use App\Models\OfferGenre;
use App\Models\PriceRange;
use App\Models\Region;
use App\Models\SurfaceRange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
		$offerGenresLandSeek= OfferGenre::where('offer_genre_model', 'LandSeekAd' )->get();
		$offerGenresHouse= OfferGenre::where('offer_genre_model', 'House' )->get();
		$offerGenresBuilding= OfferGenre::where('offer_genre_model', 'Building' )->get();
		$offerGenresLand= OfferGenre::where('offer_genre_model', 'Land' )->get();
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();

		return view('pages.ads.new', compact('installationTypes', 'surfaceRanges', 'priceRanges', 'bioCertifications','jobStatus','offerGenres', 'cities', 'departments', 'regions','offerGenresLandSeek', 'offerGenresHouse', 'offerGenresBuilding', 'offerGenresLand'));
	}
	public function store(Request $request)
	{
//		return 'Le nom est ' . $request->input('nom');
		return view('pages.ads.new');
	}
}
