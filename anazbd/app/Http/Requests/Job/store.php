<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'title' => 'required|string|min:6',
            'description' => 'required|string',
            'salary'=> 'nullable|string',
            'experience' => 'nullable|string',
            'min_qualification' => 'nullable|string',
            'department' => 'nullable|string',
            'gender' => 'nullable|string',
            'location' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_mobile' => 'required|numeric|regex:/^01[0-9]{9}$/',
            'note' => 'nullable|string',
            'deadline' => 'required|date|after:today',
            'job_type' => 'required|string|in:Full Time,Part Time,Contractual,Freelance'
        ];
    }

    
}
