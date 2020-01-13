<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PpToUserMessage
 *
 * @property int $id
 * @property int $ad_id
 * @property string $sf_sender_id
 * @property string $sf_receiver_id
 * @property string $content
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereSfReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereSfSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PpToUserMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PpToUserMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'sf_sender_id', 'sf_receiver_id', 'content'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad');
    }
}
