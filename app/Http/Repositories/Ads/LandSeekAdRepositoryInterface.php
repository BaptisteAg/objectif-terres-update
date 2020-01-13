<?php namespace App\Htttp\Repositories;

use App\Models\LandSeekAd;

interface LandSeekAdRepositoryInterface
{
    /**
     * Gets an ad by its ID
     *
     * @param int
     */
    public function find($id) : ?LandSeekAd;

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
     * @return LandSeekAd
     */
    public function update($id, array $data);

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     * @return LandSeekAd
     */
    public function create(array $data);
}