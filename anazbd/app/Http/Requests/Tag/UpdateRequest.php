<?php

namespace App\Http\Requests\Tag;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'      => ['required', 'string', Rule::unique('tags', 'name')->ignore($this->tag->id)],
            'status'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => "Name is required.",
            'status.required'   => "Status is required.",
            'name.string'       => 'Name must be string.',
            'name.unique'       => 'Name has already been taken.',
        ];
    }
}
