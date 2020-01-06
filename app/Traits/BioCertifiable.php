<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;


Trait BioCertifiable
{

    /**
     * @return MorphToMany
     */
    public function bioCertifications()
    {
        return $this->morphToMany('App\Models\BioCertification', 'bio_certifiable');
    }
}
