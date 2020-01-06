<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property AttributionAd[] $attributionAds
 */
class PpType extends Model
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
    public function attributionAds()
    {
        return $this->hasMany('App\Models\AttributionAd', 'lead_type_id');
    }
}
