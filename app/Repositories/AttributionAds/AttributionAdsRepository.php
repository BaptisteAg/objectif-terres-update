<?php

namespace App\Repositories\AttributionAds;

use App\Models\Ad;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class AttributionAdsRepository
 * @package App\Repositories\AttributionAds
 * @property AttributionAd $entity
 */
class AttributionAdsRepository extends AbstractRepository implements AttributionAdsRepositoryInterface
{
	public function entity()
	{
		return AttributionAd::class;
	}

	/**
	 * Creates a attributionAd.
	 *
	 * @param array $data
	 * @return AttributionAd
	 */
	public function create(array $data): AttributionAd
	{
		$attributionAd = new AttributionAd();
		$attributionAdData = $data;
		$attributionAd->fill($attributionAdData);
		$attributionAd->save();

		return $attributionAd;
	}

	/**
	 * @param $userId
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllByModeratorId($userId)
	{
		return $this->entity
			->where(["user_moderator_id" => $userId])
			->orderByDesc('created_at')
			->with($this->getEagerLoading())
			->paginate(15);
	}

	/**
	 * Get all attribution ads published since a specific number of months
	 * @param int $monthsNumber
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllWherePublishedOnSinceMonths(int $monthsNumber)
	{
		return $this->entity
			->whereDate("published_on", '=', Carbon::now()->subMonthsWithOverflow($monthsNumber))
			->get();
	}

	/**
	 * @param int $statusId
	 * @param int $userId
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByUserIdAndStatusId(int $statusId, int $userId)
	{
		return $this->entity
			->where(["user_moderator_id" => $userId])
			->whereHas('adStatus', function (Builder $query) use ($statusId) {
				$query->where('id', '=', $statusId);
			})
			->get();
	}


	/**
	 * @param int $statusId
	 * @return AttributionAd[]|Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByStatusIdGroupByModerators(int $statusId) : Collection
	{
		return $this->entity
			->whereHas('adStatus', function (Builder $query) use ($statusId) {

				$query->where('id', '=', $statusId);
			})
			->get()
			->groupBy('userModerator.id');
	}


	/**
	 * @param int $adId
	 * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
	 */
	public function findByAdId(int $adId)
	{
		$model = $this->entity
			->where('ad_id', '=', $adId)
			->first();
		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$adId
			);
		}

		return $model;

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

			'ad.landSeekAd',
			'ad.landOfferAd',
			'ad.jobOfferAd',
		];
	}

}
