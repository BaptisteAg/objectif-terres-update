<?php

namespace App\Models;

use App\Models\Scopes\ScopeAdTypesFilterable;
use App\Models\Scopes\ScopeDataFilterable;
use App\Models\Scopes\ScopeLocationFilterable;
use App\Presenters\AdPresenter;
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
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\AdStatus|null $adStatus
 * @property-read \App\Models\RefusalType|null $refusalType
 * @property-read \App\Models\User|null $userAdvisor
 * @property-read \App\Models\User|null $userModerator
 * @property-read \App\Models\User|null $userSupervisor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterAdTypes($adTypesFilters, $relationTableName = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd wherePublishedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserAdvisorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserModeratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserSupervisorId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|AttributionAd filterSupportRequestRegionId($territoriesRegionsId, $userRole)
 */
class AttributionAd extends Model implements Decoratable
{
	use ScopeLocationFilterable,
		ScopeAdTypesFilterable,
		ScopeDataFilterable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'ad_status_id',
		'ad_id',
		'lead_type_id',
		'refusal_type_id',
		'user_advisor_id',
		'user_moderator_id',
		'user_supervisor_id',
		'to_call_back',
		'short_description',
		'archived_at',
		'published_on',
		'refused_on'
	];

	const VALIDATION_MESSAGE = "Bonjour,\nVotre annonce vient d’être publiée. Sans intervention de votre part, elle sera en ligne pour 6 mois.Nous espérons qu’Objectif Terres vous permettra d’être contacté. \nCordialement,\nTerre de Liens";

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userAdvisor()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userModerator()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userSupervisor()
	{
		return $this->belongsTo(User::class);
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
		return $this->belongsTo(RefusalType::class);
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
