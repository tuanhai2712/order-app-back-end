<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceListForUserRequest extends FormRequest
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
        return [
            'freight_charges_ls_fast_20' => 'required|numeric',
            'freight_charges_ls_slow_20' => 'required|numeric',
            'freight_charges_ls_fast_20_100' => 'required|numeric',
            'freight_charges_ls_slow_20_100' => 'required|numeric',
            'freight_charges_ls_fast_100' => 'required|numeric',
            'freight_charges_ls_slow_100' => 'required|numeric',
            'freight_charges_hn_fast_100' => 'required|numeric',
            'freight_charges_hn_slow_100' => 'required|numeric',
            'freight_charges_hcm_fast_100' => 'required|numeric',
            'freight_charges_hcm_slow_100' => 'required|numeric',
            'user_id' => 'required|numeric',
            'role' => 'required|numeric',
        ];
    }
}
