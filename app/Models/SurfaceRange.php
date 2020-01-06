<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $surface
 * @property LandSeekAd[] $landSeekAd
 */
class SurfaceRange extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'surface'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function landSeekAds()
    {
        return $this->belongsToMany('App\Models\LandSeekAd')->withTimestamps();
    }
}
