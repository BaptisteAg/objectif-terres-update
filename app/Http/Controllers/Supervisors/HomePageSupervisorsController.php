<?php

namespace App\Http\Controllers\Supervisors;

use App\Http\Controllers\Controller;
use App\Models\AttributionAd;
use App\Models\City;
use App\Models\Department;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\Region;
use App\Models\User;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Threads\ThreadService;
use Illuminate\Http\Request;


class HomePageSupervisorsController extends Controller
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
		if (auth()->user()->role !== 3) {
			abort(404);
		}
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
		if (auth()->user()->role !== 3) {
			abort(404);
		}
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


}
