<?php

namespace App\Http\Requests\Units;

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
            'name' => 'required|string|unique:units,name,'.$this->id,
            'conversion' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be string.',
            'name.unique' => 'Name has already been taken.',
            'conversion.required' => 'Conversion is required.',
            'conversion.numeric' => 'Conversion must be number.',
        ];
    }
}
