<?php

namespace App\Models;

use App\Models\Scopes\ScopeAdTypesFilterable;
use App\Models\Scopes\ScopeDataFilterable;
use App\Models\Scopes\ScopeLocationFilterable;
use App\Models\Traits\Documentable;
use App\Presenters\AdPresenter;
use Chelout\RelationshipEvents\Concerns\HasMorphedByManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;


/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $user_pp_id
 * @property int $is_draft
 * @property int $accept_share_contact_infos
 * @property string|null $title
 * @property string|null $about_content
 * @property string|null $about_project_content
 * @property int|null $project_id
 * @property string|null $support_request_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $is_partner
 * @property int|null $support_request_id_region
 * @property int|null $support_request_territory_id
 * @property string|null $origin
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
 * @property-read \App\Models\JobOfferAd|null $jobOfferAd
 * @property-read \App\Models\JobSeekAd|null $jobSeekAd
 * @property-read \App\Models\LandOfferAd|null $landOfferAd
 * @property-read \App\Models\LandSeekAd|null $landSeekAd
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\Region|null $supportRequestIdRegion
 * @property-read \App\Models\Territory|null $supportRequestTerritoryId
 * @property-read \App\Models\Thread|null $threadAlreadyExist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Thread[] $threads
 * @property-read int|null $threads_count
 * @property-read \App\Models\User $userPp
 * @method static Builder|Ad filterAdTypes($adTypesFilters, $relationTableName = '')
 * @method static Builder|Ad filterAdsTerritoryLocations($territoriesCode)
 * @method static Builder|Ad filterLocations($relationshipName, $locationableIds)
 * @method static Builder|Ad filterRegions($regionCode)
 * @method static Builder|Ad filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static Builder|Ad filterSupportRequestRegionId($territoriesId, $userRole)
 * @method static Builder|Ad filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static Builder|Ad filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static Builder|Ad filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static Builder|Ad newModelQuery()
 * @method static Builder|Ad newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ad onlyTrashed()
 * @method static Builder|Ad query()
 * @method static Builder|Ad whereAboutContent($value)
 * @method static Builder|Ad whereAboutProjectContent($value)
 * @method static Builder|Ad whereAcceptShareContactInfos($value)
 * @method static Builder|Ad whereCreatedAt($value)
 * @method static Builder|Ad whereDeletedAt($value)
 * @method static Builder|Ad whereId($value)
 * @method static Builder|Ad whereIsDraft($value)
 * @method static Builder|Ad whereIsPartner($value)
 * @method static Builder|Ad whereOrigin($value)
 * @method static Builder|Ad whereProjectId($value)
 * @method static Builder|Ad whereSupportRequestIdRegion($value)
 * @method static Builder|Ad whereSupportRequestTerritoryId($value)
 * @method static Builder|Ad whereSupportRequestText($value)
 * @method static Builder|Ad whereTitle($value)
 * @method static Builder|Ad whereUpdatedAt($value)
 * @method static Builder|Ad whereUserPpId($value)
 * @method static \Illuminate\Database\Query\Builder|Ad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ad withoutTrashed()
 * @mixin \Eloquent
 */
class Ad extends Model implements HasPresenter
{
	use Documentable,
		ScopeAdTypesFilterable,
		ScopeDataFilterable,
		ScopeLocationFilterable,
		SoftDeletes,
		HasMorphedByManyEvents,
		HasRelationshipObservables;

	/**
	 * @var array
	 */
	protected $fillable = [
		'project_id',
		'user_pp_id',
		'is_draft',
		'title',
		'about_content',
		'about_project_content',
		'accept_share_contact_infos',
		'support_request_text',
		'support_request_id_region',
		'support_request_territory_id',
		'is_partner',
		'created_at',
		'origin'
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userPp()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function attributionAd()
	{
		return $this->hasOne(AttributionAd::class)->orderByDesc("id");
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
	 * TODO delete this column and all occurrences
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function supportRequestIdRegion()
	{
		return $this->belongsTo(Region::class, 'support_request_id_region');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function supportRequestTerritoryId()
	{
		return $this->belongsTo(Territory::class, 'support_request_territory_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function history()
	{
		return $this->morphMany(History::class, 'ads');
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

	protected static function boot()
	{
		parent::boot();

		/**
		 * Many To Many Polymorphic Relationship Events
		 */

		static::morphedByManyAttaching(function ($relation, $parent, $ids, $attributes) {
		});
	}

}
