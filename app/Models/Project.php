<?php

namespace App\Models;

use App\Models\Scopes\ScopeAdTypesFilterable;
use App\Models\Scopes\ScopeDataFilterable;
use App\Models\Scopes\ScopeLocationFilterable;
use App\Models\Traits\Documentable;
use App\Presenters\AdPresenter;
use App\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\Decoratable;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property int|null $support_stage_id
 * @property int|null $support_state_id
 * @property int|null $project_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\ProjectStatus|null $projectStatus
 * @property-read \App\Models\SupportStage|null $supportStage
 * @property-read \App\Models\SupportState|null $supportState
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterAdTypes($adTypesFilters, $relationTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterAdsTerritoryLocations($territoriesCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterLocations($relationshipName, $locationableIds)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterSubLocations($relationshipName, $locationableCodes, $locationTargetTableName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterWhereHasIn($data, $relationNameTable, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterWhereHasLandSeekAdOrWhereHasLandOfferAd($landSeekAdColumn, $landOfferAdColumn, $operator, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project filterWhereHasWhere($data, $relationNameTable, $operator, $columnName)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereProjectStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereSupportStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereSupportStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project extends Model implements Decoratable
{
	use ScopeLocationFilterable, ScopeAdTypesFilterable, ScopeDataFilterable, Documentable;
    /**
     * @var array
     */
    protected $fillable = [
        'support_stage_id','support_state_id','project_status_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supportStage()
    {
        return $this->belongsTo(SupportStage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supportState()
    {
        return $this->belongsTo(SupportState::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class);
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
	 * @return array
	 */
	public function getPresenterClass()
	{
		return[ AdPresenter::class, UserPresenter::class];
	}
}
