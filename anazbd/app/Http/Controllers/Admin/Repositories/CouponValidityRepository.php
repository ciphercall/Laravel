<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Interfaces\Coupon\CouponValidityInterface;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\UserCoupon;
use Carbon\Carbon;

class CouponValidityRepository implements CouponValidityInterface{

    private ?Coupon $coupon = null;
    private ?Cart $cart = null;
    private $location_id = null;

    public function __construct(Coupon $coupon,Cart $cart, $location_id = null)
    {
        $this->coupon = $coupon;
        $this->cart = $cart;
        $this->location_id = $location_id;
    }

    /* 
        Checks if the coupon is valid for use

        returns boolean
    */
    public function checkValidity() : bool
    {
        // dd($this->validForToday(),$this->checkMaxUseLimit(),$this->couponOnVerified());
        // checks if coupon is valid Today & max usage limit
        if($this->validForToday() && $this->checkMaxUseLimit() && $this->checkMinimumAmount()){

            // check if cart has the defined coupon on Models 
            // i.e [Category, Subcategory, Child Category, seller, Item, User, anaz_empire, anaz_spotlight]
            $extra = $this->coupon->couponExtra->first();
            return $this->couponOnVerified($extra->coupon_on,$extra->couponable_id,$extra->min_amount);
            
        }

        return false;
    }

    private function validForToday() : bool
    {
        $today = Carbon::now();
        if($this->coupon != null && $this->coupon->from <= $today && $this->coupon->to >= $today && $this->coupon->is_active)
            return true;

        $this->cart->coupon_error_msg = "Coupon is no longer valid.";
        return false;
    }

    private function checkMaxUseLimit() : bool
    {
        $count = UserCoupon::where('user_id',$this->cart->user_id)->where('coupon_id', $this->coupon->id)->count();
        if($count < $this->coupon->max_use){
            return true;
        }
        $this->cart->coupon_error_msg = "Maximum limit of $this->coupon->name is reached.";
        return false;
    }

    public function checkMinimumAmount() : bool
    {
        if($this->cart->subtotal >= $this->coupon->min_amount){
            return true;
        }
        
        $this->cart->coupon_error_msg = "This coupon is valid for amount equal or greater than $this->cart->subtotal";
        return false;
    }

    private function couponOnVerified($coupon_on,$couponable_id = null,$min_amount = 0)
    {
        switch ($coupon_on){

            case 'subtotal':
                return $this->cart->subtotal >= $min_amount;

            case 'delivery_charge':
                return $this->cart->subtotal >= $min_amount;

            case 'Category':

                // check if cart items has category_id == couponExtra.couponable_id 
                // return true if yes
                $res = $this->cart->cart_items->where('active',true)->where('category_id',$couponable_id);
                return $res->count() > 0 && $res->sum('subtotal') >= $min_amount;

            case 'SubCategory':

                // check if cart items has subcategory_id == couponExtra.couponable_id
                // return true if yes
                $res = $this->cart->cart_items->where('active',true)->where('sub_category_id',$couponable_id);
                return $res->count() > 0 && $res->sum('subtotal') >= $min_amount;

            case 'ChildCategory':

                // check if cart items has child_category_id == couponExtra.couponable_id
                // return true if yes
                $res = $this->cart->cart_items->where('active',true)->where('child_category_id',$couponable_id);
                return $res->count() > 0  && $res->sum('subtotal') >= $min_amount;

            case 'Item':
                // check if cart items has item_id == couponExtra.couponable_id
                // return true if yes
                $item = $this->cart->cart_items->where('active',true)->where('item_id',$couponable_id)->first();
                return $item != null && $item->subtotal >= $min_amount;

            case 'Seller':

                // check if cart items has seller_id == couponExtra.couponable_id
                // return true if yes
                $items = $this->cart->cart_items->where('active',true)->where('seller_id',$couponable_id);
                return $items->count() > 0 && $items->sum('subtotal') >= $min_amount;

            case 'User':

                // check if cart is from user_id == couponExtra.couponable_id
                // return true if yes
                return $this->cart->user_id == $couponable_id && $this->cart->subtotal >= $min_amount;

            case 'anaz_empire':

                // check if cart items has seller who is listed as anaz_empire
                // return true if yes
                $res = $this->cart->cart_items->where('active',true)->where('is_anaz_empire',true);
                return $res->count() > 0 && $res->sum('subtotal') >= $min_amount;

            case 'anaz_spotlight':

                // check if cart items has seller who is listed as anaz_spotlight
                // return true if yes
                $res = $this->cart->cart_items->where('active',true)->where('is_anaz_spotlight',true);
                return $res->count() > 0 && $res->sum('subtotal') >= $min_amount;

            case 'Location':
                return $this->location_id == $couponable_id && $this->cart->subtotal >= $min_amount;

            default:
                return false;
        }
    }
}