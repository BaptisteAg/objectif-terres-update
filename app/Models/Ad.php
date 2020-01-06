<?php

namespace App\Models;

use App\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property int $attribution_ad_id
 * @property int $project_id
 * @property string $sf_pp_id
 * @property string $sf_admin_id
 * @property boolean $is_draft
 * @property string $about_content
 * @property string $about_project_content
 * @property AttributionAd $attributionAd
 * @property Project $project
 * @property AdMessage[] $adMessages
 * @property AdNote[] $adNotes
 * @property JobAd $jobAds
 * @property LandOfferAd $landOfferAds
 * @property LandSeekAd $landSeekAds
 * @property PpToUserMessage[] $ppToUserMessages
 */
class Ad extends Model
{

    use Documentable;

    /**
     * @var array
     */
    protected $fillable = [
        'attribution_ad_id', 'project_id', 'sf_pp_id', 'sf_admin_id', 'is_draft', 'about_content', 'about_project_content'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attributionAd()
    {
        return $this->hasOne('App\Models\AttributionAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adMessages()
    {
        return $this->hasMany('App\Models\AdMessage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adNotes()
    {
        return $this->hasMany('App\Models\AdNote');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoriteAd()
    {
        return $this->hasMany('App\Models\FavoriteAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jobAds()
    {
        return $this->hasOne('App\Models\JobAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landOfferAds()
    {
        return $this->hasOne('App\Models\LandOfferAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landSeekAds()
    {
        return $this->hasOne('App\Models\LandSeekAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ppToUserMessages()
    {
        return $this->hasMany('App\Models\PpToUserMessage');
    }

    /**
    * Get all cities 'location' for the ad
    * @return MorphToMany
    */
    public function cities()
    {
        return $this->morphedbyMany('App\Models\City', 'locationable_ad');
    }

    /**
    * Get all cities 'location' for the ad
    * @return MorphToMany
    */
    public function departments()
    {
        return $this->morphedbyMany('App\Models\Department', 'locationable_ad');
    }

    /**
    * Get all cities 'location' for the ad
    * @return MorphToMany
    */
    public function regions()
    {
        return $this->morphedbyMany('App\Models\Region', 'locationable_ad');
    }
}
