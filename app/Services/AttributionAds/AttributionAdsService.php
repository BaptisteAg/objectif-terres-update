<?php

namespace App\Services\AttributionAds;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use App\Repositories\Ads\AdRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use App\Services\Locations\LocationService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class AttributionAdsService
 * @package App\Services\AttributionAds
 */
class AttributionAdsService
{
	protected $repository;
	protected $adRepository;
	protected $locationService;

	/**
	 * AttributionAdsService constructor.
	 * @param AttributionAdsRepository $attributionAdsRepository
	 * @param AdRepository $adRepository
	 */
	public function __construct(AttributionAdsRepository $attributionAdsRepository, AdRepository $adRepository, LocationService $locationService)
	{
		$this->repository = $attributionAdsRepository;
		$this->adRepository = $adRepository;
		$this->locationService = $locationService;
	}

	/**
	 * @param int $idUser
	 * @return Builder[]|Collection
	 */
	public function findAllByUserModerator(int $idUser)
	{
		return $this->repository->findAllByModeratorId($idUser);
	}

	/**
	 * @return int
	 */
	public function countAllAdsToModerateForLoggedModerator()
	{
		$toModerateStatus = AdStatus::where('name', '=', 'A modérer')->first();
		return $this->repository->findAllByUserIdAndStatusId($toModerateStatus->id, auth()->user()->id)->count();
	}


