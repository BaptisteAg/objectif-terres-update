<?php

namespace App\Models;


use App\Presenters\ThreadPresenter;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder|Thread newModelQuery()
 * @method static Builder|Thread newQuery()
 * @method static Builder|Thread query()
 * @method static Builder|Thread whereAdId($value)
 * @method static Builder|Thread whereCreatedAt($value)
 * @method static Builder|Thread whereId($value)
 * @method static Builder|Thread whereIsPrivate($value)
 * @method static Builder|Thread whereTitle($value)
 * @method static Builder|Thread whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Thread extends Model implements HasPresenter
{
	/**
	 * @var array
	 */
	protected $fillable = [
		'title', 'created_at', 'updated_at', 'ad_id', 'is_private', 'listUsers'
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
			->whereHas('unreadMessages', function (Builder $query) {
				$query->where([
					['is_read', '=', '0'],
					['user_id', '=', auth()->id()]
				]);
			}
			);
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
     * Returns threads that the user is associated with.
     */
    public function scopeForUser(Builder $query, $userId): mixed
    {
        $participantsTable = 'thread_users';

        //if User Is Admin
        if(auth()->user()->role === 4){
            return null;
        }
        //else returns threads from thread_users
        return $query
            ->select('threads.*')
            ->join($participantsTable, $this->getQualifiedKeyName(), '=', $participantsTable . '.thread_id')
            ->where($participantsTable . '.user_id', $userId);
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
