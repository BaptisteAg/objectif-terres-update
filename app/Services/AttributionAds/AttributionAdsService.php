<?php

namespace App\Services\AttributionAds;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use App\Repositories\Ads\AdRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use Carbon\Carbon;
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

	/**
	 * AttributionAdsService constructor.
	 * @param AttributionAdsRepository $attributionAdsRepository
	 * @param AdRepository $adRepository
	 */
	public function __construct(AttributionAdsRepository $attributionAdsRepository, AdRepository $adRepository)
	{
		$this->repository = $attributionAdsRepository;
		$this->adRepository = $adRepository;
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
	public function show(Request $request)
	{
		//Return results if research ads by title
		$attributionAds = collect();
		if (!is_null($request->input('ad_title'))) {
			$adsByTitle = Ad::where('title', 'like', '%' . $request->input('ad_title') . '%')->get();
			foreach ($adsByTitle as $adByTitle) {
				$attributionAds[$adByTitle->attributionAd->id] = $adByTitle->attributionAd->load('ad');
				return $attributionAds;
			}
		}
		/////START QUERY
		$attributionAds = new AttributionAd();
		$attributionAdsFiltered = $attributionAds->newQuery();

		//First, filter attributions ads based on the moderator who is the user logged
		$attributionAdsFiltered->where('user_moderator_id', '=', auth()->id());

		//Filter ads based on their types if requested
		if ($request->has('ad_type')) {
			foreach ($request->input('ad_type') as $index => $adType) {
				if ($index === 0) {
					$attributionAdsFiltered->with('ad')->whereHas('ad.' . $adType);
				} else {
					$attributionAdsFiltered->with('ad')->orWhereHas('ad.' . $adType);
				}
			}
		}
		//Filter attribution ads based on their locations if requested
		if ($request->has('city_location_researches')) {
			$citiesIds = $request->input('city_location_researches');
			$attributionAdsFiltered->with('ad')->whereHas('ad.cities', function (Builder $query) use ($citiesIds) {
				$query->whereIn('locationable_ad_id', $citiesIds);
			});
			//If one or more departments are selected, get all ads located in departments and cities in departments
		} else if ($request->has('departments_location_researches')) {
			$departmentsIds = $request->input('departments_location_researches');
			$attributionAdsFiltered->with('ad')
				->whereHas('ad.departments', function (Builder $query) use ($departmentsIds) {
					$query->whereIn('locationable_ad_id', $departmentsIds);
				})
				->orWhereHas('ad.cities', function (Builder $query) use ($departmentsIds) {
					$departmentsCode = Department::whereIn('id', $departmentsIds)->get('code')->toArray();
					$query->whereIn('cities.department_code', $departmentsCode);

				});
			//If one or more regions are selected, get all ads located in regions, all ads in departments inside regions and cities in departments
		} else if ($request->has('regions_location_researches')) {
			$regionsIds = $request->input('regions_location_researches');
			$regionsCode = Region::whereIn('id', $regionsIds)->get('code')->toArray();
			$departmentsCode = Department::whereIn('region_code', $regionsCode)->get('code')->toArray();
			$attributionAdsFiltered->with('ad')
				->whereHas('ad.regions', function (Builder $query) use ($regionsIds) {
					$query->whereIn('locationable_ad_id', $regionsIds);
				})
				->orWhereHas('ad.departments', function (Builder $query) use ($regionsCode) {
					$query->whereIn('departments.region_code', $regionsCode);
				})
				->orWhereHas('ad.cities', function (Builder $query) use ($departmentsCode) {
					$query->whereIn('cities.department_code', $departmentsCode);
				});
		}

		//If a range of submitting date is selected, filter attribution ads based on creation date
		if (!is_null($request->input('date_research_range'))) {
			$date = strtotime($request->input('date_research_range'));
			$dateFormatted = date('Y-d-m', $date);
			$attributionAdsFiltered->where('created_at', '>=', $dateFormatted);
		}
		//If one or many project status are selected, filter  ads based on their project status
		if ($request->has('project_statuses')) {
			$attributionAdsFiltered->with('ad')->whereHas('ad.project', function (Builder $query) use ($request) {
				$projectStatusesId = $request->input('project_statuses');
				$query->whereIn('project_status_id', $projectStatusesId);
			});
		}

		//If one or many ad status are selected, filter attribution ads based on their status
		if ($request->has('ad_statuses')) {
			$adStatusesId = $request->input('ad_statuses');
			$attributionAdsFiltered->whereIn('ad_status_id', $adStatusesId);
		}

		$attributionAds = $attributionAdsFiltered->get()->load('ad');
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
}