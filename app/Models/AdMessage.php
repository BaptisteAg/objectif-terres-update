<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property string $sf_sender_id
 * @property Ad $ad
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
