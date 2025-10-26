<?php

namespace App\Http\Requests\Api;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdIndexRequest extends FormRequest
{
    /**
     * Map snake_case type names to camelCase type names
     */
    const TYPE_MAP = [
        'land_offer' => 'landOfferAd',
        'land_seek' => 'landSeekAd',
        'job_offer' => 'jobOfferAd',
        'job_seek' => 'jobSeekAd',
        'associate_offer' => 'associateOfferAd',
        'associate_seek' => 'associateSeekAd',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Get API key from header
        $apiKey = $this->header('Ot-api-key');

        // Get configured API keys and filter out any null/empty values
        $validKeys = array_filter(config('app.api_keys', []));

        // Check if provided key is valid
        return !empty($apiKey) && in_array($apiKey, $validKeys, true);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Handle comma-separated types parameter
        if ($this->has('types') && is_string($this->types)) {
            $this->merge([
                'types' => array_filter(explode(',', $this->types))
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Accept both snake_case and camelCase formats
        $validTypes = array_merge(
            array_keys(Ad::AD_TYPES),
            array_keys(self::TYPE_MAP)
        );

        return [
            // Types parameter - accepts array or comma-separated string
            'types' => 'nullable|array',
            'types.*' => 'string|in:' . implode(',', $validTypes),

            // Date filter - ISO 8601 format (UTC timezone)
            'updated_since' => 'nullable|date_format:Y-m-d\TH:i:s\Z',

            // Pagination
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',

            // Legacy parameters (to be removed)
            'limit' => 'nullable|integer|min:1|max:100',
            'type' => 'nullable|string|in:' . implode(',', $validTypes),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'types.array' => 'The types parameter must be an array or comma-separated string.',
            'types.*.in' => 'Invalid ad type provided. Valid types are: ' . implode(', ', array_keys(self::TYPE_MAP)),
            'updated_since.date_format' => 'The updated_since parameter must be in ISO 8601 UTC format (YYYY-MM-DDTHH:MM:SSZ). Clients must convert their local times to UTC.',
            'page.integer' => 'The page parameter must be a valid integer.',
            'page.min' => 'The page parameter must be at least 1.',
            'per_page.integer' => 'The per_page parameter must be a valid integer.',
            'per_page.min' => 'The per_page parameter must be at least 1.',
            'per_page.max' => 'The per_page parameter cannot exceed 100.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $firstError = $errors->first();
        $firstErrorKey = $errors->keys()[0] ?? 'unknown';

        throw new HttpResponseException(response()->json([
            'error' => 'bad_request',
            'message' => $firstError,
            'details' => [
                'parameter' => $firstErrorKey,
                'errors' => $errors->toArray(),
            ],
        ], 400));
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'error' => 'unauthorized',
            'message' => 'Invalid or missing API key',
        ], 401));
    }

    /**
     * Get the types parameter as an array, converting snake_case to camelCase
     *
     * @return array|null
     */
    public function getTypes()
    {
        $types = null;

        // If new 'types' parameter is provided, use it
        if ($this->has('types')) {
            $types = $this->input('types');
        }
        // Fall back to legacy 'type' parameter for backward compatibility
        elseif ($this->has('type')) {
            $types = [$this->input('type')];
        }

        if (!$types) {
            return null;
        }

        // Convert snake_case types to camelCase
        return array_map(function ($type) {
            return self::TYPE_MAP[$type] ?? $type;
        }, $types);
    }

    /**
     * Get the per_page parameter with fallback to limit
     *
     * @return int
     */
    public function getPerPage()
    {
        // If new 'per_page' parameter is provided, use it
        if ($this->has('per_page')) {
            return $this->input('per_page');
        }

        // Fall back to legacy 'limit' parameter for backward compatibility
        if ($this->has('limit')) {
            return $this->input('limit');
        }

        // Default value
        return 20;
    }

    /**
     * Check if pagination is requested
     *
     * @return bool
     */
    public function wantsPagination()
    {
        return $this->has('page') || $this->has('per_page');
    }
}