<?php

namespace App\Http\Requests\Purchases;

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
            'source_id' => 'required|numeric',
            'ref_no' => 'nullable|string|unique:purchases,ref_no,'.$this->id,
            'purchase_date' => 'required|date_format:Y-m-d',

            'items.*' => 'required|distinct',
            'quantities.*' => 'required|numeric',
            'rates.*' => 'required|numeric',

            'detail_items.*' => 'required|distinct',
            'detail_quantities.*' => 'required|numeric',
            'detail_rates.*' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'source_id.required' => 'Source is required.',
            'source_id.numeric' => 'Source is invalid.',
            'ref_no.string' => 'Reference No. is invalid.',
            'ref_no.unique' => 'Reference No. has already been taken.',
            'purchase_date.required' => 'Purchase date is required.',
            'purchase_date.date_format' => 'Purchase date format is invalid.',

            'items.*.required' => 'Item is required.',
            'items.*.distinct' => 'Items are duplicate.',
            'quantities.*.required' => 'Quantity is required.',
            'quantities.*.numeric' => 'Quantity is invalid.',
            'rates.*.required' => 'Rate is required.',
            'rates.*.numeric' => 'Rate is invalid.',

            'detail_items.*.required' => 'Item is required.',
            'detail_items.*.distinct' => 'Items are duplicate.',
            'detail_quantities.*.required' => 'Quantity is required.',
            'detail_quantities.*.numeric' => 'Quantity is invalid.',
            'detail_rates.*.required' => 'Rate is required.',
            'detail_rates.*.numeric' => 'Rate is invalid.',
        ];
    }
}
