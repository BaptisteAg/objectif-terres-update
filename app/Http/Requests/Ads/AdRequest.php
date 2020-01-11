<?php

namespace App\Http\Requests\Ads;

use App\Http\Requests\Ads\Rulesets\LandSeekRuleset;
use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
{
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
        $rules = [
            'ad_type' => "required"
        ];

        $rulesetsByAdType = [
            'land_seek' => LandSeekRuleset::class,
        ];

        foreach($rulesetsByAdType as $adType => $ruleset) {
            if($this->get('ad_type') === $adType) {
                $rules = array_merge($rules, app($ruleset));
                break;
            }
        }

        return $rules;
    }
}
