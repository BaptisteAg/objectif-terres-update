<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\JobOfferTypable;
use App\Models\Traits\OfferableGenre;
use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Research
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $surface_min
 * @property string|null $surface_max
 * @property int $has_pics
 * @property int|null $has_house
 * @property int|null $price_min
 * @property int|null $price_max
 * @property string|null $ad_type
 * @property string|null $url
 * @property int $has_alert
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdStatus[] $adStatuses
 * @property-read int|null $ad_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferType[] $jobOfferTypes
 * @property-read int|null $job_offer_types_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresSecondary
 * @property-read int|null $production_genres_possible_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectStatus[] $projectStatuses
 * @property-read int|null $project_statuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Research newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Research newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Research query()
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereAdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereHasAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereHasHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereHasPics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research wherePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereSurfaceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereSurfaceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Research whereUserId($value)
 *
 * @mixin \Eloquent
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_secondary_count
 */
class Research extends Model
{
    use BioCertifiable;
    use JobOfferTypable;
    use Notifiable;
    use OfferableGenre;
    use ProductionableGenre;

    protected $table = 'researches';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'surface_min', 'surface_max', 'has_pics', 'has_house', 'price_min', 'price_max', 'ad_type', 'url', 'has_alert',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return belongsToMany
     */
    public function adStatuses()
    {
        return $this->belongsToMany(AdStatus::class)->withTimestamps();
    }

    /**
     * @return belongsToMany
     */
    public function projectStatuses()
    {
        return $this->belongsToMany(ProjectStatus::class)->withTimestamps();
    }

    /**
     * Get all cities 'location' for the research
     *
     * @return MorphToMany
     */
    public function cities()
    {
        return $this->morphedbyMany(City::class, 'locationable_research', 'locationable_researches');
    }

    /**
     * Get all cities 'location' for the research
     *
     * @return MorphToMany
     */
    public function departments()
    {
        return $this->morphedbyMany(Department::class, 'locationable_research', 'locationable_researches');
    }

    /**
     * Get all cities 'location' for the research
     *
     * @return MorphToMany
     */
    public function regions()
    {
        return $this->morphedbyMany(Region::class, 'locationable_research', 'locationable_researches');
    }
}
