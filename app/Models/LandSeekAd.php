<?php

namespace App\Models;

use App\Models\Traits\EducationLevelable;
use App\Models\Traits\OfferableGenre;
use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Models\LandSeekAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int|null $installation_type_id
 * @property int|null $is_bio
 * @property string|null $production_type_add
 * @property string|null $land_description
 * @property string|null $experience_farming
 * @property int|null $surface_range_min
 * @property int|null $surface_range_max
 * @property int|null $price_max
 * @property int|null $rent_max
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAdBuilding[] $buildings
 * @property-read int|null $buildings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \App\Models\InstallationType|null $installationType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereInstallationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereIsBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereLandDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereProductionTypeAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereRentMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereSurfaceRangeMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereSurfaceRangeMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandSeekAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandSeekAd extends Model
{
    use ProductionableGenre;
    use OfferableGenre;
    use EducationLevelable;

	/**
	 * @return BelongsTo
	 */
	public function ad()
	{
		return $this->belongsTo(Ad::class, 'ad_id', 'id');
	}

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
        'land_description',
        'surface_range_min',
        'surface_range_max',
        'rent_max',
        'price_max',
    ];

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

}
