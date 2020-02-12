<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Thread
 *
 * @property int $id
 * @property string $title
 * @property Message[] $messages
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereTitle($value)
 * @property int $is_private
 * @property int|null $ad_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Thread whereIsPrivate($value)
 * @property-read \App\Models\Ad $ads
 */
class Thread extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = [
		'title', 'created_at', 'updated_at','ad_id', 'is_private'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function messages()
	{
		return $this->belongsTo(Message::class);
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function ads()
	{
		return $this->belongsTo(Ad::class, 'ad_id', 'id');
	}
}
