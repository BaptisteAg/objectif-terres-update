<?php

namespace App\Models;

use App\Models\Traits\BioCertifiable;
use App\Models\Traits\OfferableGenre;
use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


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
