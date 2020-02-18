<?php

namespace App\Http\Requests\Ads;

use App\Http\Requests\Ads\Rulesets\JobOfferRuleset;
use App\Http\Requests\Ads\Rulesets\JobSeekRuleset;
use App\Http\Requests\Ads\Rulesets\LandOfferRuleset;
use App\Http\Requests\Ads\Rulesets\LandSeekRuleset;
use App\Http\Requests\Rulesets\RulesetInterface;
use App\Rules\HasZone;
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
            'ad_type'                 => "required",
            'land_seek'               => ['nullable', 'array'],
            'land_offer'              => ['nullable', 'array'],
<<<<<<< HEAD
            'job_offer'               => ['nullable', 'array'],
            'job_seek'                => ['nullable', 'array'],
=======
>>>>>>> 1a90b43a85118e725f01b9fc78f76c14ea08bc83
            'locationable'            => [new HasZone],
            'locationable_radius'     => ['nullable', 'string'],
            'about_content'           => ['required', 'string', 'max:1000'],
            'about_project_content'   => ['required', 'string', 'max:1000'],
            'title'                   => ['required', 'string'],
            'documents_ids'           => ['nullable', 'array'],
        ];

        $rulesetsByAdType = [
            'land_seek' => LandSeekRuleset::class,
            'land_offer' => LandOfferRuleset::class,
            'job_offer' => JobOfferRuleset::class,
            'job_seek' => JobSeekRuleset::class,
        ];

        /** @var RulesetInterface $ruleset */
        $ruleset = app($rulesetsByAdType[$this->get('ad_type')]);
        $rules = array_merge($rules, $ruleset->get());

        return $rules;
    }
}
