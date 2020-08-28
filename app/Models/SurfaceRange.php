<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SurfaceRange
 *
 * @property int $id
 * @property string $label
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SurfaceRange whereValue($value)
 * @mixin \Eloquent
 */
class SurfaceRange extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'value', 'label'
    ];

}
