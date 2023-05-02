<?php

namespace App\Http\Requests\Auth\Customer;

use App\Traits\DetectUsernameType;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use DetectUsernameType;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username_type' => $this->getUsernameType($this->get('username'))
        ]);
    }

    public function rules()
    {
        return [
            'username' => ['required', 'string', 'min:3', function ($attribute, $value, $fail) {
                if ($this->username_type == null) {
                    $fail('Invalid mobile no or email!');
                }
            }],
            'password' => 'required|string|min:1',
        ];
    }
}
