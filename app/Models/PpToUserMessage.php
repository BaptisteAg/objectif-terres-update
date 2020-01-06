<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ad_id
 * @property string $sf_sender_id
 * @property string $sf_receiver_id
 * @property string $content
 * @property Ad $ad
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
