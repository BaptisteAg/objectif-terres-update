<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FavoriteAd
 *
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd query()
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
