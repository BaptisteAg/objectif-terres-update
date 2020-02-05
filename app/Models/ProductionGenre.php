<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\ProductionGenre
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductionGenre whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->morphedByMany(LandSeekAd::class, 'productionable_genre');
    }

    /**
     * Get all of the land_offer_ads who have productionGenre.
     *
     * @return MorphToMany
     */
    public function landOfferAds()
    {
        return $this->morphedByMany(LandOfferAd::class, 'productionable_genre');
    }

    /**
     * Get all of the researches who have productionGenre.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany(Research::class, 'productionable_genre');
    }
}
