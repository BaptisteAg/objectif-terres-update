<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use App\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * App\Models\Ad
 *
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
 * @property JobAd $jobAd
 * @property LandOfferAd $landOfferAd
 * @property LandSeekAd $landSeekAd
 * @property PpToUserMessage[] $ppToUserMessages
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $ad_messages_count
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavoriteAd[] $favoriteAd
 * @property-read int|null $favorite_ad_count
 * @property-read int|null $pp_to_user_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutProjectContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAttributionAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereIsDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereSfAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereSfPpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ad extends Model implements HasPresenter
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
    public function jobAd()
    {
        return $this->hasOne('App\Models\JobAd');
    }

    public function jobOfferAd()
    {
        return $this->hasOne('App\Models\JobAd')->where('is_offer', '=', true);
    }

    public function jobSeekAd()
    {
        return $this->hasOne('App\Models\JobAd')->where('is_offer', '=', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landOfferAd()
    {
        return $this->hasOne('App\Models\LandOfferAd');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landSeekAd()
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

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return AdPresenter::class;
    }
}
