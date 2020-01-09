<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class LandSeekAdRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function landSeekRules()
    {
        return [
            'installation_type' => 'required',
            'city' => 'required_without_all: regions, departments',
            'regions' => 'required_without_all: city, departments',
            'departments' => 'required_without_all: city, regions',
        ];
    }
}
