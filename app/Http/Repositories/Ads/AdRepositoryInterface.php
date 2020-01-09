<?php namespace App\Htttp\Repositories;

use App\Models\Ad;

interface AdRepositoryInterface
{
    /**
     * Gets an ad by its ID
     *
     * @param int
     */
    public function get($id) : ?Ad;

    /**
     * Gets all ads.
     *
     * @return Ad[]
     */
    public function all() : array;

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
     */
    public function update($id, array $data) : Ad;

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data) : Ad;
}