	/**
	 * Get all ads grouped by moderator id and not moderated since more than a week
	 * @return array
	 */
	public function findAllAdsToModerateByModerators()
	{
		$toModerateStatus = AdStatus::where('name', '=', 'A modérer')->first();
		$allAdsToModerateGroupByModerators = $this->repository->findAllByStatusIdGroupByModerators($toModerateStatus->id);

		foreach ($allAdsToModerateGroupByModerators as $allAdsToModerateByModerator) {
			foreach ($allAdsToModerateByModerator as $key => $attributionAd) {
				if ($attributionAd->created_at >= Carbon::now()->subWeek()) {
					unset($allAdsToModerateByModerator[$key]);
				}
			}
		}
		return $allAdsToModerateGroupByModerators;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Support\Collection
	 */
	public function show(Request $filters)
	{
		$attributionAds = $this->filter($filters);
		return $attributionAds;
	}


	/**
	 * @param Request $filters
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function filter(Request $filters)
	{
		//Return results if research ads by title
		$attributionAds = collect();
		if (!is_null($filters->input('ad_title'))) {
			$adsByTitle = AttributionAd::whereHas('ad', function (Builder $query) use ($filters) {
				$query->where('title', 'like', '%' . $filters->input('ad_title') . '%');
				$query->where('user_moderator_id', '=', auth()->id());
			});
			$attributionAds = $adsByTitle
				->with($this->getEagerLoading())
				->get();
			return $attributionAds;
		}
		//START QUERY
		$attributionAdsFiltered = (new AttributionAd)->newQuery();

		//First, filter attributions ads based on the moderator who is the user logged
		$attributionAdsFiltered->where('user_moderator_id', '=', auth()->id());

		//Filter attribution ads based on their locations if requested
		if ($filters->has('city_location_researches')) {
			if (!is_null($filters->input('radius_research'))) {
				$cityIds = $this->locationService->getCitiesInRadius($filters->input('city_location_researches'), $filters->input('radius_research'));
				$attributionAdsFiltered->filterLocations('ad.cities', $cityIds);
			} else {
				$attributionAdsFiltered->filterLocations('ad.cities', $filters->input('city_location_researches'));
			}
		} //If one or more departments are selected, get all ads located in departments and cities in departments
		else if ($filters->has('departments_location_researches')) {
			$departmentsCode = Department::whereIn('id', $filters->input('departments_location_researches'))->get('code')->toArray();
			$attributionAdsFiltered->filterLocations('ad.departments', $filters->input('departments_location_researches'));
			$attributionAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');

		} //If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
		else if ($filters->has('regions_location_researches')) {
			$regionsCodes = Region::whereIn('id', $filters->input('regions_location_researches'))->get('code')->toArray();
			$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
			$attributionAdsFiltered->filterLocations('ad.regions', $filters->input('regions_location_researches'));
			$attributionAdsFiltered->filterSubLocations('ad.departments', $regionsCodes, 'departments.region_code');
			$attributionAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
		}
		//If a range of submitting date is selected, filter attribution ads based on creation date
		if (!is_null($filters->input('date_research_range'))) {
			$dateFormatted = DateTime::createFromFormat('d/m/Y', (string)$filters->input('date_research_range'))->format('Y-m-d');
			$attributionAdsFiltered->where('attribution_ads.created_at', '>=', $dateFormatted);
		}
		//If one or many project status are selected, filter  ads based on their project status
		if ($filters->has('project_statuses')) {
			$attributionAdsFiltered->filterWhereHasIn($filters->input('project_statuses'), 'ad.project', 'project_status_id');
		}

		//If one or many ad status are selected, filter attribution ads based on their status
		if ($filters->has('ad_statuses')) {
			$attributionAdsFiltered->whereIn('ad_status_id',$filters->input('ad_statuses'));
		}

		//Filter ads based on their types if requested
		if ($filters->has('ad_type')) {
			$attributionAdsFiltered->filterAdTypes($filters->input('ad_type'), 'ad.');
		}
		$attributionAdsFiltered->where('user_moderator_id', '=', auth()->id());


		//Handling sort of research results
		if ($filters->has('order') && $filters->has('sort')) {
			if ($filters->input('sort') === 'date') {
				$attributionAdsFiltered->orderBy('created_at', $filters->input('order'));
			} else if ($filters->input('sort') === 'title') {
				$attributionAdsFiltered
					->join('ads', 'attribution_ads.id', '=', 'ads.id')
					->orderBy($filters->input('sort'), $filters->input('order'));
			} else if ($filters->input('sort') === 'name') {
				$attributionAdsFiltered
					->select('attribution_ads.*')
					->join('ads as a1', 'attribution_ads.id', '=', 'a1.attribution_ad_id')
					->join('users', 'users.id', '=', 'a1.user_pp_id')
					->orderBy('first_name', $filters->input('order'));
			} else if ($filters->input('sort') === 'ad_statuses.name') {
				$attributionAdsFiltered
					->join('ad_statuses', 'attribution_ads.ad_status_id', '=', 'ad_statuses.id')
					->orderBy('name', $filters->input('order'));
			} else if ($filters->input('sort') === 'project_statuses.name') {
				$attributionAdsFiltered
					->select('attribution_ads.*')
					->join('ads as a1', 'attribution_ads.id', '=', 'a1.attribution_ad_id')
					->leftJoin('projects as p1', 'p1.id', '=', 'a1.project_id')
					->leftJoin('project_statuses', 'p1.project_status_id', 'project_statuses.id' )
					->orderBy('name', $filters->input('order'));
			}
		} else {
			$attributionAdsFiltered->orderByDesc('created_at');
		}

		$attributionAds = $attributionAdsFiltered
			->with($this->getEagerLoading())
			->paginate(15);
		return $attributionAds;
	}

	/**
	 * @param int $attributionAdId
	 * @return mixed
	 */
	public function acceptAd(int $attributionAdId)
	{
		$attributionAd = $this->repository->find($attributionAdId);
		//TODO when moderator accept an ad, if the pp want a support from Tdl, the ad Status is to assign the ad to an Tdl user
//		$toAssignStatus = AdStatus::where('name', '=', 'A assigner')->first();
//		$attributionAd->ad_status_id = $toAssignStatus->id;

		$validateStatus = AdStatus::where('name', '=', 'Validé')->first();
		$attributionAd->ad_status_id = $validateStatus->id;
		$attributionAd->published_on = Carbon::now();
		$attributionAd->save();

		$ad = $this->adRepository->find($attributionAd->ad->id);
		$ad->is_draft = 0;
		$ad->save();

		return $attributionAd;
	}

	public function modifyAd(int $attributionAdId)
	{
		$attributionAd = $this->repository->find($attributionAdId);
		$toModifyStatus = AdStatus::where('name', '=', 'A modifier')->first();
		$attributionAd->ad_status_id = $toModifyStatus->id;
		$attributionAd->save();

		$ad = $this->adRepository->find($attributionAd->ad->id);
		$ad->is_draft = 1;
		$ad->save();
		return $attributionAd;
	}

	public function rejectAd(array $data)
	{
		$attributionAd = $this->repository->find($data['attribution_ad_id']);
		$rejectStatus = AdStatus::where('name', '=', 'Refuser')->first();
		$attributionAd->ad_status_id = $rejectStatus->id;
		$attributionAd->refusal_type_id = $data['refusal_type_id'];
		$attributionAd->save();

		if ($attributionAd->ad->is_draft === 1) {
			$ad = $this->adRepository->find($attributionAd->ad->id);
			$ad->is_draft = 0;
			$ad->save();
		}
		return $attributionAd;

	}

	/**
	 * @return array
	 */
	private function getEagerLoading()
	{
		return [
			'ad',
			'ad.userPp',
			'adStatus',
			'ad.project.projectStatus',

			'ad.cities',
			'ad.cities.department',
			'ad.cities.department.region',
			'ad.departments',
			'ad.departments.region',
			'ad.regions',
			'ad.regions.departments',
			'ad.regions.department.cities',

			'ad.landSeekAd',
			'ad.landOfferAd',
			'ad.jobOfferAd'
		];
	}
}