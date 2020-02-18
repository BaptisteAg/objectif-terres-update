<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait EducationLevelable
{
    /**
     *
     * @return MorphToMany
     */
    public function educationLevels()
    {
        return $this->morphToMany('App\Models\EducationLevel', 'education_levelable', 'education_levelable');
    }
}
