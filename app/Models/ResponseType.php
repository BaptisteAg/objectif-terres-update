<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResponseType
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ResponseType extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'content'
    ];

}
