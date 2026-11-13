<?php

namespace App\Models;

use App\Models\Scopes\ScopeAdTypesFilterable;
use App\Models\Scopes\ScopeDataFilterable;
use App\Models\Scopes\ScopeLocationFilterable;
use App\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\Decoratable;

/**
 * App\Models\AttributionAd
 *
 * @property int $id
 * @property int|null $user_advisor_id
 * @property int|null $user_moderator_id
 * @property int|null $user_supervisor_id
 * @property int $ad_id
 * @property int|null $ad_status_id
 * @property int|null $refusal_type_id
 * @property string|null $published_on
 * @property string|null $archived_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $refused_on
 * @property \Illuminate\Support\Carbon|null $pending_update_since
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\AdStatus|null $adStatus
 * @property-read \App\Models\RefusalType|null $refusalType
 * @property-read \App\Models\User|null $userAdvisor
 * @property-read \App\Models\User|null $userModerator
 * @property-read \App\Models\User|null $userSupervisor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterAdTypes($adTypesFilters, $relationTableName = '')
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterRegions($regionCode)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterSupportRequestRegionId($territoriesId, $userRole)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereAdStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd wherePublishedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereRefusalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereRefusedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUserAdvisorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUserModeratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUserSupervisorId($value)
 *
 * @mixin \Eloquent
 *
 * @property int|null $user_advisor_2_id
 * @property int|null $user_advisor_3_id
 * @property int|null $user_advisor_4_id
 * @property-read \App\Models\User $userAdvisor2
 * @property-read \App\Models\User $userAdvisor3
 * @property-read \App\Models\User $userAdvisor4
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUserAdvisor2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUserAdvisor3Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd whereUserAdvisor4Id($value)
 */
class AttributionAd extends Model implements Decoratable
{
    use HasFactory;
    use ScopeAdTypesFilterable,
        ScopeDataFilterable,
        ScopeLocationFilterable;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_status_id',
        'ad_id',
        'lead_type_id',
        'refusal_type_id',
        'user_advisor_id',
        'user_advisor_2_id',
        'user_advisor_3_id',
        'user_advisor_4_id',
        'user_moderator_id',
        'user_supervisor_id',
        'to_call_back',
        'short_description',
        'archived_at',
        'published_on',
        'refused_on',
        'pending_update_since',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'pending_update_since' => 'datetime',
    ];

    /**
     * L'annonce est-elle en ligne (validée et publiée, non archivée) ?
     */
    public function isOnline(): bool
    {
        return $this->ad_status_id === AdStatus::APPROVE_ID
            && ! is_null($this->published_on)
            && is_null($this->archived_at);
    }

    const VALIDATION_MESSAGE = "Bonjour,\nVotre annonce vient d’être publiée. Sans intervention de votre part, elle sera en ligne pour 6 mois. Nous espérons qu’Objectif Terres vous permettra d’être contacté. \nCordialement,\nTerre de Liens";

    public function hasAttributedAdvisors()
    {
        return (bool) count($this->getAdvisors());
    }

    public function getAdvisors()
    {
        return array_values(array_filter($this->getAdvisorsUnfiltered()));
    }

    public function getAdvisorsUnfiltered(): array
    {
        return [$this->userAdvisor, $this->userAdvisor2, $this->userAdvisor3, $this->userAdvisor4];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAdvisor()
    {
        return $this->belongsTo(User::class, 'user_advisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAdvisor2()
    {
        return $this->belongsTo(User::class, 'user_advisor_2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAdvisor3()
    {
        return $this->belongsTo(User::class, 'user_advisor_3_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAdvisor4()
    {
        return $this->belongsTo(User::class, 'user_advisor_4_id');
    }

    public function isCurrentUserAdvisorOfAd()
    {
        return auth()->id() === $this->user_advisor_id || auth()->id() === $this->user_advisor_2_id || auth()->id() === $this->user_advisor_3_id || auth()->id() === $this->user_advisor_4_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userModerator()
    {
        //        dd('ghjhgjghjghj');
        return $this->belongsTo(User::class, 'user_moderator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userSupervisor()
    {
        return $this->belongsTo(User::class, 'user_supervisor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adStatus()
    {
        return $this->belongsTo(AdStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refusalType()
    {
        return $this->belongsTo(ResponseTemplate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
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
