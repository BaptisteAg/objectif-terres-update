<?php

namespace App\Models;

use App\Models\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\House
 *
 * @property int $id
 * @property int $number
 * @property float $surface
 * @property float $price
 * @property LandOfferAd $landOfferAds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\House whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class House extends Model
{
    use OfferableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'number', 'surface', 'price'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landOfferAds()
    {
        return $this->hasOne('App\Models\LandOfferAd');
    }

}
