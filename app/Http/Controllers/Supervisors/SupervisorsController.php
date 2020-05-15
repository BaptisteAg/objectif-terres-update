<?php

namespace App\Http\Controllers\Supervisors;

use App\Exports\Supervisors\SupervisorsExport;
use App\Http\Controllers\Controller;
use App\Models\BioCertification;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectDataKey;
use App\Models\ProjectStatus;
use App\Models\SupportStage;
use App\Models\SupportState;
use App\Services\Ads\AdService;
use App\Services\Projects\ProjectService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\RedirectResponse;
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
			['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
			['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
		];
		$this->adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access"];
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$request->session()->forget('_old_input');
		$ads = $this->adService->findAllByUserSupervisor(true);
		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$jobOfferTypes = JobOfferType::all();
		$productionGenres = ProductionGenre::all();
		$bioCertifications = BioCertification::all();

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$firstContactSupportStage = SupportStage::where("id", '=', SupportStage::FIRST_CONTACT_ID)->first()->id;
		$numberOfNotAssignProject = $this->projectService->countNumberOfProjectsBySupportStageForLoggedUser($firstContactSupportStage);

		return view('pages.supervisors.index', compact('adTypes', 'adTypesFaIcons', 'supportStages', 'supportStates', 'projectStatuses', 'ads', 'jobOfferTypes', 'productionGenres', 'bioCertifications', 'numberOfUnreadMessages', 'numberOfNotAssignProject'));
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(Request $request)
	{
		$request->flash();
		$ads = $this->adService->showForSupervisor($request);
		$supportStages = SupportStage::all();
		$supportStates = SupportState::all();
		$projectStatuses = ProjectStatus::all();
		$productionGenres = ProductionGenre::all();
		$jobOfferTypes = JobOfferType::all();
		$productionGenres = ProductionGenre::all();
		$bioCertifications = BioCertification::all();

		$numberOfUnreadMessages = $this->threadService->countAllUnreadMessagesInThreadsByLoggedUser();
		$adTypes = $this->adTypes;
		$adTypesFaIcons = $this->adTypesFaIcons;
		$firstContactSupportStage = SupportStage::where("id", '=', SupportStage::FIRST_CONTACT_ID)->first()->id;
		$numberOfNotAssignProject = $this->projectService->countNumberOfProjectsBySupportStageForLoggedUser($firstContactSupportStage);

		return view('pages.supervisors.index', compact('projectStatuses', 'supportStages', 'supportStates', 'adTypes', 'adTypesFaIcons', 'productionGenres', 'jobOfferTypes','productionGenres', 'bioCertifications', 'ads', 'numberOfUnreadMessages', 'numberOfNotAssignProject'));
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
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function export(Request $request)
	{
		if (is_null($request->input('date_from')) && is_null($request->input('date_from'))) {
			return Excel::download(new SupervisorsExport($this->adService->findAllByUserSupervisor(false)), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_y') . '.xlsx');
		} else {
			$dates = [
				DateTime::createFromFormat('d/m/Y', (string)$request->input('date_from'))->format('Y-m-d'),
				DateTime::createFromFormat('d/m/Y', (string)$request->input('date_to'))->format('Y-m-d')
			];
			$ads = $this->adService->findAllByUserSupervisorBetweenDates($dates);
			return Excel::download(new SupervisorsExport($ads), 'export_tableau_de_bord_' . Carbon::now()->format('d_m_y') . '.xlsx');
		}
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function attribute(Request $request)
	{
		$this->projectService->attributeProject($request);
		return back()->with('success', 'La demande d\'accompagnement a bien été attribué !');
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function report()
	{
		$ads = $this->adService->findAllAdsInSupervisorTerritories();
		$numberOfAds = $ads->count();
		$numberOfAdsByCategories = $this->adService->countAdsByCategories($ads);
		$percentageOfAdsByAdStatus = $this->adService->calculatePercentageOfAdsByAdStatus($ads);
		$numberOfValidateAds = $this->adService->findAllValidateAdsInSupervisorTerritories()->count();
		$numberOfUsersPp = $this->adService->findAllAdsAndProjectsGroupByUserPp()->count();

		$projects = $this->projectService->findAllProjectsBySupervisor();
		$numberOfProjects = $projects->count();
		$numberOfProjectsByCategories = $this->projectService->countProjectsByCategories($projects);
		$percentageOfProjectsByProjectStatus = $this->projectService->calculatePercentageOfProjectsByProjectStatus($projects);
		return view('pages.supervisors.report', compact('numberOfAds', 'numberOfValidateAds', 'numberOfUsersPp', 'numberOfProjects', 'numberOfAdsByCategories', 'numberOfProjectsByCategories', 'percentageOfAdsByAdStatus', 'percentageOfProjectsByProjectStatus'));
	}


	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function projectKeysDataEdit()
	{
		$allProjectDataKeys = ProjectDataKey::all();
		return view('pages.supervisors.project-data-keys-edit', compact('allProjectDataKeys'));
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function projectDataKeysCreate(Request $request)
	{
		if (empty($request->input('project_data_key_name')) && empty($request->input('is_project_data_key_public'))) {
			return back()->with('error', 'Erreur dans la création d\'un nouvel indicateur, veuillez réessayer.');
		}
		$this->projectService->createProjectDataKey($request);
		return back()->with('success', 'La liste des indicateurs a bien été mise à jour !');
	}

	/**
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function projectDataKeyDelete(Request $request){
		if (empty($request->input('project_data_key_id'))) {
			return back()->with('error', 'Aucun indicateur a été choisi');
		}
		$this->projectService->deleteProjectDataKey($request);
		return back()->with('success', 'La liste des indicateurs a bien été mise à jour !');
	}

}
