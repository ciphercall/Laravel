<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class SellerRegister extends FormRequest
{
    
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
            'name'              => 'required|string',
            'email'             => 'required|email|unique:sellers',
            'number'            => 'required|numeric|unique:sellers',
            'shop_name'         => 'required|unique:sellers',
            'type'              => 'required',
            'password'          => 'required|min:6',
            'password_confirm ' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'type.required'             => "Whis type your account?",
            'name.required'             => "Name is required.",
            'number.required'           => "number is required.",
            'number.numeric'            => "Mobile number must be integer.",
            'name.string'               => 'Name must be string.',
            'email.required'            => "Email is required.",
            'email.unique'              => 'This email has already been taken.',
            'password.required'         => "password is required.",
            'password_confirm.required' => "Confirm Password is required."
        ];
    }
}
