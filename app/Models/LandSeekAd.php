<?php

namespace App\Models;

use App\Models\Traits\ProductionableGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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
        return $this->HasOne(Ad::class);
    }

    /**
     * @return BelongsTo
     */
    public function installationType()
    {
        return $this->belongsTo(InstallationType::class);
    }

    /**
     * @return BelongsTo
     */
    public function offerGenre()
    {
        return $this->belongsTo(OfferGenre::class, 'offer_genre_id');
    }

    /**
     * @return belongsToMany
     */
    public function priceRanges()
    {
        return $this->belongsToMany(PriceRange::class)->withTimestamps();
    }

    /**
     * @return belongsToMany
     */
    public function surfaceRanges()
    {
        return $this->belongsToMany(SurfaceRange::class)->withTimestamps();
    }
}
