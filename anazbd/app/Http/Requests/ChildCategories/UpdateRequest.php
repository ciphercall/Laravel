<?php

namespace App\Http\Requests\ChildCategories;

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
            'category_id' => 'required|numeric',
            'subcategory_id' => 'required|numeric',
            'image'         => 'nullable|mimes:jpg,jpeg,gif,png|dimensions:min_width=100,min_height=100',
            'name' => [
                'required',
                'string',
                Rule::unique('child_categories')
                    ->ignore($this->childCategory->id)
                    ->where(function ($query){
                        return $query
                            ->where('name', $this->name)
                            ->where('category_id', $this->category_id)
                            ->where('subcategory_id', $this->subcategory_id);
                    })
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => "Name is required.",
            'name.string'               => "Name must be string.",
            'name.unique'               => "Name has already been taken.",
            'category_id.required'      => "Category is required.",
            'subcategory_id.required'   => "SubCategory is required.",
            'subcategory_id.numeric'    => "Invalid SubCategory.",
            'category_id.numeric'       => "Invalid Category.",
            'image.image'               => 'Invalid image',
            'image.dimensions' => 'Invalid image height and width.',
        ];
    }
}
