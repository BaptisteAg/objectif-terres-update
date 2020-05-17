<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InstallationType
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandSeekAd[] $landSeekAds
 * @property-read int|null $land_seek_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InstallationType whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->hasMany(LandSeekAd::class);
    }
}
