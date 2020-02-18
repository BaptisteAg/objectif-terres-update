<?php

namespace App\Models;


use App\Presenters\ThreadPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;


/**
 * App\Models\Thread
 *
 * @property int $id
 * @property string|null $title
 * @property int $is_private
 * @property int|null $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad|null $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $unreadMessages
 * @property-read int|null $unread_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Thread extends Model implements HasPresenter
{
	/**
	 * @var array
	 */
	protected $fillable = [
		'title', 'created_at', 'updated_at','ad_id', 'is_private'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messages()
	{
		return $this->hasMany(Message::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function unreadMessages()
	{
		return $this->hasMany(Message::class)
			->where('is_read', '=', '0')
			->where('sender_user_id', '!=', auth()->id());
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function messageAlreadySended()
	{
		return $this->hasMany(Message::class)
			->where('is_read', '=', '0')
			->where('sender_user_id', '!=', auth()->id());
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function ad()
	{
		return $this->belongsTo(Ad::class, 'ad_id', 'id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'thread_users')->withTimestamps();
	}


	/**
	 * Get the presenter class.
	 *
	 * @return string
	 */
	public function getPresenterClass()
	{
		return ThreadPresenter::class;

	}
}
