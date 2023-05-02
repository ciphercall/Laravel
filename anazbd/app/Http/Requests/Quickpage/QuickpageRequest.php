<?php

namespace App\Http\Requests\Quickpage;

use Illuminate\Foundation\Http\FormRequest;

class QuickpageRequest extends FormRequest
{
   public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|unique:quick_pages',
            'short_desc'    => 'required',
            'section'       => 'required',

        ];
    }

    public function messages()
    {
        return [
            'section.required'      => "section is required.",
            'name.required'         => "name is required.",
            'short_desc.required'   => "Description is required.",
            'name.string'           => 'name must be string.',
            'name.unique'           => 'name has already been taken.',
        ];
    }
}
