<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\BioCertification
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification query()
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BioCertification whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class BioCertification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
    ];

    /**
     * Get all of the land_offer_ads who have bio_certification.
     *
     * @return MorphToMany
     */
    public function landOfferAds()
    {
        return $this->morphedByMany(LandOfferAd::class, 'bio_certifiable');
    }

    /**
     * Get all of the researches who have bio_certification.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany(Research::class, 'bio_certifiable');
    }
}
