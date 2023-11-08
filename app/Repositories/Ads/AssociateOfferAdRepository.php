<?php

namespace App\Repositories\Ads;

use App\Models\AssociateOfferAd;
use App\Models\LandSeekAd;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class AssociateOfferAdRepository extends AbstractRepository
{
    public function entity(): string
    {
        return AssociateOfferAd::class;
    }

    /**
     * Creates an ad.
     *
     * @param array $data
     * @return AssociateOfferAd
     */
    public function create(array $data): AssociateOfferAd
    {
        $associateOfferAd = new AssociateOfferAd();

        $this->save($associateOfferAd, $data);

        return $associateOfferAd;
    }

    /**
     * Update an ad.
     *
     * @param AssociateOfferAd $associateOfferAd
     * @param array $data
     * @return LandSeekAd
     */
    public function update($associateOfferAd, array $data): AssociateOfferAd
    {
        $this->save($associateOfferAd, $data);

        return $associateOfferAd;
    }

    private function save(AssociateOfferAd $associateOfferAd, array $data)
    {
        $associateOfferAd->fill($data);
        $associateOfferAd->save();

        $productionGenres = $data["production_genres"] ?? [];
        $associateOfferAd->productionGenres()->sync($productionGenres);

        $productionGenresSecondary = $data["secondary_production_genres"] ?? [];
        foreach($productionGenresSecondary as $productionGenreSecondary) {
            $associateOfferAd->productionGenresSecondary()->attach($productionGenreSecondary, ['type' => 'secondary']);
        }

        $associateOfferAd->bioCertifications()->sync($data["bio_certifications"] ?? []);

        $associateOfferAd->educationLevels()->sync($data["education_levels"] ?? []);
    }
}
