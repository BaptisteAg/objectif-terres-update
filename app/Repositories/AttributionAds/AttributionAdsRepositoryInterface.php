<?php namespace App\Repositories\AttributionAds;

use App\Models\AttributionAd;


interface AttributionAdsRepositoryInterface
{
	/**
	 * Gets attribution ad by its ID
	 *
	 * @param int
	 */
	public function find($id);

	/**
	 * Deletes an attribution ad.
	 *
	 * @param int
	 */
	public function delete($id);

	/**
	 * Creates an attribution ad.
	 *
	 * @param array
	 * @return AttributionAd
	 */
	public function create(array $data);

}