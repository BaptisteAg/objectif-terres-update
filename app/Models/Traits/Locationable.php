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
        return $this->morphToMany(\App\Models\Ad::class, 'locationable_ad');
    }

    /**
     * @return MorphToMany
     */
    public function researches()
    {
        return $this->morphToMany(\App\Models\Research::class, 'locationable_research');
    }

    /**
     * @return MorphToMany
     */
    public function users()
    {
        return $this->morphToMany(\App\Models\User::class, 'locationable_user');
    }
}
