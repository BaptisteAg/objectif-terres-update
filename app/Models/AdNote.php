<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AdNote
 *
 * @property int $id
 * @property int $ad_id
 * @property string $content
 * @property string $sf_user_id
 * @property string $contact_name
 * @property Ad $ad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereSfUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdNote whereUpdatedAt($value)
 * @mixin \Eloquent
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
