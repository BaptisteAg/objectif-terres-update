<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Documentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AdNote
 *
 * @property int $id
 * @property int $ad_id
 * @property int $user_id
 * @property int|null $project_data_key_id
 * @property int|null $project_data_value_id
 * @property string $value
 * @property string|null $contact_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\ProjectDataKey|null $projectDataKey
 * @property-read \App\Models\ProjectDataValue|null $projectDataValue
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereProjectDataKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereProjectDataValueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdNote whereValue($value)
 *
 * @mixin \Eloquent
 */
class AdNote extends Model
{
    use HasFactory;

    use Documentable;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'value', 'user_id', 'contact_name', 'project_data_key_id', 'project_data_value_id',
    ];

    /**
     * @return BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function projectDataKey()
    {
        return $this->belongsTo(ProjectDataKey::class);
    }

    /**
     * @return BelongsTo
     */
    public function projectDataValue()
    {
        return $this->belongsTo(ProjectDataValue::class);
    }
}
