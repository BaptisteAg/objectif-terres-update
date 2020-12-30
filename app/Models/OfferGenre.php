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
 * @property string $icon
 * @property string $land_offer_label
 * @property int $land_seek_display
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandOfferAd[] $landOfferAds
 * @property-read int|null $land_offer_ads_count
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereLandOfferLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereLandSeekDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfferGenre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OfferGenre extends Model
{
    const ID_VENTE = 1;
    const ID_LOCATION = 2;
    const ID_TEST_AGRICOLE = 3;
    const ID_LED_OU_DONATION = 4;

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
