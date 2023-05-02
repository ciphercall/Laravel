<?php

namespace App\Http\Requests\Brands;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:brands,name,'.$this->id,
            'image' => 'nullable|mimes:jpg,jpeg,gif,png,webp|dimensions:min_width=100,min_height=100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Name is required.",
            'name.string' => 'Name must be string.',
            'name.unique' => 'Name has already been taken.',
            'image.image' => 'Invalid image.',
            'image.dimensions' => 'Invalid image dimension.',
        ];
    }
}
