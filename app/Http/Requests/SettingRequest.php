<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        ];
    }

    public function validateImages()
    {
        $image = Request::file('file');
        if ($image) {
            $err = $this->checkMaxImageAndMaxSize($image);
            if (!$err) {
                return false;
            }
        }
        return true;
    }

    private function checkMaxImageAndMaxSize($image): bool
    {
        if ($image->getSize() >= 5000000) {
            return false;
        }
        return true;
    }
}
