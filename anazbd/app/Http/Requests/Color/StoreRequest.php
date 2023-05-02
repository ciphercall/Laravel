<?php

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required|string|unique:colors,name,'.$this->id,
            'value' => 'required|string|unique:colors,value,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Name is required.",
            'name.string'   => 'Name must be string.',
            'name.unique'   => 'Name has already been taken.',
            'value.unique'  => 'Color value has already been taken.',
        ];
    }
}
