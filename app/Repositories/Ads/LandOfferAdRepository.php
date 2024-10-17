<?php namespace App\Repositories\Ads;

use App\Models\Building;
use App\Models\House;
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

		$this->save($landOfferAd, $data);

		return $landOfferAd;
	}

	/**
	 * Update an ad.
	 *
	 * @param LandOfferAd $landOfferAd
	 * @param array $data
	 */
	public function update($landOfferAd, array $data): LandOfferAd
	{
		$this->save($landOfferAd, $data);

		return $landOfferAd;
	}

	private function save(LandOfferAd $landOfferAd, array $data)
	{
		$landOfferAd->fill($data);
		$landOfferAd->save();

        $productionGenres = $data["production_genres"] ?? [];
        if(in_array('other', $productionGenres)) {
            $productionGenres = Arr::where($productionGenres, function($productionGenre) {return $productionGenre !== 'other';});
        }
		$landOfferAd->productionGenres()->sync($productionGenres);

        $productionGenresSecondary = $data["secondary_production_genres"] ?? [];
		$landOfferAd->productionGenresSecondary()->detach();
//        dd($landOfferAd->productionGenresSecondary->toArray());
		foreach ($productionGenresSecondary as $productionGenreId) {
		    if($productionGenreId !== 'other') {
                $landOfferAd->productionGenresSecondary()->attach($productionGenreId, ["type" => "secondary"]);
            }
		}

		$landOfferAd->bioCertifications()->sync($data["bio_certifications"] ?? []);

		$landOfferAd->offerGenres()->sync($data["offer_genres"] ?? []);

		if (isset($data['has_houses']) && $data['has_houses'] == 1) {
			$house = House::create($data['house']);
			//$house->offerGenres()->sync($data["house"]['offer_genres'] ?? []);
			$landOfferAd->house()->associate($house)->save();
		}
		if (isset($data['has_buildings']) && $data['has_buildings'] == 1) {
			$building = Building::create($data['building']);
			//$building->offerGenres()->sync($data["building"]['offer_genres'] ?? []);
			$landOfferAd->building()->associate($building)->save();
		}
	}
}
