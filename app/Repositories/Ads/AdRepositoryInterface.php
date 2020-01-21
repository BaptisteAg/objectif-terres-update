<?php namespace App\Htttp\Repositories;

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