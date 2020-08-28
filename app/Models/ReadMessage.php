<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\ReadMessage
 *
 * @property int $id
 * @property int $message_id
 * @property int $user_id
 * @property int $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReadMessage whereUserId($value)
 * @mixin \Eloquent
 */

class ReadMessage extends Pivot
{
	protected $table = 'read_messages';

	protected $fillable = ['user_id', 'message_id', 'is_read'];

}
