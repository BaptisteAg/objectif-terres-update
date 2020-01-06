<?php

namespace App\Models;

use App\Traits\BioCertifiable;
use App\Traits\OfferableGenre;
use App\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $sf_id
 * @property string $name
 * @property int $surface_min
 * @property int $surface_max
 * @property boolean $has_pics
 * @property boolean $has_house
 * @property int $price_min
 * @property int $price_max
 * @property JobStatus[] $jobStatuses
 * @property ProjectStatus[] $projectStatuses
 * @property AdStatus[] $adStatuses
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
        'sf_id', 'name', 'surface_min', 'surface_max', 'has_pics', 'has_house', 'price_min', 'price_max'
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
