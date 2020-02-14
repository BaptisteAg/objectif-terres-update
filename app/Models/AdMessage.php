<?php

namespace App\Models;

use App\Presenters\MessagePresenter;
use App\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\Decoratable;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * App\Models\AdMessages
 *
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property int $user_id
 * @property Ad $ad
 * @property User $user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereUserSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereUserId($value)
 */
class AdMessage extends Model implements HasPresenter
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'content', 'user_id', 'created_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
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
