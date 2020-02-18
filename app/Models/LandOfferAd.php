<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\OfferableGenre;
use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\LandOfferAd
 *
 * @property int $id
 * @property int $accept_use_zip_code
 * @property int $surface
 * @property string|null $sau_description
 * @property int|null $water_access
 * @property string|null $water_access_description
 * @property int $altitude
 * @property int|null $has_buildings
 * @property string|null $buildings_description
 * @property int|null $has_houses
 * @property string|null $houses_description
 * @property int|null $price
 * @property int|null $rent_price
 * @property string|null $test_description
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BioCertification[] $bioCertifications
 * @property-read int|null $bio_certifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OfferGenre[] $offerGenres
 * @property-read int|null $offer_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenres
 * @property-read int|null $production_genres_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductionGenre[] $productionGenresPossible
 * @property-read int|null $production_genres_possible_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAcceptUseZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereBuildingsDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHasBuildings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHasHouses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereHousesDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereRentPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereSauDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereTestDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereWaterAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LandOfferAd whereWaterAccessDescription($value)
 * @mixin \Eloquent
 */
class LandOfferAd extends Model
{
    use BioCertifiable;
    use ProductionableGenre;
    use OfferableGenre;

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }


    /**
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'surface',
        'sau_description',
        'accept_use_zip_code',
        'water_access',
        'water_access_description',
        'altitude',
        'has_buildings',
        'has_houses',
        'buildings_description',
        'houses_description',
        'price',
        'rent_price',
        'test_description',

        //'confirm_price_fermage',
        //'is_call_for_application_community',
        //'is_call_for_application_terre_de_liens',
        //'is_call_for_application_test_area',
        //'land_price',
        //'house_price',
        //'building_price',
        //'is_beneficiary',
        //'building_id',
        //'house_id',
        //'land_id',
    ];
}
