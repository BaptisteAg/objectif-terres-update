<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SurfaceRange
 *
 * @property int $id
 * @property string $label
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SurfaceRange whereValue($value)
 * @mixin \Eloquent
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
        return $this->belongsToMany(LandSeekAd::class)->withTimestamps();
    }
}
