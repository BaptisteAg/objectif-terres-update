<?php

namespace App\Repositories\AttributionAds;

use App\Models\AdStatus;
use App\Models\AttributionAd;
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
