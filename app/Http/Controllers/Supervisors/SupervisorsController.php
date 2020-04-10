<?php

namespace App\Http\Controllers\Supervisors;

use App\Exports\Supervisors\SupervisorExport;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Services\Ads\AdService;
use App\Services\Projects\ProjectService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class SupervisorsController extends Controller
{
	protected $threadService;
	protected $projectService;
	protected $userService;
	protected $adTypes;
	protected $adTypesFaIcons;
	protected $adService;

	/**
	 * AdvisorsController constructor.
	 * @param ProjectService $projectService
	 * @param ThreadService $threadService
	 * @param UserService $userService
	 */
	public function __construct(ProjectService $projectService, ThreadService $threadService, UserService $userService, AdService $adService)
	{
		$this->projectService = $projectService;
		$this->threadService = $threadService;
		$this->userService = $userService;
		$this->adService = $adService;
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
		$ads = $this->adService->findAllByUserSupervisor();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$notAssignProjectStatusId = ProjectStatus::where("name", '=', "Non accompagné")->first()->id;
		$numberOfNotAssignProject = $this->projectService->countNumberOfProjectsByStatusForLoggedUser($notAssignProjectStatusId);

		return view('pages.supervisors.index', compact('cities', 'adTypes', 'adTypesFaIcons', 'departments', 'productionGenres', 'projectStatuses', 'ads', 'jobOfferTypes', 'numberOfUnreadMessages', 'numberOfNotAssignProject'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();
		$ads = $this->adService->showForSupervisor($request);
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();
		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$notAssignProjectStatusId = ProjectStatus::where("name", '=', "Non accompagné")->first()->id;
		$numberOfNotAssignProject = $this->projectService->countNumberOfProjectsByStatusForLoggedUser($notAssignProjectStatusId);

		return view('pages.supervisors.index', compact('cities', 'departments', 'projectStatuses', 'adTypes', 'adTypesFaIcons', 'productionGenres', 'jobOfferTypes', 'ads', 'numberOfUnreadMessages', 'numberOfAdsToModerate', 'numberOfNotAssignProject'));

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

	/**
	 * Supervisor export data controller
	 * @param array $projects
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function export(Request $request)
	{
		dd($request->input());
		$dates = [];
		array_push($dates, DateTime::createFromFormat('d/m/Y', (string)$request->input('date_research_range'))->format('Y-m-d')
	);

		$ads = $this->adService->findAllByUserSupervisorBetweenDates($dates);
		return Excel::download(new SupervisorExport($ads), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_y') . '.xlsx');
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function attribute(Request $request)
	{
		$this->projectService->attributeProject($request);
		return back()->with('success', 'Le projet à bien été attribué !');
	}


}
