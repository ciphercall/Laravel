<?php

namespace App\Http\Requests\Admin\Coupon;

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
    
    /* 
        Prepare for validation
    */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => az_slug($this->name, '-')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|unique:coupons,name',
            'min_amount'        => 'required|numeric|min:0',
            'from'              => 'required|date_format:Y-m-d|after:yesterday',
            'to'                => 'required|date_format:Y-m-d|after_or_equal:from',
            'max_use'           => 'required|numeric|min:1',
            'is_active'         => 'nullable',
            'type.*'            => 'required|in:percent,amount',
            'value.*'           => 'required|numeric|min:0',
            'minimum_amount.*'  => 'required|numeric|min:0',
            'coupon_on.*'       => 'required|string|in:subtotal,Category,Location,SubCategory,ChildCategory,Seller,User,Item,anaz_empire,anaz_spotlight,delivery_charge',
            'couponable_id.*'   => 'required_if:on,[Category,Location,SubCategory,ChildCategory,Seller,User,Item]',
            'couponable_type.*' => 'required_if:on,[Category,Location,SubCategory,ChildCategory,Seller,User,Item]|string',
            'error_msg'         => 'nullable|string|min:6',
            'success_msg'       => 'nullable|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'to.after_or_equal' => 'Coupon Valid Till Date must be equal or after '.$this->from.'.',
            'value.*.numeric' => 'The Value must be a number.',
            'type.*.required' => 'Amount Type is required',
            'coupon_on.*.required' => 'Coupon on is required',
            'minimum_amount.*.numeric' => 'Minimum Amount should be a number value. Ex: 10',
            'minimum_amount.*.required' => 'Minimum Amount is required',
        ];
    }
}
