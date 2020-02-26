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
use App\Services\Threads\ThreadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomePageModeratorController extends Controller
{
	protected $service;
	protected $threadService;


	public function __construct(AttributionAdsService $attributionAdsService, ThreadService $threadService)
	{
		$this->service = $attributionAdsService;
		$this->threadService = $threadService;
	}

	public function index(Request $request)
	{
		if (auth()->user()->role < 2 ) {
			abort(404);
		}

		dump($request->input());

		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$ads = $this->service->findAllByUserModerator(auth()->user()->id);

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();

		return view('pages.moderator.index', compact( 'cities', 'departments', 'regions','projectStatuses', 'adStatuses', 'productionGenres','jobOfferTypes', 'ads', 'numberOfUnreadMessages'));

	}
}