<?php

namespace App\Models;

use App\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;
use NabilAnam\SimpleUpload\SimpleUpload;

class SellerProfile extends Model
{
    protected $fillable = [
        'proprietor_name',
        'registration_number',
        'crporate_address',
        'vat_registration_number',
        'nid_number',
        'trade_licenses',
        'main_business',
        'product_category',
        'corporate_number',
        'location_details',
        'address',
        'seller_logo',
        'division',
        'city',
        'postcode',
        'logo',
        'product_image',
        'seller_id'
    ];

    public static function addSellerProfile($request){

        $sellerId = auth()->id();
        $profileDetails = array(
            'seller_id'             =>$sellerId,
            'proprietor_name'       => $request->proprietor_name,
            'registration_number'   => $request->registration_number,
            'crporate_address'      => $request->crporate_address,
            'vat_registration_number' => $request->vat_registration_number,
            'nid_number'            => $request->nid_number,
            'trade_licenses'        => $request->trade_licenses,
            'main_business'         => $request->main_business,
            'product_category'      => $request->product_category,
            'corporate_number'      => $request->corporate_number,
            'location_details'      => $request->location_details,
            'address'               => $request->address,
            'division'              => $request->division,
            'city'                  => $request->city,
            'postcode'              => $request->postcode,
        );

        $profileDetails['seller_logo']          = (new SimpleUpload)->file($request->seller_logo)->dirName('seller-logo')->save();
        $profileDetails['logo']                 = (new SimpleUpload)->file($request->seller_logo)->resizeImage(44,44)->dirName('logo')->save();
        $profileDetails['product_image']        = (new SimpleUpload)->file($request->product_image)->resizeImage(203,203)->dirName('product_image')->save();

        SellerProfile::insert($profileDetails);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    // public function businessAddress()
    // {
    //     return $this->hasOne(SellerBusinessAddress::class, 'seller_id', 'id');
    // }

    // public function returnAddress()
    // {
    //     return $this->hasOne(SellerReturnAddress::class, 'seller_id', 'id');
    // }





}
