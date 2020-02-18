<?php

namespace App\Models;

use App\Models\Traits\EducationLevelable;
use App\Models\Traits\JobOfferTypable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobOfferAd
 *
 * @property int $id
 * @property int|null $is_activity_transmission
 * @property string $job_description
 * @property string $experience_farming
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AgriculturalActivity[] $agriculturalActivity
 * @property-read int|null $agricultural_activity_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationLevel[] $educationLevels
 * @property-read int|null $education_levels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JobOfferType[] $jobOfferTypes
 * @property-read int|null $job_offer_types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereIsActivityTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereJobDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobOfferAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobOfferAd extends Model
{
    use JobOfferTypable;
    use EducationLevelable;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'is_activity_transmission',
        'experience_farming',
        'job_description'

        //'is_beneficiary',
        //'education_level_id',
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function agriculturalActivity()
    {
        return $this->belongsToMany(AgriculturalActivity::class)->withTimestamps();
    }
}
