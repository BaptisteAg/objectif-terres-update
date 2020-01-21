<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\OfferableGenre;
use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Research
 *
 * @property int $id
 * @property string $sf_id
 * @property string $name
 * @property int $surface_min
 * @property int $surface_max
 * @property boolean $has_pics
 * @property boolean $has_house
 * @property int $price_min
 * @property int $price_max
 * @property string $ad_type
 * @property JobStatus[] $jobStatuses
 * @property ProjectStatus[] $projectStatuses
 * @property AdStatus[] $adStatuses
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $ad_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read int|null $job_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read int|null $project_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereHasPics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research wherePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSfId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSurfaceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereSurfaceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Research extends Model
{
    use OfferableGenre;
    use BioCertifiable;
    use ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'sf_id', 'name', 'surface_min', 'surface_max', 'has_pics', 'has_house', 'price_min', 'price_max', 'ad_type'
    ];

    /**
     * @return belongsToMany
     */
    public function adStatuses()
    {
        return $this->belongsToMany('App\Models\AdStatus')->withTimestamps();
    }

    /**
     * @return belongsToMany
     */
    public function jobStatuses()
    {
        return $this->belongsToMany('App\Models\JobStatus')->withTimestamps();
    }

    /**
     * @return belongsToMany
     */
    public function projectStatuses()
    {
        return $this->belongsToMany('App\Models\ProjectStatus')->withTimestamps();
    }

    /**
     * Get all cities 'location' for the ad
     * @return MorphToMany
     */
    public function cities()
    {
        return $this->morphedbyMany('App\Models\City', 'locationable_research');
    }

    /**
     * Get all cities 'location' for the ad
     * @return MorphToMany
     */
    public function departments()
    {
        return $this->morphedbyMany('App\Models\Department', 'locationable_research');
    }

    /**
     * Get all cities 'location' for the ad
     * @return MorphToMany
     */
    public function regions()
    {
        return $this->morphedbyMany('App\Models\Region', 'locationable_research');
    }
}
