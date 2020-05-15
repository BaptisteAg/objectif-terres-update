<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProjectDataKey
 *
 * @property int $id
 * @property string $name
 * @property boolean $is_public
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $adNotes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProjectDataKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectDataKey extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'is_public'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adNotes()
    {
        return $this->hasMany(AdNote::class);
    }
}
