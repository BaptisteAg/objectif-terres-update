<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\BioCertification
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Research[] $researches
 * @property-read int|null $researches_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BioCertification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BioCertification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the land_offer_ads who have bio_certification.
     *
     * @return MorphToMany
     */
    public function landOfferAds()
    {
        return $this->morphedByMany('App\Models\LandOfferAd', 'bio_certifiable');
    }

    /**
     * Get all of the researches who have bio_certification.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany('App\Models\Research', 'bio_certifiable');
    }
}
