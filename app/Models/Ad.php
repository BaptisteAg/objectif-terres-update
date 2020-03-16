<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use App\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use McCool\LaravelAutoPresenter\HasPresenter;


/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $user_pp_id
 * @property int|null $user_admin_id
 * @property int $is_draft
 * @property int $accept_share_contact_infos
 * @property string|null $title
 * @property string|null $about_content
 * @property string|null $about_project_content
 * @property int|null $attribution_ad_id
 * @property int|null $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \App\Models\AttributionAd|null $attributionAd
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavoriteAd[] $favoriteAds
 * @property-read int|null $favorite_ads_count
 * @property-read \App\Models\JobOfferAd $jobOfferAd
 * @property-read \App\Models\JobSeekAd $jobSeekAd
 * @property-read \App\Models\LandOfferAd $landOfferAd
 * @property-read \App\Models\LandSeekAd $landSeekAd
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\Thread $threadAlreadyExist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \App\Models\User|null $userAdmin
 * @property-read \App\Models\User $userPp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAboutProjectContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAcceptShareContactInfos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereAttributionAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereIsDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUserAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ad whereUserPpId($value)
 * @mixin \Eloquent
 */
class Ad extends Model implements HasPresenter
{
    use Documentable;

    /**
     * @var array
     */
    protected $fillable = [
        'attribution_ad_id',
        'project_id',
        'user_pp_id',
        'user_admin_id',
        'is_draft',
        'title',
        'about_content',
        'about_project_content',
        'accept_share_contact_infos'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userPp()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAdmin()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributionAd()
    {
        return $this->belongsTo(AttributionAd::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function threads()
	{
		return $this->hasMany(Thread::class);
	}

	/**
	 * @return Builder|\Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function threadAlreadyExist()
	{
		return $this->hasOne(Thread::class)
			->whereHas('messages', function (Builder $query) {
				$query->where('sender_user_id', '=', auth()->id());
			});
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adNotes()
    {
        return $this->hasMany(AdNote::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favoriteAds()
    {
        return $this->hasMany(FavoriteAd::class);
    }


    public function jobOfferAd()
    {
        return $this->hasOne(JobOfferAd::class);
    }

    public function jobSeekAd()
    {
        return $this->hasOne(JobSeekAd::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landOfferAd()
    {
        return $this->hasOne(LandOfferAd::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landSeekAd()
    {
        return $this->hasOne(LandSeekAd::class);
    }

    /**
     * Get all cities 'location' for the ad
     * @return MorphToMany
     */
    public function cities()
    {
        return $this->morphedbyMany(City::class, 'locationable_ad')->withPivot('radius');
    }

    /**
     * Get all cities 'location' for the ad
     * @return MorphToMany
     */
    public function departments()
    {
        return $this->morphedbyMany(Department::class, 'locationable_ad');
    }

    /**
     * Get all cities 'location' for the ad
     * @return MorphToMany
     */
    public function regions()
    {
        return $this->morphedbyMany(Region::class, 'locationable_ad');
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
