<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property AttributionAd[] $attributionAds
 */
class RefusalType extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'content'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributionAds()
    {
        return $this->hasMany('App\Models\AttributionAd');
    }
}
