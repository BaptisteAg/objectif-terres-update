<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AgriculturalActivity
 *
 * @property int $id
 * @property string $name
 * @property JobAd[] $jobAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $job_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AgriculturalActivity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AgriculturalActivity extends Model
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
    public function jobAds()
    {
        return $this->belongsToMany('App\Models\JobAd')->withTimestamps();
    }
}
