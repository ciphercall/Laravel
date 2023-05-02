<?php

namespace App\Http\Requests\Subcategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vat'         => 'nullable',
            'category_id' => 'required',
            'commission'  => 'required|numeric',
            'image'         => 'nullable|image|dimensions:min_width=100,min_height=100',
            'name' => ['required','string','unique:sub_categories,name,'.$this->id],
            'delivery_charge' => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => "name is required.",
            'name.string'           => "name must be string.",
            'name.unique'           => "name has already been taken.",
            'category_id.required'  => "Category is required.",
            'category_id.numeric'   => "Invalid category.",
            'Commission .numeric'   => "Invalid Commission.",
            'vat .numeric'          => "Invalid vat.",
            'image.image'           => 'Invalid image',
            'image.dimensions' => 'Invalid image height and width.',
        ];
    }
}
