<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property JobAd[] $jobAds
 */
class AgriculturalActivity extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobAds()
    {
        return $this->belongsToMany('App\Models\JobAd')->withTimestamps();
    }
}
