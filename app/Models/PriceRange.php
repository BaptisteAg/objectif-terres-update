<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $price
 * @property LandSeekAd[] $landSeekAds
 */
class PriceRange extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'price'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function landSeekAds()
    {
        return $this->belongsToMany('App\Models\LandSeekAd')->withTimestamps();
    }
}
