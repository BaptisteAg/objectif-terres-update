<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponseTemplateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => ['required', 'string', 'max:100', 'min:3'],
			'content' => ['required', 'string', 'max:1000', 'min:10'],

		];
	}
}
