<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserToUserMessage
 *
 * @property int $id
 * @property string $sf_user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereSfUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserToUserMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserToUserMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'sf_user_id', 'content'
    ];

}
