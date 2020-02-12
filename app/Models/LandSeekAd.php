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
 * @property int $ad_id
 * @property int $installation_type_id
 * @property int $offer_type_id
 * @property string $title
 * @property boolean $is_bio
 * @property string $production_type_add
 * @property boolean $has_farm_buildings
 * @property boolean $has_houses
 * @property string $experience_farming
 * @property float $rent_min
 * @property float $rent_max
 * @property Ad $ad
 * @property InstallationType $installationType
 * @property OfferGenre $offerGenre
 * @property PriceRange[] $priceRanges
 * @property SurfaceRange[] $surfaceRanges
 * @property int|null $offer_genre_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $price_ranges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $surface_range_min
 * @property int|null $surface_range_max
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereSurfaceRangeMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandSeekAd whereSurfaceRangeMin($value)
 */
class LandSeekAd extends Model
{
    use ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'installation_type_id', 'offer_type_id', 'title', 'is_bio', 'production_type_add', 'has_farm_buildings', 'has_houses', 'experience_farming', 'rent_min', 'rent_max'
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
