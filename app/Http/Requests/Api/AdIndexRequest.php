<?php

namespace App\Http\Requests\Api;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdIndexRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Types parameter - now accepts array
            'types' => 'nullable|array',
            'types.*' => 'string|in:' . implode(',', array_keys(Ad::AD_TYPES)),

            // Date filter - ISO 8601 format
            'updated_since' => 'nullable|date_format:Y-m-d\TH:i:s\Z',

            // Pagination
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',

            // Legacy parameters (to be removed)
            'limit' => 'nullable|integer|min:1|max:100',
            'type' => 'nullable|string|in:' . implode(',', array_keys(Ad::AD_TYPES)),
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
            'types.array' => 'The types parameter must be an array.',
            'types.*.in' => 'Invalid ad type provided. Valid types are: ' . implode(', ', array_keys(Ad::AD_TYPES)),
            'updated_since.date_format' => 'The updated_since parameter must be in ISO 8601 format (YYYY-MM-DDTHH:MM:SSZ).',
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
     * Get the types parameter as an array
     *
     * @return array|null
     */
    public function getTypes()
    {
        // If new 'types' parameter is provided, use it
        if ($this->has('types')) {
            return $this->input('types');
        }

        // Fall back to legacy 'type' parameter for backward compatibility
        if ($this->has('type')) {
            return [$this->input('type')];
        }

        return null;
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