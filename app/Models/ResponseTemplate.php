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
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResponseTemplate whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ResponseTemplate extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'content',
    ];
}
