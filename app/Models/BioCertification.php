<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 */
class BioCertification extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the land_offer_ads who have bio_certification.
     *
     * @return MorphToMany
     */
    public function landOfferAds()
    {
        return $this->morphedByMany('App\Models\LandOfferAd', 'bio_certifiable');
    }

    /**
     * Get all of the researches who have bio_certification.
     *
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphedByMany('App\Models\Research', 'bio_certifiable');
    }
}
