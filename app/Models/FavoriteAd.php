<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FavoriteAd
 *
 * @property int $id
 * @property int $ad_id
 * @property string $sf_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteAd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FavoriteAd extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'sf_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
