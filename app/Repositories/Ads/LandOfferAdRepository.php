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

        $productionGenres = $data["production_genre"] ?? [];

        if(in_array('other', $productionGenres)) {
            $data["production_type_add"] = "";
            $productionGenres = Arr::where($productionGenres, function($productionGenre) {return $productionGenre !== 'other';});
        }

        $landOfferAd->fill($data);

        $landOfferAd->save();

        if (count($productionGenres)) {
            $landOfferAd->productionGenres()->attach($productionGenres);
        }

        return $landOfferAd;
    }
}
