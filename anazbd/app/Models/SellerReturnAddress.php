<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;
class SellerReturnAddress extends Model
{
    protected $fillable = [
        'return_address',
        'return_division',
        'return_city',
        'return_postcode',
        'seller_id'
    ];

    public static function addSellerReturnAddress($request){
//        $sellerId = Auth::user()->id;
        $sellerId = auth()->id();
        $sellerReturnAddress = array(
            'seller_id' =>$sellerId,
            'return_address' => $request->return_address,
            'return_division' => $request->return_division,
            'return_city' => $request->return_city,
            'return_postcode' => $request->return_postcode,
        );
        SellerReturnAddress::insert($sellerReturnAddress);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }
//    public function sellerProfile()
//    {
//        return $this->belongsTo(SellerProfile::class, 'seller_id', 'id');
//    }
}
