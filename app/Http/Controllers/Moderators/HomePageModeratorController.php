<?php

namespace App\Http\Controllers\Moderators;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Collection;

class HomePageModeratorController extends Controller
{
	protected $service;
	protected $threadService;


	/**
	 * HomePageModeratorController constructor.
	 * @param AttributionAdsService $attributionAdsService
	 * @param ThreadService $threadService
	 */
	public function __construct(AttributionAdsService $attributionAdsService, ThreadService $threadService)
	{
		$this->service = $attributionAdsService;
		$this->threadService = $threadService;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = $this->service->findAllByUserModerator(auth()->user()->id);

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfAdsToModerate = $this->service->countAllAdsToModerateForLoggedModerator();

		return view('pages.moderator.index', compact('cities', 'departments', 'regions', 'projectStatuses', 'adStatuses', 'productionGenres', 'jobOfferTypes', 'attributionAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}

	public function show(Request $request)
	{

		$request->flash();

		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = $this->service->showForModerators($request);

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfAdsToModerate = $this->service->countAllAdsToModerateForLoggedModerator();
		if (count($attributionAds) === 0) {
			return redirect()->route('moderator.index')->with('warning', 'Aucun résultat pour votre recherche');
		}

		return view('pages.moderator.index', compact('cities', 'departments', 'regions', 'projectStatuses', 'adStatuses', 'productionGenres', 'jobOfferTypes', 'attributionAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}
}