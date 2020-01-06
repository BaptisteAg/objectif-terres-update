<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property JobAd[] $jobAds
 * @property Research[] $researches
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
