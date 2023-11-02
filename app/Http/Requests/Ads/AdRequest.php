<?php

namespace App\Http\Requests\Ads;

use App\Http\Requests\Ads\Rulesets\JobOfferRuleset;
use App\Http\Requests\Ads\Rulesets\JobSeekRuleset;
use App\Http\Requests\Ads\Rulesets\LandOfferRuleset;
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
            'ad_type' => "required",

            'is_other_person' => 'required|boolean',
            'other_person[email]'=> 'required_if:is_other_person,1|email',
            'other_person[first_name]'=> 'required_if:is_other_person,1|string',
            'other_person[last_name]'=> 'required_if:is_other_person,1|string',
            'other_person[phone]'=> 'nullable|string',

            'id' => ["nullable", "numeric"],
            'department_id' => ["required", "numeric"],

            'land_seek' => ['nullable', 'array'],
            'land_offer' => ['nullable', 'array'],
            'job_offer' => ['nullable', 'array'],
            'job_seek' => ['nullable', 'array'],

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
        ];

        /** @var RulesetInterface $ruleset */
        $ruleset = app($rulesetsByAdType[$this->get('ad_type')]);
        $rules = array_merge($rules, $ruleset->get($this->boolean("is_support_request")));

        return $rules;
    }
}
