<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\OfferGenre
 *
 * @property int $id
 * @property string $name
 * @property string $land_offer_label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereLandOfferLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $land_offer_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OfferGenre whereLandOfferLabel($value)
 */
class OfferGenre extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function landOfferAds()
    {
        return $this->hasMany(LandOfferAd::class);
    }
}
