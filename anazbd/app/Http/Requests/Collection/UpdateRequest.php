<?php

namespace App\Http\Requests\Collection;

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
            'title'         => 'required|string',
            'cover_photo'   => 'nullable',
            'cover_photo_2' => 'nullable',
            'cover_photo_3' => 'nullable',
            'status'        => 'required',
            'show_in_home'  => 'nullable',
        ];
    }
}
