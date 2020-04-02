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
		return [
			'name' => ['required', 'string', 'max:1000'],
			'email' => [
				'required',
				'string', 'email',
				'max:255',
				\Illuminate\Validation\Rule::unique('users')->ignore($this->user()->id),
			],
			'first_name' => ['required', 'string', 'max:255'],
			'phone' => ['string', 'min:10', 'max:255'],
			'address' => ['string', 'min:5', 'required'],
			'civility' => ['required'],
			'profile' => ['required'],
			'city_id' => ['required'],
			'current_password' => [ 'min:5'],
			'password' => [ 'confirmed', 'min:5']

		];
	}

	/**
	 * Configure the validator instance.
	 *
	 * @param  \Illuminate\Validation\Validator  $validator
	 * @return void
	 */
	public function withValidator($validator)
	{
		// checks user current password
		// before making changes
		$validator->after(function (Validator $validator) {
			if ($this->current_password){
				if ( !Hash::check($this->current_password, auth()->user()->password) ) {
					$validator->errors()->add('current_password', 'Votre mot de passe actuel est incorrect.');
				}
			}
		});
		return;
	}
}