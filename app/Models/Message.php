<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;

	/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $sender_user_id
 * @property int $receiver_user_id
 * @property string $content
 * @property string $thread_id
 * @property User $senderUser
 * @property User $receiverUser
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUserReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUserSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\Thread $thread
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereReceiverUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSenderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereThreadId($value)
 * @property int $is_read
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereIsRead($value)
 */
class Message extends Model
{
	use Documentable;
	/**
	 * @var array
	 */
	protected $fillable = [
		'sender_user_id', 'receiver_user_id', 'content', 'thread_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function senderUser()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function receiverUser()
	{
		return $this->belongsTo(User::class);
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function thread()
	{
		return $this->belongsTo(Thread::class);
	}
}

