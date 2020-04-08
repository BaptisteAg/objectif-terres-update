<?php

namespace App\Services\Projects;

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Project;
use App\Models\Region;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Repositories\Projects\ProjectsRepository;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class ProjectService
{
	protected $repository;
	protected $attributionAdsRepository;

	public function __construct(ProjectsRepository $projectsRepository, AttributionAdsRepository $attributionAdsRepository)
	{
		$this->repository = $projectsRepository;
		$this->attributionAdsRepository = $attributionAdsRepository;
	}

	/**
	 * Show all projects ads related to supervisor
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllByUserSupervisor()
	{
		$projectAds = Project::whereHas('ad', function (Builder $query) {
			$query->whereHas('attributionAd', function (Builder $q) {
				$q->where('user_supervisor_id', '=', auth()->user()->id);
			});
		})
			->with($this->getEagerLoading())
			->paginate(15);

		return $projectAds;
	}

	/**
	 * Project ads filters for supervisor dashboard
	 * @param Request $request
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function showForSupervisor(Request $filters)
	{
		$project = $this->filter($filters, auth()->user()->role);
		return $project;
	}


	public function countNumberOfProjectsByStatusForLoggedUser($projectStatusId)
	{
		$numberOfProjects = $this->repository->findAllByUserIdAndUserRoleAndProjectStatusId(auth()->user()->id, auth()->user()->role, $projectStatusId)->count();
		return $numberOfProjects;
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
//			TODO delete if research by cities is not necessary anymore
//			if (array_key_exists('cities', $locations)) {
//				if (!is_null($filters->input('radius_research'))) {
//					$cityIds = $this->locationService->getCitiesInRadius($locations['cities'], $filters->input('radius_research'));
//					$projectsFiltered->filterLocations('ad.cities', $cityIds);
//				} else {
//					$projectsFiltered->filterLocations('ad.cities', $locations['cities']);
//				}
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
