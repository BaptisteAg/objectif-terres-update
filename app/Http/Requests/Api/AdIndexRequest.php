<?php

namespace App\Http\Requests\Api;

use App\Models\Ad;
use App\Models\AdStatus;
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

            // Date filter - accepts YYYY-MM-DD or ISO 8601 (YYYY-MM-DDTHH:MM:SSZ)
            'updated_since' => 'nullable|date',

            // Pagination
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:200',

            // Status filter shortcut: all, approved, archived
            'status' => 'nullable|string|in:all,approved,archived',

            // Status filters (advanced)
            'include_deleted' => 'nullable|in:true,false,1,0',
            'include_archived' => 'nullable|in:true,false,1,0',
            'statuses' => 'nullable|array',
            'statuses.*' => 'integer|in:1,2,3,4,5',

            // Legacy parameters (to be removed)
            'limit' => 'nullable|integer|min:1|max:200',
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
            'updated_since.date' => 'The updated_since parameter must be a valid date (YYYY-MM-DD or YYYY-MM-DDTHH:MM:SSZ).',
            'page.integer' => 'The page parameter must be a valid integer.',
            'page.min' => 'The page parameter must be at least 1.',
            'per_page.integer' => 'The per_page parameter must be a valid integer.',
            'per_page.min' => 'The per_page parameter must be at least 1.',
            'per_page.max' => 'The per_page parameter cannot exceed 200.',
            'status.in' => 'The status parameter must be one of: all, approved, archived.',
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
        return 50;
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

    /**
     * Check if soft deleted ads should be included
     *
     * @return bool
     */
    public function shouldIncludeDeleted()
    {
        return filter_var($this->input('include_deleted', false), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Check if archived ads should be included
     *
     * @return bool
     */
    public function shouldIncludeArchived()
    {
        $status = $this->input('status');
        if ($status === 'all' || $status === 'archived') {
            return true;
        }
        return filter_var($this->input('include_archived', false), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the status shortcut value (all, approved, archived)
     *
     * @return string|null
     */
    public function getStatusShortcut()
    {
        return $this->input('status');
    }

    /**
     * Get status IDs to filter by
     *
     * @return array
     */
    public function getStatuses()
    {
        $statuses = $this->input('statuses');
        if (is_array($statuses) && count($statuses) > 0) {
            return array_map('intval', $statuses);
        }
        return [AdStatus::APPROVE_ID];
    }
}