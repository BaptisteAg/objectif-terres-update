<?php namespace App\Repositories\Ads;

use App\Models\Ad;

interface AdRepositoryInterface
{
    /**
     * Gets an ad by its ID
     *
     * @param int
     */
    public function find($id);

    /**
     * Gets all ads.
     *
     * @return Ad[]
     */
    public function all($paginate = null);

	/**
	 * Gets all ads by id user.
	 *
	 * @param $id
	 * @return Ad[]
	 */
	public function allByIdUser($id);

    /**
     * Deletes an ad.
     *
     * @param int
     */
    public function delete($id);

    /**
     * Updates an ad.
     *
     * @param int
     * @param array
     * @return Ad
     */
    public function update($id, array $properties);

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data) : Ad;
}