<?php namespace App\Repositories\Ads;

use App\Models\LandOfferAd;
use Illuminate\Support\Arr;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class LandOfferAdRepository extends AbstractRepository implements LandOfferAdRepositoryInterface
{
    public function entity()
    {
        return LandOfferAd::class;
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): LandOfferAd
    {
        $landOfferAd = new LandOfferAd();

        $landOfferAd->fill($data);

        $landOfferAd->save();

        return $landOfferAd;
    }
}
