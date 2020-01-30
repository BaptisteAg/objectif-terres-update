<?php namespace App\Repositories\FavoriteAds;

use App\Models\FavoriteAd;


interface FavoriteAdRepositoryInterface
{
	/**
	 * Gets favorite ad by its ID
	 *
	 * @param int
	 */
	public function find($id);

	/**
	 * Gets favorite ad by the sf_id AND the ad_id
	 *
	 * @param array
	 */
	public function findByUserAndAdId(array $data);

	/**
	 * Gets all favorite ads by the sf_id
	 *
	 * @param int
	 */
	public function findAllByUserId(int $id);

	/**
	 * Deletes an favorite ad.
	 *
	 * @param int
	 */
	public function delete($id);

	/**
	 * Creates an favorite ad.
	 *
	 * @param array
	 * @return FavoriteAd
	 */
	public function create(array $data) : FavoriteAd;

}
