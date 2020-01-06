<?php

namespace App\Models;

use App\Traits\BioCertifiable;
use App\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
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
 */
class LandOfferAd extends Model
{

    use BioCertifiable;
    use ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'building_id', 'house_id', 'land_id', 'is_beneficiary', 'accept_use_zip_code', 'is_call_for_application_community', 'is_call_for_application_terre_de_liens', 'is_call_for_application_test_area', 'is_activity_transfert', 'water_access', 'altitude'
    ];

    /**
     * @return HasOne
     */
    public function ad()
    {
        return $this->HasOne('App\Models\Ad');
    }

    /**
     * @return HasOne
     */
    public function building()
    {
        return $this->HasOne('App\Models\Building');
    }

    /**
     * @return HasOne
     */
    public function house()
    {
        return $this->HasOne('App\Models\House');
    }

    /**
     * @return HasOne
     */
    public function land()
    {
        return $this->HasOne('App\Models\Land');
    }

}
