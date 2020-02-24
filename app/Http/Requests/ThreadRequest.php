<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required', 'string', 'max:1000'],
			'ad_id' => [ 'integer'],
			'receiver_user_message' =>['integer'],
			'title' =>['string']
        ];
    }
}
