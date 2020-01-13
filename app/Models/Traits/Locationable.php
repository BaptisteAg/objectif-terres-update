<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Locationable
{

    /**
     * @return MorphToMany
     */
    public function ads()
    {
        return $this->morphToMany('App\Models\Ad', 'locationable_ad');
    }

    /**
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphToMany('App\Models\Research', 'locationable_research');
    }
}
