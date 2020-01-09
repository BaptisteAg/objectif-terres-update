<?php

namespace App\Http\Requests\Ads;

trait LandSeekAdRequestTrait
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function getLandSeekRules()
    {
        return [
            'installation_type' => 'required',
            'city' => 'required_without_all: regions, departments',
            'regions' => 'required_without_all: city, departments',
            'departments' => 'required_without_all: city, regions',
        ];
    }
}
