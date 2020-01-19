<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\LandSeekAdRepositoryInterface;
use App\Models\Ad;
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
        $landSeekAd = new LandSeekAd();

        $landSeekAd->fill($data);

        $landSeekAd->save();

        $surfaceRanges = $data["surface_range"] ?? [];
        if (count($surfaceRanges)) {
            $landSeekAd->surfaceRanges()->attach($surfaceRanges);
        }

        $priceRanges = $data["price_range"] ?? [];
        if (count($priceRanges)) {
            $landSeekAd->priceRanges()->attach($priceRanges);
        }

        $productionGenres = $data["production_genre"] ?? [];
        if (count($productionGenres)) {
            $landSeekAd->productionGenres()->attach($productionGenres);
        }

        return $landSeekAd;
    }
}
