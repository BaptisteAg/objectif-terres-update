<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait ProductionableGenre
{
    /**
     * Get all production_genres
     *
     * @return MorphToMany
     */
    public function productionGenres()
    {
        return $this->morphToMany(\App\Models\ProductionGenre::class, 'productionable_genre')->withPivot('type')->wherePivot('type', 'actual');
    }

    /**
     * Get all production_genres
     *
     * @return MorphToMany
     */
    public function productionGenresPossible()
    {
        return $this->morphToMany(\App\Models\ProductionGenre::class, 'productionable_genre')->withPivot('type')->wherePivot('type', 'possible');
    }

    /**
     * Get all production_genres
     */
    public function productionGenresSecondary(): morphToMany
    {
        return $this->morphToMany(\App\Models\ProductionGenre::class, 'productionable_genre')
            ->withPivot('type')
            ->wherePivotIn('type', ['secondary', 'possible']);
    }
}
