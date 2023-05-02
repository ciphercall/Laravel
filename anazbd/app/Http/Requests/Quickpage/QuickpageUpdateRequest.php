<?php

namespace App\Http\Requests\Quickpage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuickpageUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'          => [    "nullable",
                                    Rule::unique('quick_pages')->ignore($this->quickPage->id),
                                ],

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
