<?php

namespace App\Repositories\AttributionAds;

use App\Models\AdStatus;
use App\Models\AttributionAd;
use Illuminate\Database\Eloquent\Builder;
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
	 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByModeratorId($userId)
	{
		return $this->entity
			->where(["user_moderator_id" => $userId])
			->with($this->getEagerLoading())
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
	public function findAllByStatusIdGroupByModerators(int $statusId)
	{
		return $this->entity
			->whereHas('adStatus', function (Builder $query) use ($statusId) {

				$query->where('id', '=', $statusId);
			})
			->get()
			->mapToGroups(function ($attributionAd, $key){
				return [$attributionAd->userModerator->id => $attributionAd];
	});
	}

	/**
	 * @return array
	 */
	private function getEagerLoading()
	{
		return [
			'ad',
			'ad.userPp',
			'ad.cities',
			'ad.regions',
			'ad.departments',
			'adStatus',
			'ad.project.projectStatus'
		];
	}

}
