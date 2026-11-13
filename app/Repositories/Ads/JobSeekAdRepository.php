<?php

namespace App\Repositories\Ads;

use App\Models\JobSeekAd;
use App\Repositories\Eloquent\AbstractRepository;

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
        $jobSeekAd = new JobSeekAd;

        $this->save($jobSeekAd, $data);

        return $jobSeekAd;
    }

    /**
     * Updates an ad.
     *
     * @param JobSeekAd
     * @param array
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

        $productionGenres = $data['production_genres'] ?? [];
        $jobSeekAd->productionGenres()->sync($productionGenres);

        $productionGenresSecondary = $data['secondary_production_genres'] ?? [];
        foreach ($productionGenresSecondary as $productionGenreSecondary) {
            $jobSeekAd->productionGenresSecondary()->attach($productionGenreSecondary, ['type' => 'secondary']);
        }

        $jobSeekAd->jobOfferTypes()->sync($data['offer_types'] ?? []);
        $jobSeekAd->educationLevels()->sync($data['education_levels'] ?? []);
    }
}
