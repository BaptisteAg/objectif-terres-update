<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\OfferGenre
 *
 * @property int $id
 * @property string $name
 * @property LandSeekAd[] $landSeekAds
 * @property Building[] $buildings
 * @property House[] $houses
 * @property Land[] $lands
 * @property Research[] $researches
 * @property string $offer_genre_model
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $buildings_count
 * @property-read int|null $houses_count
 * @property-read int|null $land_seek_ads_count
 * @property-read int|null $lands_count
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereOfferGenreModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->hasMany(LandSeekAd::class, 'offer_type_id');
    }

    /**
     * Get all of the buildings who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function buildings()
    {
        return $this->morphedByMany(Building::class, 'offerable_genre');
    }

    /**
     * Get all of the houses who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function houses()
    {
        return $this->morphedByMany(House::class, 'offerable_genre');
    }

    /**
     * Get all of the lands who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function lands()
    {
        return $this->morphedByMany(Land::class, 'offerable_genre');
    }

    /**
     * Get all of the researches who have an offer_genre.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany(Research::class, 'offerable_genre');
    }

}
