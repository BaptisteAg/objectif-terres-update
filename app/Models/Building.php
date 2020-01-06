<?php

namespace App\Models;

use App\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

/**
 * @property int $id
 * @property int $number
 * @property float $surface
 * @property float $price
 * @property LandOfferAd $landOfferAds
 */
class Building extends Model
{
    use OfferableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'number', 'surface', 'price'
    ];

    /**
     * @return hasOne
     */
    public function landOfferAds()
    {
        return $this->hasOne('App\Models\LandOfferAd');
    }


}
