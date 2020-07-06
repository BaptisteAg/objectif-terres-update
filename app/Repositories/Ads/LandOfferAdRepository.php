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

        $landOfferAd->productionGenres()->sync($data["production_genres"] ?? []);

        $landOfferAd->productionGenresPossible()->detach();
        foreach($data["production_genres_wanted"] ?? [] as $productionGenreId) {
            $landOfferAd->productionGenresPossible()->attach($productionGenreId, ["type" => "possible"]);
        }

        $landOfferAd->bioCertifications()->sync($data["bio_certifications"] ?? []);

        $landOfferAd->offerGenres()->sync($data["offer_genres"] ?? []);
    }
}
