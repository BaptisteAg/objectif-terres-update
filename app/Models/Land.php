<?php

namespace App\Models;

use App\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property float $area
 * @property float $price
 * @property string $land_availability
 * @property string $land_transfer_deadline
 * @property LandOfferAd $landOfferAds
 */
class Land extends Model
{
    use OfferableGenre;
    /**
     * @var array
     */
    protected $fillable = [
        'area', 'price', 'land_availability', 'land_transfer_deadline'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function landOfferAds()
    {
        return $this->hasOne('App\Models\LandOfferAd');
    }

}
