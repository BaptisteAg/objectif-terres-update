<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $attributionAds
 * @property-read int|null $attribution_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdStatus extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function researches()
    {
        return $this->belongsToMany(Research::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributionAds()
    {
        return $this->hasMany(AttributionAd::class);
    }
}
