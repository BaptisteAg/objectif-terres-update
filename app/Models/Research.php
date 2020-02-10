<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
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
 * @property string $name
 * @property int $surface_min
 * @property int $surface_max
 * @property boolean $has_pics
 * @property boolean $has_house
 * @property int $price_min
 * @property int $price_max
 * @property string $ad_type
 * @property string $url
 * @property boolean $has_alert
 * @property User $user
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Research whereUserId($value)
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
	use Notifiable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'name', 'surface_min', 'surface_max', 'has_pics', 'has_house', 'price_min', 'price_max', 'ad_type', 'url', 'has_alert'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(){
		$this->belongsTo(User::class);
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
	public function jobStatuses()
	{
		return $this->belongsToMany(JobStatus::class)->withTimestamps();
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
	 * @return MorphToMany
	 */
	public function cities()
	{
		return $this->morphedbyMany(City::class, 'locationable_research');
	}

	/**
	 * Get all cities 'location' for the research
	 * @return MorphToMany
	 */
	public function departments()
	{
		return $this->morphedbyMany(Department::class, 'locationable_research');
	}

	/**
	 * Get all cities 'location' for the research
	 * @return MorphToMany
	 */
	public function regions()
	{
		return $this->morphedbyMany(Region::class, 'locationable_research');
	}
}
