<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobOfferType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $Researches
 * @property-read int|null $researches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferAd[] $jobOfferAds
 * @property-read int|null $job_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobOfferType extends Model
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
    public function jobOfferAds()
    {
        return $this->hasMany(JobOfferAd::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function Researches()
    {
        return $this->belongsToMany(Research::class)->withTimestamps();
    }
}
