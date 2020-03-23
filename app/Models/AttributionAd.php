<?php

namespace App\Models;

use App\Models\Scopes\ScopeAdTypesFilterable;
use App\Models\Scopes\ScopeDataFilterable;
use App\Models\Scopes\ScopeLocationFilterable;
use App\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\Decoratable;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * App\Models\AttributionAd
 *
 * @property int $id
 * @property int|null $user_owner_id
 * @property int $user_moderator_id
 * @property int|null $to_call_back
 * @property string|null $short_description
 * @property int $ad_status_id
 * @property int|null $pp_type_id
 * @property int|null $refusal_type_id
 * @property string|null $published_on
 * @property string|null $archived_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\AdStatus $adStatus
 * @property-read \App\Models\PpType $ppType
 * @property-read \App\Models\RefusalType|null $refusalType
 * @property-read \App\Models\User $userModerator
 * @property-read \App\Models\User|null $userOwner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterAdTypes($adTypesFilters, $relationTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereAdStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd wherePpTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd wherePublishedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereRefusalTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereToCallBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserModeratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributionAd whereUserOwnerId($value)
 * @mixin \Eloquent
 */
class AttributionAd extends Model implements Decoratable
{
	use ScopeLocationFilterable, ScopeAdTypesFilterable, ScopeDataFilterable;
	/**
	 * @var array
	 */
	protected $fillable = [
		'ad_status_id', 'lead_type_id', 'refusal_type_id', 'user_owner_id', 'user_moderator_id', 'to_call_back', 'short_description', 'archived_at', 'published_on'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userOwner()
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
	public function adStatus()
	{
		return $this->belongsTo(AdStatus::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function ppType()
	{
		return $this->belongsTo(PpType::class, 'lead_type_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function refusalType()
	{
		return $this->belongsTo(RefusalType::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function ad()
	{
		return $this->hasOne(Ad::class);
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
