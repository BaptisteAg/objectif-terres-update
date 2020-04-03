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
use App\Services\Projects\ProjectService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Http\Request;


class SupervisorsController extends Controller
{
	protected $threadService;
	protected $projectService;
	protected $userService;
	protected $adTypes;
	protected $adTypesFaIcons;

	/**
	 * AdvisorsController constructor.
	 * @param ProjectService $projectService
	 * @param ThreadService $threadService
	 * @param UserService $userService
	 */
	public function __construct(ProjectService $projectService, ThreadService $threadService, UserService $userService)
	{
		$this->projectService = $projectService;
		$this->threadService = $threadService;
		$this->userService = $userService;
		$this->adTypes = [
			['name' => 'Offre foncière', 'value' => 'landOfferAd'],
			['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
		];
		$this->adTypesFaIcons = ["fa-home", "fa-home"];
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();
		$projectAds = $this->projectService->findAllByUserSupervisor();
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons =$this->adTypesFaIcons;

		return view('pages.supervisors.index', compact('cities', 'adTypes', 'adTypesFaIcons', 'departments', 'productionGenres', 'projectStatuses', 'projectAds', 'jobOfferTypes', 'numberOfUnreadMessages'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();

		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();

		$projectAds = $this->projectService->showForSupervisor($request);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons =$this->adTypesFaIcons;

		return view('pages.supervisors.index', compact('cities', 'departments', 'projectStatuses', 'adTypes', 'adTypesFaIcons', 'productionGenres', 'jobOfferTypes', 'projectAds', 'numberOfUnreadMessages', 'numberOfAdsToModerate'));

	}

	/**
	 * Supervisors help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser()) ;
		return view('pages.moderator.help', compact('users'));
	}
}
