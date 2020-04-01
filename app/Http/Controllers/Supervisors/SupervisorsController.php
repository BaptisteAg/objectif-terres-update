<?php

namespace App\Http\Controllers\Supervisors;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;


class SupervisorsController extends Controller
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
		$user = User::find(auth()->id());
		if ($user->zipCode){
			$regionCode = Department::where('code', $user->zipCode->department_code)->pluck('region_code')->first();
			$departments = Department::where('region_code', $regionCode)->get();
			$cities = City::where('department_code', $user->zipCode->department_code)->get();
		}else{
			$departments = Department::all();
			$cities = City::all();
		}
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = $this->attributionAdService->findAllByUserSupervisor();
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();

		return view('pages.supervisors.index', compact('cities', 'departments', 'productionGenres', 'projectStatuses', 'attributionAds', 'jobOfferTypes', 'numberOfUnreadMessages'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();

		$user = User::find(auth()->id());

		$regionCode = Department::where('code', $user->zipCode->department_code)->pluck('region_code')->first();
		$departments = Department::where('region_code', $regionCode)->get();

		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = $this->attributionAdService->showForSupervisor($request);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();

		return view('pages.supervisors.index', compact('cities', 'departments', 'projectStatuses', 'productionGenres', 'jobOfferTypes', 'attributionAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}

	/**
	 * Supervisors help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPP()) ;
		return view('pages.moderator.help', compact('users'));
	}
}
