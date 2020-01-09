<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\AdRepositoryInterface;
use App\Models\Ad;

class AdRepository implements AdRepositoryInterface
{

    /**
     * Gets an ad by its ID
     *
     * @param int
     */
    public function get($id): ?Ad
    {
        // TODO: Implement get() method.
    }

    /**
     * Gets all ads.
     *
     * @return Ad[]
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
    public function update($id, array $data): Ad
    {
        // TODO: Implement update() method.
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): Ad
    {
        // TODO: Implement create() method.
    }
}