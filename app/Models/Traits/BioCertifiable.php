<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait BioCertifiable
{
    /**
     * @return MorphToMany
     */
    public function bioCertifications()
    {
        return $this->morphToMany(\App\Models\BioCertification::class, 'bio_certifiable');
    }
}
