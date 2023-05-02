<?php

namespace App\Http\Requests\Collection;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable',
            'title'        => 'required|string',
            'cover_photo'  => 'required_without:id',
            'cover_photo_2'  => 'required_without:id',
            'cover_photo_3'  => 'required_without:id',
            'status'       => 'required',
            'show_in_home'  => 'nullable',
        ];
    }





}
