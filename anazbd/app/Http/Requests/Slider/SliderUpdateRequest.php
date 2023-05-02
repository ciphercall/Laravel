<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'position'  => ['required','integer', Rule::unique('sliders','position')->ignore($this->slider->id)],
            'image'     => 'nullable|mimes:jpg,jpeg,gif,png',
        ];
    }

    public function messages()
    {
        return [
            'position.required' => "position is required.",
            'position.integer'   => 'position must be Number.',
            'position.unique'   => 'This number has already been taken.',
            'image.image'       => 'Invalid image.',
        ];
    }
}
