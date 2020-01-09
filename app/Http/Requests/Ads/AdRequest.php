<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
{
    use LandSeekAdRequestTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        dd($this->all());

        $rules = [
            'ad_type' => "required"
        ];

        if($this->get('ad_type') === "land_seek") {
            $rules = array_merge($rules, $this->getLandSeekRules());
        }

        return $rules;
    }
}
