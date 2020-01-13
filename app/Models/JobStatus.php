<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobStatus
 *
 * @property int $id
 * @property string $name
 * @property JobAd[] $jobAds
 * @property Research[] $researches
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $Researches
 * @property-read int|null $researches_count
 * @property-read int|null $job_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobStatus extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobAds()
    {
        return $this->hasMany('App\Models\JobAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function Researches()
    {
        return $this->belongsToMany('App\Models\Research')->withTimestamps();
    }
}
