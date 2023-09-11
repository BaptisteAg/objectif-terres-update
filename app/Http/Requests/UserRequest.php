<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class UserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$emailRule = ['email' => [
			'required',
			'string', 'email',
			'max:255',
			\Illuminate\Validation\Rule::unique('users')->ignore($this->user()->id),
		],];

		//in case of an pp profile update from an TDL member
		if ($this->user()->role >= 2 && $this->request->get('user_id') !== $this->user()->id) {
			$emailRule = ['email' => [
				'required',
				'string',
				'email',
				'max:255',
//				\Illuminate\Validation\Rule::unique('users'),
			],];

		}
		return array_merge([
			'name' => ['required', 'string', 'max:1000', 'alpha_dash'],
			'first_name' => ['required', 'string', 'max:255', 'alpha_dash'],
			'phone' => ['nullable', 'string', 'min:10', 'max:255'],
			'address' => ['nullable', 'string', 'min:5'],
			'civility' => ['required'],
			'profile' => ['required'],
			'city_id' => ['nullable', "integer"],
			'current_password' => ['min:5'],
			'password' => ['confirmed', 'min:5'],
			'user_id' => ['integer']

		], $emailRule);
	}

	/**
	 * Configure the validator instance.
	 *
	 * @param \Illuminate\Validation\Validator $validator
	 * @return void
	 */
	public function withValidator($validator)
	{
		// checks user current password
		// before making changes
		$validator->after(function (Validator $validator) {
			if ($this->current_password) {
				if (!Hash::check($this->current_password, auth()->user()->password)) {
					$validator->errors()->add('current_password', 'Votre mot de passe actuel est incorrect.');
				}
			}
		});
		return;
	}
}