<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectDataValue
 *
 * @property int $id
 * @property int $project_data_key_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProjectDataKey $projectDataKey
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue whereProjectDataKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectDataValue whereValue($value)
 *
 * @mixin \Eloquent
 */
class ProjectDataValue extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'value',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectDataKey()
    {
        return $this->belongsTo(ProjectDataKey::class);
    }
}
