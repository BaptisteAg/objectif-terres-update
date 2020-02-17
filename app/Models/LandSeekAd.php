<?php

namespace App\Models;

use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * App\Models\LandSeekAd
 *
 * @property int $id
 * @property int|null $is_bio
 * @property string|null $production_type_add
 * @property int|null $has_farm_buildings
 * @property int|null $has_houses
 * @property string|null $experience_farming
 * @property int|null $rent_min
 * @property int|null $rent_max
 * @property int $ad_id
 * @property int|null $surface_range_min
 * @property int|null $surface_range_max
 * @property int|null $installation_type_id
 * @property int|null $offer_genre_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAdBuilding[] $buildings
 * @property-read int|null $buildings_count
 * @property-read \App\Models\InstallationType|null $installationType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SurfaceRange[] $surfaceRanges
 * @property-read int|null $surface_ranges_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereHasFarmBuildings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereHasHouses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereInstallationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereIsBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereOfferGenreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereRentMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereRentMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereSurfaceRangeMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereSurfaceRangeMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandSeekAd extends Model
{
    use ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'installation_type_id',
        'offer_type_id',
        'is_bio',
        'production_type_add',
        'experience_farming',
        'surface_range_min',
        'surface_range_max',
        /*'has_farm_buildings',
        'has_houses',
        'rent_min',
        'rent_max'*/
    ];

    /**
     * @return HasOne
     */
    public function ad()
    {
        return $this->hasOne(Ad::class);
    }

    /**
     * @return BelongsTo
     */
    public function installationType()
    {
        return $this->belongsTo(InstallationType::class);
    }


    public function buildings()
    {
        return $this->hasMany(LandSeekAdBuilding::class);
    }

    /**
     * @return belongsToMany
     */
    /*public function surfaceRanges()
    {
        return $this->belongsToMany(SurfaceRange::class)->withTimestamps();
    }*/

    /*public function priceRanges()
    {
        return $this->belongsToMany(PriceRange::class)->withTimestamps();
    }*/
}
