<?php namespace App\Repositories\Ads;

use App\Models\JobOfferAd;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class JobOfferAdRepository extends AbstractRepository
{
    public function entity()
    {
        return JobOfferAd::class;
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): JobOfferAd
    {
        $jobOfferAd = new JobOfferAd();
        $jobOfferAd->fill($data);
        $jobOfferAd->save();

        if(isset($data["offer_types"])) {
            foreach ($data["offer_types"] as $offerGenreId) {
                $jobOfferAd->jobOfferTypes()->attach($offerGenreId);
            }
        }
        if(isset($data["education_levels"])) {
            foreach($data["education_levels"] as $offerGenreId) {
                $jobOfferAd->educationLevels()->attach($offerGenreId);
            }
        }

        return $jobOfferAd;
    }
}
