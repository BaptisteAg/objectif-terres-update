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

        $this->save($jobOfferAd, $data);

        return $jobOfferAd;
    }

    /**
     * Updates an ad.
     *
     * @param JobOfferAd
     * @param array
     * @return JobOfferAd
     */
    public function update($jobOfferAd, array $data): JobOfferAd
    {
        $this->save($jobOfferAd, $data);

        return $jobOfferAd;
    }

    private function save(JobOfferAd $jobOfferAd, array $data)
    {
        $jobOfferAd->fill($data);
        $jobOfferAd->save();

        $jobOfferAd->jobOfferTypes()->sync($data["offer_types"] ?? []);
        $jobOfferAd->educationLevels()->sync($data["education_levels"] ?? []);
    }
}
