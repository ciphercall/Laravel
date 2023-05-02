<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerUpdateRequest extends FormRequest
{
   public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image'     => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp'
        ];
    }

    public function messages()
    {
        return [
            'image.required'    => "Image is required.",
        ];
    }
}
