<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SellerBusinessAddress extends Model
{
    protected $fillable = [
        'business_address',
        'business_division',
        'business_city',
        'business_postcode',
        'seller_id'
    ];

    public static function addSellerBusinessAddress($request){
        $sellerId = auth()->id();
        $sellerBusinessAddress= array(
            'seller_id'         =>$sellerId,
            'business_address'  => $request->business_address,
            'business_division' => $request->business_division,
            'business_city'     => $request->business_city,
            'business_postcode' => $request->business_postcode,
        );

        SellerBusinessAddress::insert($sellerBusinessAddress);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }
    // public function sellerProfile()
    // {
    //     return $this->belongsTo(SellerProfile::class, 'seller_id', 'id');
    // }

}
