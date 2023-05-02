<?php

namespace App\Http\Requests\FlashSale;

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
            'start_time' => 'required|date_format:h:i A|before:end_time|unique:flash_sales,start_time,' . $this->id,
            'end_time' => 'required|date_format:h:i A|after:start_time|unique:flash_sales,end_time,' . $this->id,
            'min_percentage' => 'required|numeric|min:0|max:100',
            'max_items_per_seller' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages()
    {
        return [
            'start_time.required' => 'Start time is required',
            'start_time.date_format' => 'Invalid start time format',
            'start_time.before' => 'Start time can\'t be equal or greater than End time',
            'start_time.unique' => 'Start time has already been taken',

            'end_time.required' => 'End time is required',
            'end_time.date_format' => 'Invalid end time format',
            'end_time.after' => 'End time can\'t be equal or smaller than Start time',
            'end_time.unique' => 'End time has already been taken',

            'min_percentage.required' => 'Min percentage is required',
            'min_percentage.numeric' => 'Min percentage must be numeric',
            'min_percentage.min' => 'Min percentage must be equal or greater than 0',
            'min_percentage.max' => 'Min percentage must be equal or smaller than 100',

            'max_items_per_seller.required' => 'Max items is required',
            'max_items_per_seller.numeric' => 'Max items must be numeric',
            'max_items_per_seller.min' => 'Max items must be equal or greater than 0',

            'status.required' => 'Status is required',
        ];
    }
}
