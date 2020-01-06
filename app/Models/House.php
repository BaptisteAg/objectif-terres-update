<?php

namespace App\Models;

use App\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $number
 * @property float $surface
 * @property float $price
 * @property LandOfferAd $landOfferAds
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
