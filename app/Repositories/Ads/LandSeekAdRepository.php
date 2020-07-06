<?php namespace App\Repositories\Ads;

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

        $this->save($landSeekAd, $data);

        return $landSeekAd;
    }

    /**
     * Update an ad.
     *
     * @param LandSeekAd $landSeekAd
     * @param array $data
     */
    public function update($landSeekAd, array $data): LandSeekAd
    {
        $this->save($landSeekAd, $data);

        return $landSeekAd;
    }

    private function save(LandSeekAd $landSeekAd, array $data)
    {
        $productionGenres = $data["production_genres"] ?? [];
        $offerGenres = $data["offer_genres"] ?? [];
        $buildings = $data["buildings"] ?? [];
        $educationLevels = $data["education_levels"] ?? [];

        if(in_array('other', $productionGenres)) {
            //$data["production_type_add"] = "";
            $productionGenres = Arr::where($productionGenres, function($productionGenre) {return $productionGenre !== 'other';});
        }

        $landSeekAd->fill($data);

        $landSeekAd->save();

        if (count($offerGenres)) {
            $landSeekAd->offerGenres()->sync($offerGenres);
        }

        if (count($productionGenres)) {
            $landSeekAd->productionGenres()->sync($productionGenres);
        }

        if (count($educationLevels)) {
            $landSeekAd->productionGenres()->sync($educationLevels);
        }

        if (count($buildings)) {
            $landSeekAd->buildings()->delete();

            foreach($buildings as $buildingId => $requirementId) {
                $landSeekAd->buildings()->create([
                    "requirement_id" => $requirementId,
                    "building_type_id" => $buildingId,
                    "land_seek_ad_id" => $landSeekAd->id
                ]);
            }
        }
    }

}
