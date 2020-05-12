<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use App\Models\LandSeekAd;
use Illuminate\Support\Arr;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class LandSeekAdRepository extends AbstractRepository implements LandSeekAdRepositoryInterface
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

        $productionGenres = $data["production_genres"] ?? [];
        $offerGenres = $data["offer_genres"] ?? [];
        $buildings = $data["buildings"] ?? [];

        if(in_array('other', $productionGenres)) {
            //$data["production_type_add"] = "";
            $productionGenres = Arr::where($productionGenres, function($productionGenre) {return $productionGenre !== 'other';});
        }

        $landSeekAd->fill($data);

        $landSeekAd->save();

        if (count($offerGenres)) {
            $landSeekAd->offerGenres()->attach($offerGenres);
        }

        if (count($productionGenres)) {
            $landSeekAd->productionGenres()->attach($productionGenres);
        }

        if (count($buildings)) {
            foreach($buildings as $buildingId => $requirementId) {
                $landSeekAd->buildings()->create([
                    "requirement_id" => $requirementId,
                    "building_type_id" => $buildingId,
                    "land_seek_ad_id" => $landSeekAd->id
                ]);
            }
        }

        return $landSeekAd;
    }

}
