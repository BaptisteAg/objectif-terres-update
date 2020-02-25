<?php

namespace App\Services\AttributionAds;

use App\Models\User;
use App\Repositories\Ads\AdRepository;
use App\Models\AttributionAd;
use App\Repositories\AttributionAds\AttributionAdsRepository;

/**
 * Class AttributionAdsService
 * @package App\Services\AttributionAds
 */
class AttributionAdsService
{
	protected $repository;

	/**
	 * AttributionAdsService constructor.
	 * @param AttributionAdsRepository $attributionAdsRepository
	 */
	public function __construct(AttributionAdsRepository $attributionAdsRepository)
	{
		$this->repository = $attributionAdsRepository;
	}

	/**
	 * @param int $idUser
	 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByUserModerator(int $idUser)
	{
		return $this->repository->findAllByModeratorId($idUser);
	}
}