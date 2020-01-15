<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\LandSeekAdRepositoryInterface;
use App\Models\LandSeekAd;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class LandSeekdAdRepository extends AbstractRepository implements LandSeekAdRepositoryInterface
{
    public function entity()
    {
        return LandSeekAd::class;
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): LandSeekAd
    {
        $ad = new LandSeekAd();

        $ad->fill($data);

        dd($data);

        $ad->save();

        return $ad;
    }
}