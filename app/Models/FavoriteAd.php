<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ad_id
 * @property string $sf_id
 * @property Ad $ad
 */
class FavoriteAd extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'sf_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ads()
    {
        return $this->belongsTo('App\Models\Ad');
    }
}
