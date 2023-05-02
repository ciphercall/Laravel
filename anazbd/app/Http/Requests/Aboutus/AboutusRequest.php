<?php

namespace App\Http\Requests\Aboutus;

use Illuminate\Foundation\Http\FormRequest;

class AboutusRequest extends FormRequest
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
            'description'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required'   => "Description is required.",
        ];
    }

}
