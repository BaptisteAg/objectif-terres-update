<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $type
 * @property string $url
 * @property int $size
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdNote[] $adNotes
 * @property-read int|null $ad_notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $ads
 * @property-read int|null $ads_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUserId($value)
 * @mixin \Eloquent
 */
class Document extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'type', 'size', 'user_id'
    ];

    protected $appends = ['url'];

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

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return app('url')->assetFrom('https://objectif-terres.org', $this->path);
    }
}
