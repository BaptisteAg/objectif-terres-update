<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $path
 * @property string $type_document
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property User $user
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $ads
 * @property-read int|null $ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereTypeDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUserId($value)
 * @property string $type
 * @property int $size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereType($value)
 */
class Document extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'type', 'size', 'user_id'
    ];

    /**
     * Get all of the ads who have documents.
     *
     * @return MorphToMany
     */
    public function ads()
    {
        return $this->morphedByMany(Research::class, 'documentable');
    }

    /**
     * Get all of the ad_notes who have documents.
     *
     * @return MorphToMany
     */
    public function adNotes()
    {
        return $this->morphedByMany(AdNote::class, 'documentable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
