<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|numeric',
            'position' => 'required|integer|unique:sliders',
            'image'     => 'required_without:id|mimes:jpg,jpeg,gif,png',
        ];
    }

    public function messages()
    {
        return [
            'image.required'    => "Image is required.",
            'position.required' => "position is required.",
            'position.integer'  => 'position must be Number.',
            'position.unique'   => 'This number has already been taken.',
            'image.image'       => 'Invalid image.',
        ];
    }
}
