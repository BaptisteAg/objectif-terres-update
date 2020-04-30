<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectStatus extends Model
{
	public const CALLING_BACK_ID = 1;
	public const ASSISTING_ID = 2;
	public const UNASSISTED_ID = 3;
	public const HAVING_IDEA_ID = 4;
	public const RESEARCHING_ID = 5;
	public const ESTABLISHING_ID = 6;
	public const ARCHIVE_ID = 7;

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function researches()
    {
        return $this->belongsToMany(Research::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
