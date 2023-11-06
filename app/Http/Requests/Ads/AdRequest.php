<?php

namespace App\Http\Requests\Ads;

use App\Http\Requests\Ads\Rulesets\AssociateSeekRuleset;
use App\Http\Requests\Ads\Rulesets\JobOfferRuleset;
use App\Http\Requests\Ads\Rulesets\JobSeekRuleset;
use App\Http\Requests\Ads\Rulesets\LandOfferRuleset;
use App\Http\Requests\Ads\Rulesets\LandSeekRuleset;
use App\Models\AssociateOfferAd;
use App\Models\AssociateSeekAd;
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
            'ad_type' => "required",

            'ad_contact_type' => 'required|string',
            'third_party.email'=> 'required_if:ad_contact_type,thirdParty|email',
            'third_party.first_name'=> 'required_if:ad_contact_type,thirdParty|string',
            'third_party.last_name'=> 'required_if:ad_contact_type,thirdParty|string',
            'third_party.phone'=> 'nullable|string',

            'id' => ["nullable", "numeric"],
            'department_id' => ["nullable", "numeric"],

            'land_seek' => ['nullable', 'array'],
            'land_offer' => ['nullable', 'array'],
            'job_offer' => ['nullable', 'array'],
            'job_seek' => ['nullable', 'array'],
            'associate_seek' => ['nullable', 'array'],
            'associate_offer' => ['nullable', 'array'],

            'locationable' => [new HasZone, 'nullable'],
            'locationable_radius' => ['nullable', 'string'],

            'about_content' => ['nullable', 'string', 'max:1000'],
            'about_project_content' => ['required', 'string', 'max:1500'],
            'title' => ['required', 'string'],

            'accept_share_contact_infos' => ['nullable'],

            'documents_ids' => ['nullable', 'array'],

            // TODO: remove
            //'is_support_request' => ['nullable', 'boolean'],
            //'support_request_text' => ['nullable', 'string', 'max:1500'],
            //'support_request_territory_id' => ['nullable', 'numeric'],
        ];

        $rulesetsByAdType = [
            'land_seek' => LandSeekRuleset::class,
            'land_offer' => LandOfferRuleset::class,
            'job_offer' => JobOfferRuleset::class,
            'job_seek' => JobSeekRuleset::class,
            'associate_seek' => AssociateSeekRuleset::class,
            'associate_offer' => AssociateOfferRuleset::class,
        ];

        /** @var RulesetInterface $ruleset */
        $ruleset = app($rulesetsByAdType[$this->get('ad_type')]);
        $rules = array_merge($rules, $ruleset->get($this->boolean("is_support_request")));

        return $rules;
    }
}
