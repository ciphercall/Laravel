<?php

namespace App\Http\Requests\WarrantyTypes;

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
            'name' => 'required|string|unique:warranty_types,name,'.$this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Name is required.",
            'name.string' => 'Name must be string.',
            'name.unique' => 'Name has already been taken.',
        ];
    }
}
