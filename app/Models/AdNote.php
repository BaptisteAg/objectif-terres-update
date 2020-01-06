<?php

namespace App\Models;

use App\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property string $sf_user_id
 * @property string $contact_name
 * @property Ad $ad
 */
class AdNote extends Model
{
    use Documentable;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'content', 'sf_user_id', 'contact_name'
    ];

    /**
     * @return BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo('App\Models\Ad');
    }
}
