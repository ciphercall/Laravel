<?php

namespace App\Http\Requests\Cart;

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
            'item' => 'required',
            'color' => 'nullable',
            'size' => 'nullable',
            'qty' => 'required|numeric',
        ];
    }
}
