<?php namespace App\Repositories\Ads;

use App\Models\InstallationType;
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
	 * @return LandSeekAd
	 */
    public function update($landSeekAd, array $data): LandSeekAd
    {
        $this->save($landSeekAd, $data);

        return $landSeekAd;
    }

    private function save(LandSeekAd $landSeekAd, array $data): void
    {
        $landSeekAd->fill($data);

        $landSeekAd->save();

        $landSeekAd->offerGenres()->sync($data["offer_genres"] ?? []);

        $landSeekAd->educationLevels()->sync($data["education_levels"] ?? []);

        $installationType = InstallationType::findOrFail($data["installation_type_id"]);
        $landSeekAd->installationType()->associate($installationType);

        $productionGenres = $data["production_genres"] ?? [];

        if(in_array('other', $productionGenres)) {
            //$data["production_type_add"] = "";
            $productionGenres = Arr::where($productionGenres, function($productionGenre) {return $productionGenre !== 'other';});
        }
        $landSeekAd->productionGenres()->sync($productionGenres);

        $secondaryProductionGenres = $data["secondary_production_genres"] ?? [];
        if(in_array('other', $secondaryProductionGenres)) {
            //$data["production_type_add"] = "";
            $secondaryProductionGenres = Arr::where($secondaryProductionGenres, function($secondaryProductionGenre) {return $secondaryProductionGenre !== 'other';});
        }
        $productionGenresSecondary = $data["secondary_production_genres"] ?? [];
        $landSeekAd->productionGenresSecondary()->detach();
        foreach ($productionGenresSecondary as $productionGenreId) {
            if($productionGenreId !== 'other') {
                $landSeekAd->productionGenresSecondary()->attach($productionGenreId, ["type" => "secondary"]);
            }
        }

        //dd($landSeekAd, $data);

        $landSeekAd->buildings()->delete();
        foreach($data["buildings"] ?? [] as $buildingId => $requirementId) {
            $landSeekAd->buildings()->create([
                "requirement_id" => $requirementId,
                "building_type_id" => $buildingId,
                "land_seek_ad_id" => $landSeekAd->id
            ]);
        }

    }

}
