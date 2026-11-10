<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectDataKey
 *
 * @property int $id
 * @property string $name
 * @property int $is_public
 * @property int $immutable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProjectDataValue[] $projectDataValues
 * @property-read int|null $project_data_values_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey whereImmutable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataKey whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProjectDataKey extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'is_public', 'immutable',
    ];

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
    public function projectDataValues()
    {
        return $this->hasMany(ProjectDataValue::class);
    }
}
