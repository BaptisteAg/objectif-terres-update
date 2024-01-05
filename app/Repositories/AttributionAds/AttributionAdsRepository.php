<?php

namespace App\Repositories\AttributionAds;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Models\Department;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
	 * @param array $territoriesCodes
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function findAllByModeratorIdAndTerritories(array $territoriesCodes)
	{
		return $this->entity
			->where(function (Builder $query) {
				$query->where("user_moderator_id", '=', auth()->id());
				$query->whereNotNull('ad_status_id');
				$query->whereHas('ad', function (Builder $q) {
					$q->whereNull('project_id');
					$q->whereHas('userPp', function (Builder $builder) {
						$builder->whereNull('deleted_at');
					});
				});
			})
			->orWhere(function (Builder $query) use ($territoriesCodes) {
				$query->whereNotNull('ad_status_id');
				$query->whereHas('ad', function (Builder $subQuery) use ($territoriesCodes) {
					$subQuery->whereNull('project_id');
					$subQuery->where(function (Builder $builder) {
						$builder->whereHas('userPp', function (Builder $q) {
							$q->whereNull('deleted_at');
						});
					});
                    $subQuery->whereHas('departments', function (Builder $builder) use ($territoriesCodes) {
                        $builder->whereIn('code', $territoriesCodes);
                    });
                    $subQuery->orWhereHas('cities', function (Builder $builder) use ($territoriesCodes) {
                        $builder->whereIn('department_code', $territoriesCodes);
                    });
                    $subQuery->orWhereHas('regions', function (Builder $builder) use ($territoriesCodes) {
                        $builder->whereHas('departments', function (Builder $q) use ($territoriesCodes) {
                            $q->whereIn('code', $territoriesCodes);
                        });
                    });
				});
			})
			->orderByDesc('created_at')
			->with($this->getEagerLoading())
			->paginate(15);
	}

	/**
	 * Get all attribution ads published since a specific number of months
	 * @param int $monthsNumber
	 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllApprovedAndPublishedBefore(Carbon $date)
	{
		return $this->entity
			->where("published_on", '<=', $date->format('Y-m-d H:i:s'))
			->where('ad_status_id', [AdStatus::APPROVE_ID])
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

	public function findAllByStatusId(int $statusId)
	{
		return $this->entity
			->whereHas('adStatus', function (Builder $query) use ($statusId) {
				$query->where('id', '=', $statusId);
			})
			->get();
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
