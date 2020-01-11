<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait OfferableGenre
{
    /**
     *
     * @return MorphToMany
     */
    public function offerGenres()
    {
        return $this->morphToMany('App\Models\OfferGenre', 'offerable_genre');
    }
}
