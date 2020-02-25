<?php

namespace App\Repositories\AttributionAds;

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

	public function findAllByModeratorId($userId)
	{
		return $this->entity
			->where(["user_moderator_id" => $userId])
			->with($this->getEagerLoading())
			->get();
	}

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
