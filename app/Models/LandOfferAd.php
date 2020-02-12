<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\LandOfferAd
 *
 * @property int $id
 * @property int $ad_id
 * @property int $building_id
 * @property int $house_id
 * @property int $land_id
 * @property boolean $is_beneficiary
 * @property boolean $accept_use_zip_code
 * @property boolean $is_call_for_application_community
 * @property boolean $is_call_for_application_terre_de_liens
 * @property boolean $is_call_for_application_test_area
 * @property boolean $is_activity_transfert
 * @property string $water_access
 * @property int $altitude
 * @property Ad $ad
 * @property Building $building
 * @property House $house
 * @property Land $land
 * @property int|null $is_activity_transfer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAcceptUseZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsActivityTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationCommunity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationTerreDeLiens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereIsCallForApplicationTestArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereLandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereWaterAccess($value)
 * @mixin \Eloquent
 * @property string|null $title
 * @property string|null $land_availability
 * @property string|null $land_transfer_deadline
 * @property int|null $land_price
 * @property int|null $house_price
 * @property int|null $building_price
 * @property int $confirm_price_fermage
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereBuildingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereConfirmPriceFermage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHousePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereLandAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereLandPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereLandTransferDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereTitle($value)
 */
class LandOfferAd extends Model
{
    use BioCertifiable;
    use ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'building_id',
        'house_id',
        'land_id',
        'is_beneficiary',
        'accept_use_zip_code',
        'is_call_for_application_community',
        'is_call_for_application_terre_de_liens',
        'is_call_for_application_test_area',
        'is_activity_transfert',
        'water_access',
        'altitude',
        'zip_code',
        'land_price',
        'house_price',
        'building_price',
        'confirm_price_fermage',
    ];


    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }


    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function land()
    {
        return $this->belongsTo(Land::class);
    }

}
