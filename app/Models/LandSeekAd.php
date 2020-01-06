<?php

namespace App\Models;

use App\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $ad_id
 * @property int $installation_type_id
 * @property int $offer_type_id
 * @property string $title
 * @property boolean $is_bio
 * @property string $production_type_add
 * @property boolean $has_farm_buildings
 * @property boolean $has_houses
 * @property string $experience_farming
 * @property float $rent_min
 * @property float $rent_max
 * @property Ad $ad
 * @property InstallationType $installationType
 * @property OfferGenre $offerGenre
 * @property PriceRange[] $priceRanges
 * @property SurfaceRange[] $surfaceRanges
 */
class LandSeekAd extends Model
{
    use ProductionableGenre;

    /**
     * @var array
     */
    protected $fillable = [
        'ad_id', 'installation_type_id', 'offer_type_id', 'title', 'is_bio', 'production_type_add', 'has_farm_buildings', 'has_houses', 'experience_farming', 'rent_min', 'rent_max'
    ];

    /**
     * @return HasOne
     */
    public function ad()
    {
        return $this->HasOne('App\Models\Ad');
    }

    /**
     * @return BelongsTo
     */
    public function installationType()
    {
        return $this->belongsTo('App\Models\InstallationType');
    }

    /**
     * @return BelongsTo
     */
    public function offerGenre()
    {
        return $this->belongsTo('App\Models\OfferGenre', 'offer_type_id');
    }

    /**
     * @return belongsToMany
     */
    public function priceRanges()
    {
        return $this->belongsToMany('App\Models\PriceRange')->withTimestamps();
    }

    /**
     * @return belongsToMany
     */
    public function surfaceRanges()
    {
        return $this->belongsToMany('App\Models\SurfaceRange')->withTimestamps();
    }

}
