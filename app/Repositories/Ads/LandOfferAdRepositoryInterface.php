<?php

namespace App\Repositories\Ads;

use App\Models\LandOfferAd;

interface LandOfferAdRepositoryInterface
{
    /**
     * Gets an ad by its ID
     *
     * @param int
     * @return LandOfferAd
     */
    public function find($id);

    /**
     * Gets all ads.
     *
     * @return LandOfferAd[]
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
     * @return LandOfferAd
     */
    public function update($id, array $data);

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     * @return LandOfferAd
     */
    public function create(array $data);
}
