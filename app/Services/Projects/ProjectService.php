<?php

namespace App\Services\Projects;

use App\Models\Department;
use App\Models\Project;
use App\Models\Region;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class ProjectService
{

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
		$projectAds = $this->filter($filters, auth()->user()->role);
		return $projectAds;
	}

	/**
	 * @param Request $filters
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function filter(Request $filters, int $roleUser)
	{
		//Return results if research ads by keywords
		$projectAds = collect();
		if (!is_null($filters->input('ad_keywords'))) {
			$adsByTitle = Project::whereHas('ad', function (Builder $query) use ($filters, $roleUser) {
				$query->where('title', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere('about_content', 'like', '%' . $filters->input('ad_keywords') . '%');
				$query->orWhere('about_project_content', 'like', '%' . $filters->input('ad_keywords') . '%');

			});
			$adsByTitle->whereHas('ad', function (Builder $query) use ($roleUser) {
				$query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
					$q->where('user_supervisor_id', '=', auth()->id());
				});
			});
			$adsByTitle->orderByDesc('created_at');
			$projectAds = $adsByTitle
				->with($this->getEagerLoading())
				->paginate(15);
			return $projectAds;
		}
		//START QUERY
		$projectAdsFiltered = (new Project())->newQuery();

		//First, filter attributions ads based on the role who is the user logged
		if ($roleUser === 2) {
			$projectAdsFiltered->whereHas('ad', function (Builder $query) use ($roleUser) {
				$query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
					$q->where('user_advisor_id', '=', auth()->id());
				});
			});
		} else if ($roleUser === 3) {
			$projectAdsFiltered->whereHas('ad', function (Builder $query) use ($roleUser) {
				$query->whereHas('attributionAd', function (Builder $q) use ($roleUser) {
					$q->where('user_supervisor_id', '=', auth()->id());
				});
			});
		}

		//Filter attribution ads based on their locations if requested

		if ($filters->has('locations')) {
			$locations = $filters->input('locations');
//			TODO delete if research by cities is not necessary anymore
//			if (array_key_exists('cities', $locations)) {
//				if (!is_null($filters->input('radius_research'))) {
//					$cityIds = $this->locationService->getCitiesInRadius($locations['cities'], $filters->input('radius_research'));
//					$projectAdsFiltered->filterLocations('ad.cities', $cityIds);
//				} else {
//					$projectAdsFiltered->filterLocations('ad.cities', $locations['cities']);
//				}
			//If one or more departments are selected, get all ads located in departments and cities in departments

			if (array_key_exists('departments', $locations)) {
				$departmentsCode = Department::whereIn('id', $locations['departments'])->get('code')->toArray();
				$projectAdsFiltered->filterLocations('ad.departments', $locations['departments']);
				$projectAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');

				//If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
			}
			if (array_key_exists('regions', $locations)) {
				$regionsCodes = Region::whereIn('id', $locations['regions'])->get('code')->toArray();
				$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$projectAdsFiltered->filterLocations('ad.regions', $locations['regions']);
				$projectAdsFiltered->filterSubLocations('ad.departments', $regionsCodes, 'departments.region_code');
				$projectAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
			}
		}
		//If a range of submitting date is selected, filter attribution ads based on creation date
		if (!is_null($filters->input('date_research_range'))) {
			$dateFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_research_range'))->format('Y-m-d');
			$projectAdsFiltered->where('created_at', '>=', $dateFormatted);
		}
		//If one or many project status are selected, filter  ads based on their project status
		if ($filters->has('project_statuses')) {
			$projectAdsFiltered->whereIn('project_status_id', $filters->input('project_statuses'));
		}

		//Filter ads based on their types if requested
		if ($filters->has('ad_type')) {
			$projectAdsFiltered->filterAdTypes($filters->input('ad_type'), 'ad.');
		}

		//Handling sort of research results
		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$projectAdsFiltered->orderBy('created_at', $filters->input('order'));
			} else if ($filters->input('sort') === 'title') {
				$projectAdsFiltered
					->join('ads', 'projects.id', '=', 'ads.id')
					->orderBy($filters->input('sort'), $filters->input('order'));

			} else if ($filters->input('sort') === 'name') {
				$projectAdsFiltered
					->select('projects.*')
					->join('ads as a1', 'projecsts.ad_id', '=', 'a1.id')
					->join('users', 'users.id', '=', 'a1.user_pp_id')
					->orderBy('first_name', $filters->input('order'));

			} else if ($filters->input('sort') === 'project_statuses.name') {
				$projectAdsFiltered
					->join('project_statuses', 'projects.project_status_id', '=', 'project_statuses.id')
					->orderBy('name', $filters->input('order'));
			}
		} else {
			$projectAdsFiltered->orderByDesc('created_at');
		}
		$projectAds = $projectAdsFiltered
			->with($this->getEagerLoading())
			->paginate(15);
		return $projectAds;
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
