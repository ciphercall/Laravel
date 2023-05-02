<?php

namespace App\Http\Requests\SiteInfo;

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
            'name'              => 'required|string',
            'address'           => 'required|string',
            'email'             => 'required|email',
            'mobile'            => 'required|string',
            'short_desc'        => 'required|string',
            'logo'              => 'nullable|image|dimensions:min_width=150,min_height=33',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Name field can not be empty',
            'email.required'    => 'Email field can not be empty',
            'address.required'  => 'Address field can not be empty',
            'mobile.required'   => 'Mobile field can not be empty',
            'logo.dimensions'   => 'Logo width minimum 150px & height minimum 33px',
        ];
    }
}
