<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectDataValue
 *
 * @property int $id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectDataValue extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectDataKey()
    {
        return $this->belongsTo(ProjectDataKey::class);
    }
}
