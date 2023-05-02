<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'position' => 'required|integer|unique:offers,position,'.$this->id,
            'image' => 'nullable|image|dimensions:min_width=100,min_height=100',
        ];
    }

    public function messages()
    {
        return [
            'image.required'    => "Image is required.",
            'position.required' => "position is required.",
            'position.integer'  => 'position must be Number.',
            'position.unique'   => 'position has already been taken.',
            'image.image'       => 'Invalid image.',
            'image.dimensions'  => 'Invalid image dimension.',
        ];
    }
}
