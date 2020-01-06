<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_status_id
 * @property ProjectStatus $projectStatus
 * @property Ad[] $ads
 */
class Project extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'project_status_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectStatus()
    {
        return $this->belongsTo('App\Models\ProjectStatus');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ads()
    {
        return $this->hasMany('App\Models\Ad');
    }
}
