<?php

namespace App\Models;

use App\Models\Traits\OfferableGenre;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Land
 *
 * @property int $id
 * @property string $area
 * @property int|null $price
 * @property string|null $land_availability
 * @property string|null $land_transfer_deadline
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandOfferAd $landOfferAds
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereLandAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereLandTransferDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Land whereUpdatedAt($value)
 * @mixin \Eloquent
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
        return $this->hasOne(LandOfferAd::class);
    }

}
