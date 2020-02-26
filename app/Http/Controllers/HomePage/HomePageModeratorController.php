<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\AdStatus;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Services\AttributionAds\AttributionAdsService;
use Illuminate\Http\Request;

class HomePageModeratorController extends Controller
{
	protected $service;


	public function __construct(AttributionAdsService $attributionAdsService)
	{
		$this->service = $attributionAdsService;
	}

	public function index(Request $request)
	{
		if (auth()->user()->role < 2 ) {
			abort(404);
		}

		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$ads = $this->service->findAllByUserModerator(auth()->user()->id);

		return view('pages.moderator.index', compact( 'cities', 'departments', 'regions','projectStatuses', 'adStatuses', 'productionGenres','jobOfferTypes', 'ads'));

	}
}