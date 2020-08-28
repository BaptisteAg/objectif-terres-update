<?php

namespace App\Models;

use App\Models\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\House
 *
 * @property int $id
 * @property string|null $description
 * @property float|null $surface
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandOfferAd|null $landOfferAd
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House query()
 * @method static \Illuminate\Database\Eloquent\Builder|House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class House extends Model
{
    use OfferableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'description', 'surface'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function landOfferAd()
    {
        return $this->hasOne(LandOfferAd::class);
    }

}
