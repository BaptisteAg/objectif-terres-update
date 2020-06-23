<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * App\Models\ThreadUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThreadUser query()
 * @mixin \Eloquent
 */
class ThreadUser extends Pivot
{
    protected $table = 'thread_users';

    protected $fillable = ['user_id', 'thread_id'];
}
