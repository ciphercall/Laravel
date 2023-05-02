<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerStore extends FormRequest
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
            'name'               => 'required|min:6',
            'email'              => 'required|email',
            'phone'              => 'required|numeric|min:11|regex:/^01[0-9]{9}$/',
            'address'            => 'nullable|string|max:191',
            'image'              => 'nullable|mimes:jpg,jpeg,gif,png|max:500',
            'resume'             => 'required|mimes:pdf,doc,docx|max:1000',
            'cover_letter'       => 'nullable|max:600',
            'perferred_location' => 'required',
            'institute_name.*'   => 'required|string|min:2',
            'gpa.*'              => 'required|numeric|between:0.00,5.00',
            'education_level.*'  => 'required|string',
            'passing_year.*'     => 'nullable|numeric',
            'location.*'         => 'nullable|string',
            'job_post'           => 'nullable|string',
            'a_o_i'              => 'nullable|string'
        ];
    }
}
