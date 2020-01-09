<?php namespace App\Htttp\Repositories;

use App\Models\LandSeekAd;

interface LandSeekAdRepositoryInterface
{
    /**
     * Gets an ad by its ID
     *
     * @param int
     */
    public function get($id) : ?LandSeekAd;

    /**
     * Gets all ads.
     *
     * @return LandSeekAd[]
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
    public function update($id, array $data) : LandSeekAd;

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data) : LandSeekAd;
}