<?php

namespace App\Models;

use App\Models\Scopes\ScopeAdTypesFilterable;
use App\Models\Scopes\ScopeDataFilterable;
use App\Models\Scopes\ScopeLocationFilterable;
use App\Models\Traits\Documentable;
use App\Models\Traits\ProductionableGenre;
use App\Presenters\AdPresenter;
use Chelout\RelationshipEvents\Concerns\HasMorphedByManyEvents;
use Chelout\RelationshipEvents\Traits\HasRelationshipObservables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\History[] $history
 * @property-read int|null $history_count
 * @property int|null $department_id
 * @property-read \App\Models\FavoriteAd|null $currentUserFavoriteAd
 * @method static Builder|Ad whereDepartmentId($value)
 * @property int|null $third_party_ad_user_id
 * @property-read \App\Models\AssociateOfferAd|null $associateOfferAd²²
 * @property-read \App\Models\AssociateSeekAd|null $associateSeekAd
 * @property-read  \App\Models\Department|null $department
 * @property-read \App\Models\Department|null $main_department
 * @property-read string|null $type
 * @property-read \App\Models\ThirdPartyAdUser|null $thirdPartyAdUser
 * @property-read \App\Models\User|null $userModerator
 * @method static Builder|Ad whereThirdPartyAdUserId($value)
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

    private $cached_type = null;

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
        'origin',
        'department_id',
        'third_party_ad_user_id',
        'survey_thanks_to_platform',
        'survey_remarks',
    ];

    const AD_TYPES = [
        'jobOfferAd' => JobOfferAd::class,
        'jobSeekAd' => JobSeekAd::class,
        'landOfferAd' => LandOfferAd::class,
        'landSeekAd' => LandSeekAd::class,
        'associateSeekAd' => AssociateSeekAd::class,
        'associateOfferAd' => AssociateOfferAd::class,
    ];

    const SALESFORCE_FORM_BY_AD_TYPE = [
        'landSeekAd' => 'https://terredeliens.my.site.com/objectifterres/survey/runtimeApp.app?invitationId=0KibD0000000l6z&surveyName=annonce_recherche_de_foncier&UUID=54bcd02b-92d1-4ead-aaad-44c18c1dcb87',
        'landOfferAd' => 'https://terredeliens.my.site.com/objectifterres/survey/runtimeApp.app?invitationId=0KibD0000000lAD&surveyName=annonce_offre_de_foncier&UUID=5ac6ea4f-7f6e-4a1e-8f2a-52072a7d1bf3',
        'associateOfferAd' => 'https://terredeliens.my.site.com/objectifterres/survey/runtimeApp.app?invitationId=0KibD0000000l29&surveyName=annonce_recherche_d_associ_s_pour_ferme_en_activit&UUID=d37f60a2-f5b4-48ae-8b54-9aa06a7e31c6',
        'associateSeekAd' => 'https://terredeliens.my.site.com/objectifterres/survey/runtimeApp.app?invitationId=0KibD0000000l8b&surveyName=annonce_recherche_d_associ_pour_projet&UUID=fc0c6ab5-abc6-4b9b-a61c-a75aafb03883'
    ];

    public function getSubAdAttribute(): LandSeekAd|LandOfferAd|JobOfferAd|JobSeekAd|AssociateSeekAd|AssociateOfferAd|null
    {
        if ($this->type) {
            return $this->{$this->type};
        }

        return null;
    }

    // Detect the type based on the presence of the foreign key
    // in the related table
    public function getTypeAttribute(): ?string
    {
        if ($this->trashed()) {
            return null;
        }

        if (isset($this->cached_type)) {
            return $this->cached_type;
        }

        foreach (static::AD_TYPES as $key => $class) {
            if ($this->relationLoaded($key) && $this->{$key} !== null) {
                $this->cached_type = $key;
                return $key;
            }
        }

        $query = $this->newQuery()->where('id', $this->id);

        foreach (static::AD_TYPES as $key => $class) {
            $table = (new $class)->getTable();
            $query->selectSub(function (\Illuminate\Database\Query\Builder $query) use ($table) {
                $query->selectRaw('count(*)')
                    ->from($table)
                    ->whereColumn($table . '.ad_id', 'ads.id');
            }, $key);
        }

        $result = $query->first();
        $type = null;

        foreach (static::AD_TYPES as $key => $class) {
            if ($result->{$key}) {
                $type = $key;
            }
        }

        $this->cached_type = $type;

        return $type;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userPp()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
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
        return $this->hasMany(Thread::class)->orderByDesc('updated_at');
    }

    /**
     * @return Builder|HasOne
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

    /**
     * @return HasOne
     */
    public function currentUserFavoriteAd()
    {
        return $this->hasOne(FavoriteAd::class)->where('user_id', auth()->id());
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
     * @return hasOne
     */
    public function landOfferAd()
    {
        return $this->hasOne(LandOfferAd::class);
    }

    /**
     * @return hasOne
     */
    public function landSeekAd()
    {
        return $this->hasOne(LandSeekAd::class);
    }

    /**
     * @return hasOne
     */
    public function associateSeekAd(): hasOne
    {
        return $this->hasOne(AssociateSeekAd::class);
    }

    /**
     * @return hasOne
     */
    public function associateOfferAd(): hasOne
    {
        return $this->hasOne(AssociateOfferAd::class);
    }

    public function userModerator(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, AttributionAd::class, 'ad_id', 'id', 'id', 'user_moderator_id');
    }

    /**
     * Get all cities 'location' for the ad
     */
    public function cities(): MorphToMany
    {
        return $this->morphedbyMany(City::class, 'locationable_ad')->withPivot('radius');
    }

    /**
     * Get all cities 'location' for the ad
     */
    public function departments(): MorphToMany
    {
        return $this->morphedbyMany(Department::class, 'locationable_ad');
    }

    /**
     * @return \Illuminate\Support\Collection|array|Department[]
     */
    public function getSecondaryDepartmentsAttribute(): \Illuminate\Support\Collection|array
    {
        $departments = $this->departments->concat($this->cities->map(function (City $city) {
            return $city->department;
        }))->concat($this->regions->map(function (Region $region) {
            return $region->departments;
        })->flatten());

        return $departments->unique('code')
            ->filter(function (Department $department) {
                return $department->code !== $this->main_department?->code;
            });
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function getMainDepartmentAttribute(): ?Department
    {
        if($this->department) {
            return $this->department;
        }
        else if ($this->cities->count()) {
            return $this->cities->first()?->department;
        }
        else if ($this->departments->count()) {
            return $this->departments->first();
        }
        else if ($this->regions->count()) {
            return $this->regions->first()?->departments->first();
        }

        return null;
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


    public function canEdit()
    {
        if (auth()->check()) {
            return $this->user_pp_id === auth()->id() || (
                    $this->attributionAd?->userModerator &&
                    $this->attributionAd?->userModerator->id === auth()->id()
                ) || auth()->user()->role >= 4;
        }
        return false;
    }

    public function thirdPartyAdUser(): BelongsTo
    {
        return $this->belongsTo(ThirdPartyAdUser::class);
    }
}
