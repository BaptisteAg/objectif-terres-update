<?php

namespace App\Http\Controllers\Advisors;

use App\Http\Controllers\Controller;
use App\Models\AttributionAd;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;


class AdvisorsController extends Controller
{
	protected $threadService;
	protected $attributionAdService;
	protected $userService;

	/**
	 * AdvisorsController constructor.
	 * @param AttributionAdsService $attributionAdsService
	 * @param ThreadService $threadService
	 * @param UserService $userService
	 */
	public function __construct(AttributionAdsService $attributionAdsService, ThreadService $threadService, UserService $userService)
	{
		$this->attributionAdService = $attributionAdsService;
		$this->threadService = $threadService;
		$this->userService = $userService;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{

		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();
		$attributionAds = AttributionAd::paginate(15);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();

		return view('pages.advisors.index', compact('cities', 'departments', 'regions',  'productionGenres', 'projectStatuses', 'attributionAds', 'jobOfferTypes', 'numberOfUnreadMessages'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
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

	/**
	 * Advisors help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser()) ;
		return view('pages.moderator.help', compact('users'));
	}
}
