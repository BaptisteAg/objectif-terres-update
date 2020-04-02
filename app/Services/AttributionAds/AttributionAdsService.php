<?php

namespace App\Services\AttributionAds;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use App\Models\User;
use App\Notifications\ModerationPpNotification;
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
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllByUserModerator(int $idUser)
	{
		return $this->repository->findAllByModeratorId($idUser);
	}


	/**
	 * Find all attributions ads published since specific number of month
	 * @param int $numberOfMonths
	 * @return Builder[]|Collection
	 */
	public function findAllPublishedSinceMonths(int $numberOfMonths)
	{
		return $this->repository->findAllWherePublishedOnSinceMonths($numberOfMonths);
	}

	/**
	 * Show all ads published and related to supervisor
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllByUserSupervisor()
	{
		$attributionAds = AttributionAd::where('user_supervisor_id', '=', auth()->id())
			->with($this->getEagerLoading())
			->paginate(15);
		return $attributionAds;
	}

	/**
	 * @return int
	 */
	public function countAllAdsToModerateForLoggedModerator()
	{
		$toModerateStatus = AdStatus::where('name', '=', 'À modérer')->first();
		return $this->repository->findAllByUserIdAndStatusId($toModerateStatus->id, auth()->user()->id)->count();
	}

	/**
	 * Get all ads grouped by moderator id and not moderated since more than a week
	 * @return array
	 */
	public function findAllAdsToModerateByModerators()
	{
		$toModerateStatus = AdStatus::where('name', '=', 'À modérer')->first();
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
	 * Attribution ads filters for moderators dashboard
	 * @param Request $request
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function showForModerators(Request $filters)
	{
		$attributionAds = $this->filter($filters, auth()->user()->role);
		return $attributionAds;
	}

	/**
	 * Attribution ads filters for supervisor dashboard
	 * @param Request $request
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function showForSupervisor(Request $filters)
	{
		$attributionAds = $this->filter($filters, auth()->user()->role);
		return $attributionAds;
	}

	/**
	 * Attribution ads filters for advisors dashboard
	 * @param Request $request
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function showForAdvisors(Request $filters)
	{
		$attributionAds = $this->filter($filters, auth()->user()->role);
		return $attributionAds;
	}


	/**
	 * @param Request $filters
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function filter(Request $filters, int $roleUser)
	{
		//Return results if research ads by title
		$attributionAds = collect();
		if (!is_null($filters->input('ad_title'))) {
			$adsByTitle = AttributionAd::whereHas('ad', function (Builder $query) use ($filters, $roleUser) {
				$query->where('title', 'like', '%' . $filters->input('ad_title') . '%');
				$query->orWhere('about_content', 'like', '%'.$filters->input('ad_title').'%');
				$query->orWhere('about_project_content', 'like', '%'.$filters->input('ad_title').'%');

			});
			$adsByTitle->where('user_moderator_id', '=', auth()->id());
			$adsByTitle->orderByDesc('created_at');
			$attributionAds = $adsByTitle
				->with($this->getEagerLoading())
				->paginate(15);;
			return $attributionAds;
		}
		//START QUERY
		$attributionAdsFiltered = (new AttributionAd)->newQuery();

		//First, filter attributions ads based on the role who is the user logged
		if ($roleUser === 2) {
			$attributionAdsFiltered->where('user_advisor_id', '=', auth()->id());
		} else if ($roleUser === 3) {
			$attributionAdsFiltered->where('user_supervisor_id', '=', auth()->id());
		} else {
			$attributionAdsFiltered->where('user_moderator_id', '=', auth()->id());
		}

		//Filter attribution ads based on their locations if requested

		if ($filters->has('locations')) {
			$locations = $filters->input('locations');
			if (array_key_exists('cities', $locations)) {
				if (!is_null($filters->input('radius_research'))) {
					$cityIds = $this->locationService->getCitiesInRadius($locations['cities'], $filters->input('radius_research'));
					$attributionAdsFiltered->filterLocations('ad.cities', $cityIds);
				} else {
					$attributionAdsFiltered->filterLocations('ad.cities', $locations['cities']);
				}
				//If one or more departments are selected, get all ads located in departments and cities in departments
			}
			if (array_key_exists('departments', $locations)) {
				$departmentsCode = Department::whereIn('id', $locations['departments'])->get('code')->toArray();
				$attributionAdsFiltered->filterLocations('ad.departments', $locations['departments']);
				$attributionAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');

				//If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
			}
			if (array_key_exists('regions', $locations)) {
				$regionsCodes = Region::whereIn('id', $locations['regions'])->get('code')->toArray();
				$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
				$attributionAdsFiltered->filterLocations('ad.regions', $locations['regions']);
				$attributionAdsFiltered->filterSubLocations('ad.departments', $regionsCodes, 'departments.region_code');
				$attributionAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
			}
		}

//		if ($filters->has('city_location_researches')) {
//			if (!is_null($filters->input('radius_research'))) {
//				$cityIds = $this->locationService->getCitiesInRadius($filters->input('city_location_researches'), $filters->input('radius_research'));
//				$attributionAdsFiltered->filterLocations('ad.cities', $cityIds);
//			} else {
//				$attributionAdsFiltered->filterLocations('ad.cities', (array)$filters->input('city_location_researches'));
//			}
//		} //If one or more departments are selected, get all ads located in departments and cities in departments
//		else if ($filters->has('departments_location_researches')) {
//			$departmentsCode = Department::whereIn('id', $filters->input('departments_location_researches'))->get('code')->toArray();
//			$attributionAdsFiltered->filterLocations('ad.departments', $filters->input('departments_location_researches'));
//			$attributionAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
//
//		} //If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
//		else if ($filters->has('regions_location_researches')) {
//			$regionsCodes = Region::whereIn('id', $filters->input('regions_location_researches'))->get('code')->toArray();
//			$departmentsCode = Department::whereIn('region_code', $regionsCodes)->get('code')->toArray();
//			$attributionAdsFiltered->filterLocations('ad.regions', $filters->input('regions_location_researches'));
//			$attributionAdsFiltered->filterSubLocations('ad.departments', $regionsCodes, 'departments.region_code');
//			$attributionAdsFiltered->filterSubLocations('ad.cities', $departmentsCode, 'cities.department_code');
//		}
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
			$attributionAdsFiltered->whereIn('ad_status_id', $filters->input('ad_statuses'));
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
					->join('ads as a1', 'attribution_ads.ad_id', '=', 'a1.id')
					->join('users', 'users.id', '=', 'a1.user_pp_id')
					->orderBy('first_name', $filters->input('order'));

			} else if ($filters->input('sort') === 'ad_statuses.name') {
				$attributionAdsFiltered
					->join('ad_statuses', 'attribution_ads.ad_status_id', '=', 'ad_statuses.id')
					->orderBy('name', $filters->input('order'));
			} else if ($filters->input('sort') === 'project_statuses.name') {
				$attributionAdsFiltered
					->select('attribution_ads.*')
					->join('ads as a1', 'attribution_ads.ad_id', '=', 'a1.id')
					->leftJoin('projects as p1', 'p1.id', '=', 'a1.project_id')
					->leftJoin('project_statuses', 'p1.project_status_id', 'project_statuses.id')
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
		//TODO if the pp want a support from Tdl, a special method as to be created.The moderator doesn't take part of the attribution process.

		//If on the territory related to the ad, there is advisors dedicated to specific departments, the ad is automatically attributed to the advisor and we create a project related to the ad.
		//$toAssignStatus = AdStatus::where('name', '=', 'Validée')->first();
		//$attributionAd->ad_status_id = $toAssignStatus->id;
		//$supportStatus = ProjectStatus::where('name', '=', 'Accompagné')->first();
		//$attributionAd->ad->project()->create(['project_status_id'=> $supportStatus]);

		//Else, by default, the ad is attributed to an supervisor based on his territory saved in Salesforce . If there is many supervisors, one supervisor is pick randomly.
		//$toAssignStatus = AdStatus::where('name', '=', 'Validée')->first();
		//$attributionAd->ad_status_id = $toAssignStatus->id;
		//$supportStatus = ProjectStatus::where('name', '=', 'Non accompagné')->first();
		//$attributionAd->ad->project()->create(['project_status_id'=> $supportStatus]);
		//$supervisor = User::where('role', '=', 3)->inRandomOrder()->first();
		//$attributionAd->user_supervisor_id = $supervisor->id;

		//If the pp doesn't need a support from Tdl, the ad is validated and published
		$validateStatus = AdStatus::where('name', '=', 'Validée')->first();
		$attributionAd->ad_status_id = $validateStatus->id;
		$attributionAd->published_on = Carbon::now();
		$data = [
			'message' => 'Votre annonce a été validée par l\'équipe d\'Objectif Terres et est désormais publiée ! ',
			'action' => 'Consulter votre annonce',
			'url' => '/annonces/' . $attributionAd->ad->id,
		];
		$attributionAd->ad->userPp->notify(new ModerationPpNotification($data));

		if ($attributionAd->refusal_type_id) {
			$attributionAd->refusal_type_id = null;
		}
		$attributionAd->save();

		$ad = $this->adRepository->find($attributionAd->ad->id);
		$ad->is_draft = 0;
		$ad->save();

		return $attributionAd;
	}

	public function modifyAd(int $attributionAdId)
	{
		$attributionAd = $this->repository->find($attributionAdId);
		$toModifyStatus = AdStatus::where('name', '=', 'En attente')->first();
		$attributionAd->ad_status_id = $toModifyStatus->id;
		$attributionAd->save();

		$ad = $this->adRepository->find($attributionAd->ad->id);
		$ad->is_draft = 1;
		$ad->save();

		//TODO url is the link to the form form modifiy the ad
		$data = [
			'message' => 'Votre annonce nécessite quelques modifications pour être publiée ! Consulter votre messagerie pour plus d\'informations.',
			'action' => 'Consulter votre messagerie',
			'url' => '/mon-espace/messagerie',
		];
		$ad->userPp->notify(new ModerationPpNotification($data));
		return $attributionAd;
	}

	public function rejectAd(array $data)
	{
		$attributionAd = $this->repository->find($data['attribution_ad_id']);
		$rejectStatus = AdStatus::where('name', '=', 'Refusée')->first();
		$attributionAd->ad_status_id = $rejectStatus->id;
		$attributionAd->refusal_type_id = $data['refusal_type_id'];
		$attributionAd->save();
		$data = [
			'message' => 'Votre annonce n\'a pas été acceptée par l\'équipe d\'Objectif Terres. Consulter votre messagerie pour plus d\'informations.',
			'action' => 'Consulter votre messagerie',
			'url' => '/mon-espace/messagerie',
		];
		$attributionAd->ad->userPp->notify(new ModerationPpNotification($data));

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
			'ad.regions.departments.cities',

			'ad.landSeekAd',
			'ad.landOfferAd',
			'ad.jobOfferAd'
		];
	}
}