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

        if(isset($data["production_genres"])) {
            foreach($data["production_genres"] as $productionGenreId) {
                $landOfferAd->productionGenres()->attach($productionGenreId);
            }
        }
        if(isset($data["production_genres_wanted"])) {
            foreach($data["production_genres"] as $productionGenreId) {
                $landOfferAd->productionGenres()->attach($productionGenreId, ["type" => "possible"]);
            }
        }

        foreach($data["bio_certifications"] as $bioCertificationId) {
            $landOfferAd->bioCertifications()->attach($bioCertificationId);
        }

        foreach($data["offer_genres"] as $offerGenreId) {
            $landOfferAd->offerGenres()->attach($offerGenreId);
        }


        return $landOfferAd;
    }
}
