<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\LandSeekAdRepositoryInterface;
use App\Models\LandSeekAd;

class LandSeekdAdRepository implements LandSeekAdRepositoryInterface
{
    public function __construct()
    {
    }

    /**
     * Gets an ad by its ID
     *
     * @param int
     */
    public function get($id): ?LandSeekAd
    {
        // TODO: Implement get() method.
    }

    /**
     * Gets all ads.
     *
     * @return LandSeekAd[]
     */
    public function all(): array
    {
        // TODO: Implement all() method.
    }

    /**
     * Deletes an ad.
     *
     * @param int
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Updates an ad.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data): LandSeekAd
    {
        // TODO: Implement update() method.
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): LandSeekAd
    {

    }
}