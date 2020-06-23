<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ReadMessage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage query()
 * @mixin \Eloquent
 */

class ReadMessage extends Pivot
{
	protected $table = 'read_messages';

	protected $fillable = ['user_id', 'message_id', 'is_read'];

}
