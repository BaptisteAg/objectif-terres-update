<?php namespace App\Repositories\Ads;

use App\Models\JobSeekAd;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class JobSeekAdRepository extends AbstractRepository
{
    public function entity()
    {
        return JobSeekAd::class;
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): JobSeekAd
    {
        $jobOfferAd = new JobSeekAd();
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
