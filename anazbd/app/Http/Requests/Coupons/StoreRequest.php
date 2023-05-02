<?php

namespace App\Http\Requests\Coupons;

use App\Traits\Sluggable;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => az_slug($this->name, '-'),
            'value' => round($this->value)
        ]);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('coupons', 'name')],
            'type' => 'required|in:percent,amount',
            'value' => 'required|numeric|min:0',
            'from' => 'required|date_format:Y-m-d|before_or_equal:to',
            'to' => 'required|date_format:Y-m-d',
            'max_use' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be string.',
            'name.unique' => 'Name has already been taken.',
            'type.required' => 'Type is required.',
            'type.in' => 'Type is invalid.',
            'value.required' => 'Value is required.',
            'value.numeric' => 'Value must be number.',
            'value.min' => 'Value can\'t be negative',
            'from.required' => 'From date is required.',
            'from.date_format' => 'From Date is invalid.',
            'from.before_or_equal' => 'From Date is required to be before or same day as To Date.',
            'to.required' => 'To Date is required.',
            'to.date_format' => 'To Date is invalid.',
            'max_use.required' => 'Max use is required.',
            'max_use.numeric' => 'Max use must be a number.',
            'max_use.min' => 'Max use can\'t be lower than one',
        ];
    }
}
