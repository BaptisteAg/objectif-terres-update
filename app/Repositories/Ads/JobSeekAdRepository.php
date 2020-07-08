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
	 * @return JobSeekAd
	 */
    public function create(array $data): JobSeekAd
    {
        $jobSeekAd = new JobSeekAd();

        $this->save($jobSeekAd, $data);

        return $jobSeekAd;
    }

	/**
	 * Updates an ad.
	 *
	 * @param JobSeekAd
	 * @param array
	 * @return JobSeekAd
	 */
    public function update($jobSeekAd, array $data): JobSeekAd
    {
        $this->save($jobSeekAd, $data);

        return $jobSeekAd;
    }

    private function save(JobSeekAd $jobSeekAd, array $data)
    {
        $jobSeekAd->fill($data);
        $jobSeekAd->save();

        $jobSeekAd->jobOfferTypes()->sync($data["offer_types"] ?? []);
        $jobSeekAd->educationLevels()->sync($data["education_levels"] ?? []);
    }
}
