<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PriceRange
 *
 * @property int $id
 * @property string $price
 * @property LandSeekAd[] $landSeekAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PriceRange whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->belongsToMany(LandSeekAd::class)->withTimestamps();
    }
}
