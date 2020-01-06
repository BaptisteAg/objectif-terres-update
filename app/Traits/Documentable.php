<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait Documentable
{
    /**
     *
     * @return MorphToMany
     */
    public function documents()
    {
        return $this->morphToMany('App\Models\Document', 'documentable');
    }
}
