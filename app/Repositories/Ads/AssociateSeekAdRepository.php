<?php

namespace App\Repositories\Ads;

use App\Models\AssociateSeekAd;
use Illuminate\Support\Arr;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class AssociateSeekAdRepository extends AbstractRepository
{
    public function entity()
    {
        return AssociateSeekAd::class;
    }

    /**
     * Creates an ad.
     *
     * @param int
     * @param array
     */
    public function create(array $data): AssociateSeekAd
    {
        $associateSeekAd = new AssociateSeekAd;

        $this->save($associateSeekAd, $data);

        return $associateSeekAd;
    }

    /**
     * Update an ad.
     *
     * @param  AssociateSeekAd  $associateSeekAd
     */
    public function update($associateSeekAd, array $data): AssociateSeekAd
    {
        $this->save($associateSeekAd, $data);

        return $associateSeekAd;
    }

    private function save(AssociateSeekAd $associateSeekAd, array $data)
    {
        $associateSeekAd->fill($data);
        $associateSeekAd->save();

        $productionGenres = $data['production_genres'] ?? [];
        if (in_array('other', $productionGenres)) {
            $productionGenres = Arr::where($productionGenres, function ($productionGenre) {
                return $productionGenre !== 'other';
            });
        }
        $associateSeekAd->productionGenres()->sync($productionGenres);

        $productionGenresSecondary = $data['secondary_production_genres'] ?? [];
        $associateSeekAd->productionGenresSecondary()->detach();
        foreach ($productionGenresSecondary as $productionGenreId) {
            if ($productionGenreId !== 'other') {
                $associateSeekAd->productionGenresSecondary()->attach($productionGenreId, ['type' => 'secondary']);
            }
        }

        $associateSeekAd->educationLevels()->sync($data['education_levels'] ?? []);
    }
}
