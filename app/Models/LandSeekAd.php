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
 * @property string|null $title
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
 * @property-read \App\Models\InstallationType|null $installationType
 * @property-read \App\Models\OfferGenre|null $offerGenre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PriceRange[] $priceRanges
 * @property-read int|null $price_ranges_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereTitle($value)
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
        'ad_id', 'installation_type_id', 'offer_type_id', 'is_bio', 'production_type_add', 'has_farm_buildings', 'has_houses', 'experience_farming', 'rent_min', 'rent_max'
    ];

    /**
     * @return HasOne
     */
    public function ad()
    {
        return $this->HasOne(Ad::class);
    }

    /**
     * @return BelongsTo
     */
    public function installationType()
    {
        return $this->belongsTo(InstallationType::class);
    }

    /**
     * @return BelongsTo
     */
    public function offerGenre()
    {
        return $this->belongsTo(OfferGenre::class, 'offer_genre_id');
    }

    /**
     * @return belongsToMany
     */
    public function priceRanges()
    {
        return $this->belongsToMany(PriceRange::class)->withTimestamps();
    }

    /**
     * @return belongsToMany
     */
    public function surfaceRanges()
    {
        return $this->belongsToMany(SurfaceRange::class)->withTimestamps();
    }
}
