<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int $education_level_id
 * @property int $job_status_id
 * @property string $title
 * @property boolean $is_offer
 * @property boolean $is_beneficiary
 * @property int $experience_farming
 * @property string $about_project_content
 * @property Ad $ad
 * @property EducationLevel $educationLevel
 * @property JobStatus $jobStatus
 * @property AgriculturalActivity[] $agriculturalActivity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $agricultural_activity_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereEducationLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereExperienceFarming($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereIsBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereIsOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereJobStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JobAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobAd extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'education_level_id', 'job_status_id', 'title', 'is_offer', 'is_beneficiary', 'experience_farming'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function educationLevel()
    {
        return $this->belongsTo('App\Models\EducationLevel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobStatus()
    {
        return $this->belongsTo('App\Models\JobStatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function agriculturalActivity()
    {
        return $this->belongsToMany('App\Models\AgriculturalActivity')->withTimestamps();
    }
}
