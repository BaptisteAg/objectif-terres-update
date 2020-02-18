<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PpToUserMessage
 *
 * @property int $id
 * @property string $content
 * @property int $user_sender_id
 * @property int $user_receiver_id
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $userReceiver
 * @property-read \App\Models\User $userSender
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUserReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUserSenderId($value)
 * @mixin \Eloquent
 */
class PpToUserMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'user_sender_id', 'user_receiver_id', 'content'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userSender()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userReceiver()
	{
		return $this->belongsTo(User::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
