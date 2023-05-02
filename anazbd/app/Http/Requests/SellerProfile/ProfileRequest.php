<?php

namespace App\Http\Requests\SellerProfile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'                      =>  'required',
            'proprietor_name'           =>  'required',
            'registration_number'       =>  'required',
            'crporate_address'          =>  'required',
            'vat_registration_number'   =>  'required',
            'nid_number'                =>  'required',
            'trade_licenses'            =>  'required',
            'main_business'             =>  'required',
            'product_category'          =>  'required',
            'corporate_number'          =>  'required',
            'location_details'          =>  'required',
            'address'                   =>  'required',
            'seller_logo'               =>  'required',
            'division'                  =>  'required',
            'city'                      =>  'required',
            'postcode'                  =>  'required',
            // 'logo'                      =>  'required',
            // 'product_image'             =>  'required',
        ];
    }




}
