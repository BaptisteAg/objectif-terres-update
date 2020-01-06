<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property LandSeekAd[] $landSeekAds
 */
class InstallationType extends Model
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
    public function landSeekAds()
    {
        return $this->hasMany('App\Models\LandSeekAd');
    }
}
