<?php


namespace App\Http\Controllers\Supervisors;


use App\Models\BioCertification;
use App\Models\JobOfferType;
use App\Models\ProductionGenre;
use App\Models\ProjectStatus;
use App\Models\SupportStage;
use App\Models\SupportState;
use App\Services\Ads\AdService;
use App\Services\Projects\ProjectService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Support\Collection;

abstract class BaseController
{
	protected $threadService;
	protected $projectService;
	protected $userService;
	protected $adTypes;
	protected $adTypesFaIcons;
	protected $adService;

	/**
	 * BaseController constructor.
	 * @param ProjectService $projectService
	 * @param ThreadService $threadService
	 * @param UserService $userService
	 * @param AdService $adService
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
            ['name' => 'Associé sur une ferme', 'value' => 'associateOfferAd'],
            ['name' => 'Associé pour projet d\'installation', 'value' => 'associateSeekAd'],
        ];

        $this->adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access", "fa-user-tie", "fa-user-tie"];
	}


	/**
	 * Get all vars for Supervisors dashboard
	 * @return array
	 */
	protected function getSupervisorDashboardVars(): array
	{
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

		return compact(
			'supportStages',
			'supportStates',
			'projectStatuses',
			'jobOfferTypes',
			'productionGenres',
			'bioCertifications',
			'numberOfUnreadMessages',
			'adTypes',
			'adTypesFaIcons',
			'numberOfNotAssignProject'
		);
	}

	/**
	 * Get all vars for supervisors report page
	 * @param Collection $ads
	 * @param $projects
	 * @return array
	 */
	protected function getSupervisorReportVars(Collection $ads, Collection $projects): array
	{
		$numberOfAds = $ads->count();
		$publishedAdsInEachDepartmentsByYears = $this->adService->groupAdsBySupervisorDepartments($ads);
		$publishedAdsInEachRegionsByYears = $this->adService->groupAdsBySupervisorRegions($ads);
		$numberOfAdsByAdStatus = $this->adService->countAdsByAdStatus($ads);
		$validatedAdsInYearGroupByMonth = $this->adService->groupAllValidatedAdsInYearByMonth($ads);

		$numberOfProjects = $projects->count();
		$projectsBySupportStages = $this->projectService->groupProjectsByStatus($projects, "support_stage_id", true);
		$projectsBySupportStates = $this->projectService->groupProjectsByStatus($projects, "support_state_id", false);
		$projectsByProjectStatus = $this->projectService->groupProjectsByStatus($projects, "project_status_id", true);
		$projectsInYearGroupByMonth = $this->projectService->groupAllProjectsInYearByMonth($projects);
		return compact(
			'numberOfAds',
			'publishedAdsInEachDepartmentsByYears',
			'publishedAdsInEachRegionsByYears',
			'numberOfAdsByAdStatus',
			'validatedAdsInYearGroupByMonth',
			'projectsBySupportStages',
			'projectsBySupportStates',
			'projectsByProjectStatus',
			'numberOfProjects',
			'projectsInYearGroupByMonth'
		);
	}
}