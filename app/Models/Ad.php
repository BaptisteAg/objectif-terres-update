<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use App\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use McCool\LaravelAutoPresenter\HasPresenter;


class Ad extends Model implements HasPresenter
{
    use Documentable;

    /**
     * @var array
     */
    protected $fillable = [
        'attribution_ad_id', 'project_id', 'user_pp_id', 'user_admin_id', 'is_draft', 'about_content', 'about_project_content'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attributionAd()
    {
        return $this->hasOne(AttributionAd::class);
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
    public function adMessages()
    {
        return $this->hasMany(AdMessage::class);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function threads()
	{
		return $this->hasMany(Thread::class);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jobAd()
    {
        return $this->hasOne(JobAd::class);
    }

    public function jobOfferAd()
    {
        return $this->hasOne(JobAd::class)->where('is_offer', '=', true);
    }

    public function jobSeekAd()
    {
        return $this->hasOne(JobAd::class)->where('is_offer', '=', false);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ppToUserMessages()
    {
        return $this->hasMany(PpToUserMessage::class);
    }

    /**
    * Get all cities 'location' for the ad
    * @return MorphToMany
    */
    public function cities()
    {
        return $this->morphedbyMany(City::class, 'locationable_ad');
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
