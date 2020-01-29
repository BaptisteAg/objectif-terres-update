<?php

namespace App\Http\Requests\Ads;

use App\Http\Requests\Ads\Rulesets\LandSeekRuleset;
use App\Http\Requests\Rulesets\RulesetInterface;
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
            'ad_type' => "required",
            'landSeek' => "array",
        ];

        $rulesetsByAdType = [
            'landSeek' => LandSeekRuleset::class,
        ];

        foreach($rulesetsByAdType as $adType => $rulesetClass) {
            if($this->get('ad_type') === $adType) {
                /** @var RulesetInterface $ruleset */
                $ruleset = app($rulesetClass);
                $rules = array_merge($rules, $ruleset->get());
                break;
            }
        }

        return $rules;
    }
}
