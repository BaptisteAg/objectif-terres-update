<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ResponseTemplate
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ResponseTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ResponseTemplate extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'content'
    ];

}
