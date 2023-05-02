<?php

namespace App\Http\Requests\Banner;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|numeric',
            'image'     => 'required_without:id|nullable|mimes:jpg,jpeg,png,bmp,gif,svg,webp'
        ];
    }

    public function messages()
    {
        return [
            'image.required_without'    => "Image is required."
        ];
    }
}
