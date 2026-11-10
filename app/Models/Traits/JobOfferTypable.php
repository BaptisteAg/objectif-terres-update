<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait JobOfferTypable
{
    /**
     * @return MorphToMany
     */
    public function jobOfferTypes()
    {
        return $this->morphToMany('App\Models\JobOfferType', 'job_offer_typable', 'job_offer_typable');
    }
}
