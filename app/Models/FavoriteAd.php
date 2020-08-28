<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FavoriteAd
 *
 * @property int $id
 * @property int $user_id
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAd whereUserId($value)
 * @mixin \Eloquent
 */
class FavoriteAd extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'user_id',
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
}
