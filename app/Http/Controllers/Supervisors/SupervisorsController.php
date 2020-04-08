<?php

namespace App\Http\Controllers\Supervisors;

use App\Http\Controllers\Controller;
use App\Models\AdStatus;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
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
		$projects = $this->projectService->findAllByUserSupervisor();
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$notAssignProjectStatusId = ProjectStatus::where("name", '=', "Non accompagné")->first()->id;
		$numberOfNotAssignProject = $this->projectService->countNumberOfProjectsByStatusForLoggedUser($notAssignProjectStatusId);


		return view('pages.supervisors.index', compact('cities', 'adTypes', 'adTypesFaIcons', 'departments', 'productionGenres', 'projectStatuses', 'projects', 'jobOfferTypes', 'numberOfUnreadMessages', 'numberOfNotAssignProject'));
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

		$projects = $this->projectService->showForSupervisor($request);
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$notAssignProjectStatusId = ProjectStatus::where("name", '=', "Non accompagné")->first()->id;
		$numberOfNotAssignProject = $this->projectService->countNumberOfProjectsByStatusForLoggedUser($notAssignProjectStatusId);

		return view('pages.supervisors.index', compact('cities', 'departments', 'projectStatuses', 'adTypes', 'adTypesFaIcons', 'productionGenres', 'jobOfferTypes', 'projects', 'numberOfUnreadMessages', 'numberOfAdsToModerate', 'numberOfNotAssignProject'));

	}

	/**
	 * Supervisors help area controller
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function help()
	{
		$users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
		return view('pages.supervisors.help', compact('users'));
	}


	public function attribute(Request $request)
	{
		$this->projectService->attributeProject($request);
		return back()->with('success', 'Le projet à bien été attribué !');
	}
}
