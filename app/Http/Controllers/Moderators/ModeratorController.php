<?php

namespace App\Http\Controllers\Moderators;

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
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
	protected $service;
	protected $threadService;
	protected $userService;
	protected $adTypes;
	protected $adTypesFaIcons;

	/**
	 * ModeratorController constructor.
	 * @param AttributionAdsService $attributionAdsService
	 * @param ThreadService $threadService
	 */
	public function __construct(AttributionAdsService $attributionAdsService, ThreadService $threadService, UserService $userService)
	{
		$this->service = $attributionAdsService;
		$this->threadService = $threadService;
		$this->userService = $userService;
		$this->adTypes = [
			['name' => 'Offre foncière', 'value' => 'landOfferAd'],
			['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
			['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
			['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
		];
		$this->adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access"];
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();
		$attributionAds = $this->service->findAllByUserModeratorTerritories();

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfAdsToModerate = $this->service->countAllAdsToModerateForLoggedModerator();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;

		return view('pages.moderator.index', compact('adTypesFaIcons', 'adTypes', 'cities', 'departments', 'regions', 'adStatuses', 'productionGenres', 'jobOfferTypes', 'attributionAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();
		$cities = City::all();
		$departments = Department::all();
		$regions = Region::all();
		$adStatuses = AdStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$attributionAds = $this->service->showForModerators($request);

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$numberOfAdsToModerate = $this->service->countAllAdsToModerateForLoggedModerator();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;

		return view('pages.moderator.index', compact('adTypesFaIcons', 'adTypes', 'cities', 'departments', 'regions', 'adStatuses', 'productionGenres', 'jobOfferTypes', 'attributionAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}

	/**
	 * Moderator help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
		return view('pages.moderator.help', compact('users'));
	}


}