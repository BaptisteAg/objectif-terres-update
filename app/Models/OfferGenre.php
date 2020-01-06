<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property LandSeekAd[] $landSeekAds
 * @property Building[] $buildings
 * @property House[] $houses
 * @property Land[] $lands
 * @property Research[] $researches
 *
 */
class OfferGenre extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function landSeekAds()
    {
        return $this->hasMany('App\Models\LandSeekAd', 'offer_type_id');
    }

    /**
     * Get all of the buildings who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function buildings()
    {
        return $this->morphedByMany('App\Models\Building', 'offerable_genre');
    }

    /**
     * Get all of the houses who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function houses()
    {
        return $this->morphedByMany('App\Models\House', 'offerable_genre');
    }

    /**
     * Get all of the lands who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function lands()
    {
        return $this->morphedByMany('App\Models\Land', 'offerable_genre');
    }

    /**
     * Get all of the researches who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany('App\Models\Research', 'offerable_genre');
    }

}
