<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|max:16|min:8',
            'address' => 'max:500',
            'phone_number' => 'required|max:11|min:9|regex:/^[\(\)\.\-\+\/\ 0-9]+$/',
        ];
    }
}
