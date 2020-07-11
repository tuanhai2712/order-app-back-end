<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreateOrderRequest extends FormRequest
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
            'link' => 'required'
        ];
    }

    public function validateImages()
    {
        $images = Request::file('files');
        if ($images) {
            $err = $this->checkMaxImageAndMaxSize($images);
            if (!$err) {
                return false;
            }
        }
        return true;
    }

    private function checkMaxImageAndMaxSize(array $images): bool
    {
        foreach ($images as $image) {
            if ($image->getSize() >= 5000000) {
                return false;
            }
        }
        return true;
    }
}
