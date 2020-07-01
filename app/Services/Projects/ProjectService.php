<?php

namespace App\Services\Projects;

use App\Jobs\NotifySupportRequestAttribution;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectDataKey;
use App\Models\Region;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Repositories\Projects\ProjectsRepository;
use App\Services\AttributionAds\AttributionAdsService;
use App\Services\Users\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjectService
{
	protected $repository;
	protected $attributionAdsRepository;
	protected $userService;
	protected $notification;
	protected $attributionAdsService;

	/**
	 * ProjectService constructor.
	 * @param ProjectsRepository $projectsRepository
	 * @param AttributionAdsRepository $attributionAdsRepository
	 * @param UserService $userService
	 * @param NotifySupportRequestAttribution $notification
	 * @param AttributionAdsService $attributionAdsService
	 */
	public function __construct(ProjectsRepository $projectsRepository, AttributionAdsRepository $attributionAdsRepository, UserService $userService, NotifySupportRequestAttribution $notification, AttributionAdsService $attributionAdsService)
	{
		$this->repository = $projectsRepository;
		$this->attributionAdsRepository = $attributionAdsRepository;
		$this->userService = $userService;
		$this->notification = $notification;
		$this->attributionAdsService = $attributionAdsService;
	}

	public function create(array $data)
	{
		return $this->repository->create($data);
	}

	/**
	 * @param int $supportStageId
	 * @return int
	 */
	public function countNumberOfProjectsBySupportStageForLoggedUser(int $supportStageId): int
	{
		return $this->repository->findAllByUserIdAndUserRoleAndSupportStageId(
			auth()->user()->id, auth()->user()->role, $supportStageId
		)->count();
	}


	/**
	 * @return Collection
	 */
	public function findAllProjectsInSupervisorTerritories(): Collection
	{
		$supervisorLocationTerritoryCodes = $this->userService->getCurrentUserTerritoryDepartments();
		$projects = $this->repository->findAllByUserTerritories(auth()->id(), $supervisorLocationTerritoryCodes);
		return $projects;
	}

	/**
	 * @param Collection $projects
	 * @param bool $getProjectsCreatedSinceLastYear
	 * @return Collection
	 */
	public function filterProjectsByCreationYear(Collection $projects, bool $getProjectsCreatedSinceLastYear): Collection
	{
		$onlyProjectCreatedLastYear = $projects->filter(function ($project) use ($getProjectsCreatedSinceLastYear) {
			$date = Carbon::parse($project->created_at);
			if (!$getProjectsCreatedSinceLastYear) {
				if ($date->isBetween(Carbon::now()->startOfYear()->subYear(), Carbon::now()->endOfYear()->subYear())) {
					return $project;
				}
				if ($date->isBetween(Carbon::now()->startOfYear(), Carbon::now())) {
					return $project;
				}
			} else {
				if ($date->isBetween(Carbon::now()->startOfYear(), Carbon::now())) {
					return $project;
				}
			}

		});
		return $groupPublishedAdsByYears = $onlyProjectCreatedLastYear->mapToGroups(function ($project, $key) {
			$date = Carbon::parse($project->created_at);
			return [$date->year => $project];
		});
	}

	/**
	 * @param Collection $projects
	 * @return Collection
	 */
	public function groupAllProjectsInYearByMonth(Collection $projects): Collection
	{
		$listOfMonthInYear = $this->attributionAdsService->getListOfMonthInYear();
		$projectsInYear = $projects->filter(function ($project, $key) {
			$date = Carbon::parse($project->created_at);
			if ($date->isBetween(Carbon::now()->startOfYear(), Carbon::now()->endOfYear())) {
				return $project;
			}
		});
		$projectsByMonthInYear = $projectsInYear->mapToGroups(function ($project, $key) {
			$date = Carbon::parse($project->created_at);
			return [$date->localeMonth => $project];
		});
		return $listOfMonthInYear->merge($projectsByMonthInYear);
	}

	/**
	 * @param Collection $projects
	 * @param string $columnName
	 * @param bool $getProjectsCreatedSinceLastYear
	 * @return Collection
	 */
	public function groupProjectsByStatus(Collection $projects, string $columnName, bool $getProjectsCreatedSinceLastYear): Collection
	{
		$projectsCreatedLastYear = $this->filterProjectsByCreationYear($projects, $getProjectsCreatedSinceLastYear);
		return $projectsBySupportStage = $projectsCreatedLastYear->map(function ($item) use ($columnName) {
			return $item->mapToGroups(function ($project) use ($columnName) {
				return [$project[$columnName] => $project];
			});
		});
	}


	/**
	 * @param Request $filters
	 * @param int $roleUser
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function filter(Request $filters, int $roleUser)
	{
		$projectAds = collect();
		//START QUERY
		$projectsFiltered = (new Project())->newQuery();
		//Filter projetcs based on their locations if requested
		if ($filters->has('locations')) {
			$locations = $filters->input('locations');
			//If one or more departments are selected, get all ads located in departments and cities in departments

			if (array_key_exists('departments', $locations)) {
				$departmentsCode = Department::whereIn('id', $locations['departments'])->get('code')->toArray();
				$projectsFiltered->where(function (Builder $query) use ($locations, $departmentsCode) {
					$query->filterLocations('ad.departments', $locations['departments']);
					$query->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
				});

				//If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
			}
			if (array_key_exists('regions', $locations)) {
				$regionsCodes = Region::whereIn('id', $locations['regions'])->get('code')->toArray();
				$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$projectsFiltered->where(function (Builder $query) use ($locations, $regionsCodes, $departmentsCode) {
					$query->filterLocations('ad.regions', $locations['regions']);
					$query->filterSubLocations('ad.departments', $regionsCodes, 'departments.region_code');
					$query->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
				});

			}
		}
		//If a range of submitting date is selected, filter attribution ads based on creation date
		if (!is_null($filters->input('date_research_range'))) {
			$dateFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_research_range'))->format('Y-m-d');
			$projectsFiltered->where('created_at', '>=', $dateFormatted);
		}
		//If one or many project status are selected, filter  ads based on their project status
		if ($filters->has('project_statuses')) {
			$projectsFiltered->whereIn('project_status_id', $filters->input('project_statuses'));
		}

		//Filter projects based on their types if requested
		if ($filters->has('ad_type')) {
			$projectsFiltered->filterAdTypes($filters->input('ad_type'), 'ad.');
		}

		//Filter projects by keywords
		$projectsFiltered->whereHas('ad', function (Builder $query) use ($filters, $roleUser) {
			$query->where('title', 'like', '%' . $filters->input('ad_keywords') . '%');
			$query->orWhere('about_content', 'like', '%' . $filters->input('ad_keywords') . '%');
			$query->orWhere('about_project_content', 'like', '%' . $filters->input('ad_keywords') . '%');

		});

		//Filter projects based on the role who is the user logged
		if ($roleUser === 2) {
			$projectsFiltered->whereHas('ad', function (Builder $query) use ($roleUser) {
				$query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
					$q->where('user_advisor_id', '=', auth()->id());
				});
			});
		} else if ($roleUser === 3) {
			$projectsFiltered->whereHas('ad', function (Builder $query) use ($roleUser) {
				$query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
					$q->where('user_supervisor_id', '=', auth()->id());
				});
			});
		}
		//Handling sort of research results
		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$projectsFiltered->orderBy('created_at', $filters->input('order'));
			} else if ($filters->input('sort') === 'title') {
				$projectsFiltered
					->join('ads', 'projects.id', '=', 'ads.id')
					->orderBy($filters->input('sort'), $filters->input('order'));

			} else if ($filters->input('sort') === 'name') {
				$projectsFiltered
					->select('projects.*')
					->join('ads as a1', 'projecsts.ad_id', '=', 'a1.id')
					->join('users', 'users.id', '=', 'a1.user_pp_id')
					->orderBy('first_name', $filters->input('order'));

			} else if ($filters->input('sort') === 'project_statuses.name') {
				$projectsFiltered
					->join('project_statuses', 'projects.project_status_id', '=', 'project_statuses.id')
					->orderBy('name', $filters->input('order'));
			}
		} else {
			$projectsFiltered->orderByDesc('created_at');
		}
		$projects = $projectsFiltered
			->with($this->getEagerLoading())
			->paginate(15);
		return $projects;
	}


	/**
	 * @param Request $request
	 */
	public function attributeProject(Request $request)
	{
		$attributionAd = $this->attributionAdsRepository->findByAdId($request->input('ad_id'));
		$attributionAd->user_advisor_id = $request->input('user_advisor_id');
		$attributionAd->save();
		$this->notification->handle($attributionAd->ad->id);
	}

	//TODO Create a ProjectDataKeyService and ProjectDataKeyRepository for the 2 above methods ?

	/**
	 * @param Request $request
	 */
	public function createProjectDataKey(Request $request)
	{
		ProjectDataKey::updateOrCreate(
			[
				'name' => $request->input('project_data_key_name'),
				'is_public' => $request->input('is_project_data_key_public'),
				'immutable' => 0
			]
		);
	}

	/**
	 * @param Request $request
	 */
	public function deleteProjectDataKey(Request $request)
	{
		DB::table('project_data_keys')
			->where('id', '=', $request->input('project_data_key_id'))
			->delete();
	}

	/**
	 * @return array
	 */
	private function getEagerLoading()
	{
		return [
			'ad',
			'ad.attributionAd',
			'ad.userPp',
			'supportStage',
			'supportState',
			'projectStatus',
			'ad.cities',
			'ad.cities.department',
			'ad.cities.department.region',
			'ad.departments',
			'ad.departments.region',
			'ad.regions',
			'ad.regions.departments',
			'ad.regions.departments.cities',

			'ad.landSeekAd',
			'ad.landOfferAd',
			'ad.jobOfferAd'
		];
	}

}
