<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdMessage
 *
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property string $sf_sender_id
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereSfSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'content', 'sf_sender_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad');
    }
}
