<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * App\Models\ThreadUser
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser whereUserId($value)
 * @mixin \Eloquent
 */
class ThreadUser extends Pivot
{
    protected $table = 'thread_users';

    protected $fillable = ['user_id', 'thread_id'];
}
