<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use App\Presenters\MessagePresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string|null $content
 * @property int $thread_id
 * @property int $sender_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\User $senderUser
 * @property-read \App\Models\Thread $thread
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReadMessage[] $unreadMessages
 * @property-read int|null $unread_messages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSenderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model implements HasPresenter
{
	use Documentable;
	/**
	 * @var array
	 */
	protected $fillable = [
		'sender_user_id', 'content', 'thread_id', 'created_at', 'updated_at'
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
	public function thread()
	{
		return $this->belongsTo(Thread::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function unreadMessages()
	{
		return $this->hasMany(ReadMessage::class);
	}


	/**
	 * Get the presenter class.
	 *
	 * @return string
	 */
	public function getPresenterClass()
	{
		return MessagePresenter::class;
	}
}

