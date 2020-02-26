<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ReadMessage
 *
 * @property int $id
 * @property int $message_id
 * @property bool $is_read
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReadMessage whereIsRead($value)
 * @mixin \Eloquent
 */

class ReadMessage extends Pivot
{
	protected $table = 'read_messages';

	protected $fillable = ['user_id', 'message_id', 'is_read'];

}
