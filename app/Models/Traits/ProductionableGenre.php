<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;


Trait ProductionableGenre
{

    /**
     * Get all production_genres
     *
     * @return MorphToMany
     */
    public function productionGenres()
    {
        return $this->morphToMany('App\Models\ProductionGenre', 'productionable_genre');
    }
}