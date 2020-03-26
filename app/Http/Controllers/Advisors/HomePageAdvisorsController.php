<?php

namespace App\Http\Controllers\Advisors;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomePageAdvisorsController extends Controller
{
	protected $threadService;
	protected $attributionAdService;

	/**
	 * HomePageAdvisorsController constructor.
	 * @param AttributionAdsService $attributionAdsService
	 * @param ThreadService $threadService
	 */
	public function __construct(AttributionAdsService $attributionAdsService, ThreadService $threadService)
	{
		$this->attributionAdService = $attributionAdsService;
		$this->threadService = $threadService;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		if (auth()->user()->role !== 2) {
			abort(404);
		}

		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = AttributionAd::paginate(15);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();

		return view('pages.advisor.index', compact('cities', 'departments', 'regions',  'productionGenres', 'projectStatuses', 'attributionAds', 'jobOfferTypes', 'numberOfUnreadMessages'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		if (auth()->user()->role !== 2) {
			abort(404);
		}
		$request->flash();

		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = $this->attributionAdService->showForAdvisors($request);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();

		return view('pages.advisors.index', compact('cities', 'departments', 'regions', 'projectStatuses', 'productionGenres', 'jobOfferTypes', 'attributionAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}



}
