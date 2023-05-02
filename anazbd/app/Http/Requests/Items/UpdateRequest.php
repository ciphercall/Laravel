<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'category_id' => 'required|string',
            'sub_category_id' => 'required|string',
            'child_category_id' => 'nullable|string',
            'brand_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'origin_id' => 'required|numeric',

            'v_color_id.*' => 'nullable|numeric',
            'v_size_id.*' => 'nullable|numeric',
            'v_sku.*' => 'nullable|string',
            'v_qty.*' => 'required|numeric',
            'v_price.*' => 'required|numeric',
            'v_image.*' => 'nullable|mimes:jpg,png,jpeg,webp',

            'new_v_color_id.*' => 'nullable|numeric',
            'new_v_size_id.*' => 'nullable|numeric',
            'new_v_sku.*' => 'nullable|string',
            'new_v_qty.*' => 'required|numeric',
            'new_v_price.*' => 'required|numeric',
            'new_v_image.*' => 'nullable|mimes:jpg,png,jpeg,webp',

            'warranty_type' => 'nullable',
            'warranty_period' => 'nullable|required_with:warranty_type',
            'warranty_policy' => 'nullable',

            'highlights' => 'nullable',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Name is required.",
            'category_id.required' => "Category is required.",
            'sub_category_id.required' => "Sub Category is required.",
            'brand_id.required' => "Brand is required.",
            'unit_id.required' => "Unit is required.",
            'origin_id.required' => "Origin is required.",

            'warranty_period.required_with' => "Warranty period is required.",
            'feature_image.image' => 'Invalid image.',
            'feature_image.dimensions' => 'Invalid image dimension.',
            'images.*.image' => 'Each one must be a valid image.',
            'images.*.dimensions' => 'Each one must meet required dimension.',
            'description.required' => 'Description is required'
        ];
    }
}
