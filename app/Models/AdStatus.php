<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributionAd[] $attributionAds
 * @property-read int|null $attribution_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdStatus whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class AdStatus extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public const APPROVE_ID = 1;

    public const PENDING_ID = 2;

    public const REFUSE_ID = 3;

    public const PENDING_MODERATION_STATUS_ID = 4;

    public const ARCHIVED_ID = 5;

    public const TOOLTIPS = [
        '' => 'Brouillon',
        self::APPROVE_ID => 'Validée : annonce modérée publiée',
        self::PENDING_ID => "En attente :annonce modérée en attente d’une réponse ou de modification par l'annonceur",
        self::REFUSE_ID => 'Refusée : annonce modérée non publiée',
        self::PENDING_MODERATION_STATUS_ID => 'À modérer : annonce à traiter par un modérateur',
        self::ARCHIVED_ID => 'Archivée : annonce validée de plus de 6 mois automatiquement dépubliée',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function researches()
    {
        return $this->belongsToMany(Research::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributionAds()
    {
        return $this->hasMany(AttributionAd::class);
    }
}
