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
	 * @property int $ad_id
	 * @property string $content
	 * @property Ad $ad
	 * @property User $senderUser
	 * @property USer $receiverUser
	 * @property \Illuminate\Support\Carbon|null $created_at
	 * @property \Illuminate\Support\Carbon|null $updated_at
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newModelQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newQuery()
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage query()
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereAdId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereContent($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUserReceiverId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUserSenderId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUpdatedAt($value)
	 * @mixin \Eloquent
	 */
class Message extends Model
{
	use Documentable;
	/**
	 * @var array
	 */
	protected $fillable = [
		'ad_id', 'sender_user_id', 'receiver_user_id', 'content'
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
	public function ad()
	{
		return $this->belongsTo(Ad::class);
	}
}

