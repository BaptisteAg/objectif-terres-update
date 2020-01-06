<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
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
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function ad()
    {
        return $this->hasOne('App\Models\Ad');
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
