<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class TrackingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'user'      => 'required|string',
            'order_id'  => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'user.required'     => "Can't Empty",
            'order_id.required' => "Can't Empty"
        ];
    }
}
