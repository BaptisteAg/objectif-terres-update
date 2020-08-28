<?php

namespace App\Models;

use App\Models\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

/**
 * App\Models\Building
 *
 * @property int $id
 * @property string|null $description
 * @property float|null $surface
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandOfferAd|null $landOfferAd
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|Building newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Building query()
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Building whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Building extends Model
{
    use OfferableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'description', 'surface'
    ];

    /**
     * @return hasOne
     */
    public function landOfferAd()
    {
        return $this->hasOne(LandOfferAd::class);
    }


}
