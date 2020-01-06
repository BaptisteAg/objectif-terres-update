<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 */
class ProductionGenre extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the land_seek_ads who have productionGenre.
     *
     * @return MorphToMany
     */
    public function landSeekAds()
    {
        return $this->morphedByMany('App\Models\LandSeekAd', 'productionable_genre');
    }

    /**
     * Get all of the land_offer_ads who have productionGenre.
     *
     * @return MorphToMany
     */
    public function landOfferAds()
    {
        return $this->morphedByMany('App\Models\LandOfferAd', 'productionable_genre');
    }

    /**
     * Get all of the researches who have productionGenre.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany('App\Models\Research', 'productionable_genre');
    }
}
