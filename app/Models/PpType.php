<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PpType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $attributionAds
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


}
