<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PpType
 *
 * @property int $id
 * @property string $name
 * @property AttributionAd[] $attributionAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $attribution_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpType whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->hasMany(AttributionAd::class, 'lead_type_id');
    }
}
