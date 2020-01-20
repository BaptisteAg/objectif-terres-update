<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\LandSeekAdRepositoryInterface;
use App\Models\Ad;
use App\Models\LandSeekAd;
use Illuminate\Support\Arr;
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

        $productionGenres = $data["production_genre"] ?? [];
        $surfaceRanges = $data["surface_range"] ?? [];
        $priceRanges = $data["price_range"] ?? [];

        if(in_array('other', $productionGenres)) {
            $data["production_type_add"] = "";
            $productionGenres = Arr::where($productionGenres, function($productionGenre) {return $productionGenre !== 'other';});
        }

        $landSeekAd->fill($data);

        $landSeekAd->save();

        if (count($surfaceRanges)) {
            $landSeekAd->surfaceRanges()->attach($surfaceRanges);
        }
        if (count($priceRanges)) {
            $landSeekAd->priceRanges()->attach($priceRanges);
        }
        if (count($productionGenres)) {
            $landSeekAd->productionGenres()->attach($productionGenres);
        }

        return $landSeekAd;
    }
}
