<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RefusalType
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property AttributionAd[] $attributionAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $attribution_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RefusalType whereUpdatedAt($value)
 * @mixin \Eloquent
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
