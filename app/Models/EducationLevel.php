<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EducationLevel
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferAd[] $jobOfferAds
 * @property-read int|null $job_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EducationLevel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EducationLevel extends Model
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
}
