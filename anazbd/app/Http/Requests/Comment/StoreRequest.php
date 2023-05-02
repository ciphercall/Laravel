<?php

namespace App\Http\Requests\Comment;

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
            'rating' => 'required|integer',
            'review' => 'required|string',
        ];
    }

    public function message()
    {
        return [
            'rating.integer'    => 'Rating Must Be Integer.',
            'review.string'     => 'Review Must Be String type Data.',
        ];
    }

}
