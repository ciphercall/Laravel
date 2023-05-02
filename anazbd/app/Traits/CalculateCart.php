<?php

namespace App\Traits;

use App\Http\Controllers\Admin\Repositories\CouponApplyRepository;
use App\Http\Controllers\Admin\Repositories\CouponValidityRepository;
use App\Models\BillingAddress;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\PointRedeem;
use App\Seller;
use Carbon\Carbon;

trait CalculateCart
{
    use CalculateCoupon;

    private function calculateCart($dbHit = true, $cart = null, $cartItems = null, $coupon = null)
    {
        if($cart == null){
            $cart = Cart::whereAuthUser()
            ->with(['cart_items' => function ($q) {
                $q->with(['product' => function ($r) {
                    $r->with('variants.color', 'variants.size', 'delivery_size')
                        ->with(['sub_category' => function ($s) {
                            $s->select('id', 'vat', 'commission','delivery_charge');
                        }])
                        ->with(['flash_sales' => function ($r) {
                            $r->whereCurrentDateTime();
                        }]);
                }])->whereHas('product', function ($r) {
                    $r->where('status', true);
                });
            }])
            ->first();
        }
        if($cart && $cart->cart_items != null && $cart->cart_items->count() > 0){

            $shipping_address = null;

            $billing_address = BillingAddress::whereAuthUser()->latest()->first();
            $is_main_location = az_is_dhaka($billing_address->city_id ?? auth('web')->user()->city_id);
            $cart->is_main_location = $is_main_location ?? false;

            $location_id = $shipping_address != null ? $shipping_address->city_id : ($billing_address->city_id ?? auth('web')->user()->city_id);
            
            $cart->is_online_pay_only = false;
            $cart->partial_payment_amount = 0;
            $cart->partial_payment = false;
            
            $this->calculateCartMiscCharges($cart,$is_main_location);
            // validate coupon if any
            $cart->coupon = $coupon ?? $cart->coupon;
            // dd($coupon,$cart->coupon,$cart);
            // dd($cart->partial_payment_amount,$cart);
            // return cart
            return $this->calculateRedeem($this->couponCalculation($cart,$location_id));
        }
    }

    private function calculateCartAPI(){
        $user = request()->user();
        $cart = Cart::where('user_id',$user->id)
        ->with(['cart_items' => function ($q) {
            $q->with(['product' => function ($r) {
                $r->with('variants.size', 'delivery_size');
            }])->whereHas('product', function ($r) {
                $r->where('status', true);
            });
        }])
        ->first();
        if($cart && $cart->cart_items != null && $cart->cart_items->count() > 0) {

            $shipping_address = null;

            $billing_address = BillingAddress::where('user_id', $user->id)->latest()->first();
            $is_main_location = az_is_dhaka($billing_address->city_id ?? auth('api')->user()->city_id);

            $cart->is_online_pay_only = false;
            $cart->partial_payment_amount = 0;
            $cart->partial_payment = false;

            $cart->address = $billing_address;
            $location_id = $shipping_address != null ? $shipping_address->city_id : ($billing_address->city_id ?? auth('api')->user()->city_id);
            $this->calculateCartMiscCharges($cart, $is_main_location);
            // validate coupon if any
            $cart->coupon = $coupon ?? $cart->coupon;

            return $this->calculateRedeem($this->couponCalculation($cart, $location_id));
        }
    }

    public function calculateRedeem($cart)
    {
        $redeem = PointRedeem::where('user_id',$cart->user_id)->where('status','active')->where('code',$cart->redeem)->first();
        $cart->redeem_value = 0;
        if($redeem != null && $cart->total > $redeem->value){
            $today = Carbon::now();
            if($redeem->created_at <= $today && $redeem->valid_till >= $today){
                // substract redeem value
                $cart->total -= $redeem->value;
                $cart->redeem_value = $redeem->value;
                // add success msg
                $cart->redeem_success_msg = "Redeem Code is applied successfully.";
            }else{
                $cart->redeem_error_msg = "Redeem Code is no longer valid.";
            }
        }else{
            $cart->redeem_error_msg = $redeem != null ? "Redeem value must not be greater than total amount." : "Redeem is invalid. Try again.";
        }
        return $cart;
    }

    private function couponCalculation($cart,$location_id){
        if($cart->coupon != null){
            $myCoupon = Coupon::where('name',$cart->coupon)->with('couponExtra','couponExtra.couponable')->first();
            if($myCoupon){
                // $cart->coupon_on = $myCoupon->on;
                $couponValidationRepo = new CouponValidityRepository($myCoupon,$cart,$location_id);
                // apply coupon if validated
                if($couponValidationRepo->checkValidity()){
                    $couponApplyRepo = new CouponApplyRepository($cart,$myCoupon);
                    $cart = $couponApplyRepo->apply();
                    $cart->coupon_success_msg = $myCoupon->success_msg;
                    $cart->coupon_error_msg = $myCoupon->error_msg;
                    return $cart;
                }
                $cart->coupon_error_msg = $myCoupon->error_msg;
                Cart::find($cart->id)->update(['coupon' => null]);
            }else{
                Cart::find($cart->id)->update(['coupon' => null]);
            }
        }
        $cart->is_coupon_applied = false;
        return $cart;
    }

    public function calculateCartMiscCharges($cart,$is_main_location)
    {
        // calculate cart Items
        if($cart != null && $cart->cart_items->count() > 0){
            $activeItems = $cart->cart_items->where('active',true);
            $cart->activeCount = $activeItems->count();
            foreach ($activeItems as $item){
                $this->calculateCartItem($item);
            }
        }
        $cart->subtotal_without_coupon = $activeItems->sum('subtotal');
        // calculate total cart infos
        $cart->delivery_charge_dhaka = 0;
        $cart->delivery_charge_other = 0;
        $totalMallCustomerDhaka      = 0;
        $totalMallCustomerOther      = 0;
        $totalMallAgentDhaka         = 0;
        $totalMallAgentOther         = 0;
        $deliveryBreakdown = [];
        foreach ($activeItems->groupBy('seller_id') as $group) {
            $maxCustomerDhaka = 0;
            $maxCustomerOther = 0;
            $maxAgentDhaka    = 0;
            $maxAgentOther    = 0;

            // dd($group,$group->first()->seller_id, Seller::find($group->first()->seller_id)->is_anazmall_seller);
            foreach ($group as $key => $cartItem) {
                if($cartItem->product->seller->is_anazmall_seller){
                    $cartItem['shipping_charge_dhaka'] = $cartItem->product->delivery_size->customer_dhaka;
                    $cartItem['shipping_charge_other'] = $cartItem->product->delivery_size->customer_other;
                    if ($cartItem->product->delivery_size->customer_dhaka > $totalMallCustomerDhaka)
                        $totalMallCustomerDhaka = $cartItem->product->delivery_size->customer_dhaka;
                    if ($cartItem->product->delivery_size->customer_other > $totalMallCustomerOther)
                        $totalMallCustomerOther = $cartItem->product->delivery_size->customer_other;

                    if ($cartItem->product->delivery_size->agent_dhaka > $totalMallAgentDhaka)
                        $totalMallAgentDhaka = $cartItem->product->delivery_size->agent_dhaka;
                    if ($cartItem->product->delivery_size->agent_other > $totalMallAgentOther)
                        $totalMallAgentOther = $cartItem->product->delivery_size->agent_other;

                    $cart->delivery_charge_dhaka += $cartItem->product->additional_delivery_charge;
                    $cart->delivery_charge_other += $cartItem->product->additional_delivery_charge;

                    $deliveryBreakdown["Anaz Empire"] = $is_main_location ? $totalMallCustomerDhaka :$totalMallCustomerOther;
                }else{
                    $cartItem['shipping_charge_dhaka'] = $cartItem->product->delivery_size->customer_dhaka;
                    $cartItem['shipping_charge_other'] = $cartItem->product->delivery_size->customer_other;
                    if ($cartItem->product->delivery_size->customer_dhaka > $maxCustomerDhaka)
                        $maxCustomerDhaka = $cartItem->product->delivery_size->customer_dhaka;
                    if ($cartItem->product->delivery_size->customer_other > $maxCustomerOther)
                        $maxCustomerOther = $cartItem->product->delivery_size->customer_other;

                    if ($cartItem->product->delivery_size->agent_dhaka > $maxAgentDhaka)
                        $maxAgentDhaka = $cartItem->product->delivery_size->agent_dhaka;
                    if ($cartItem->product->delivery_size->agent_other > $maxAgentOther)
                        $maxAgentOther = $cartItem->product->delivery_size->agent_other;

                    $cart->delivery_charge_dhaka += $cartItem->product->additional_delivery_charge;
                    $cart->delivery_charge_other += $cartItem->product->additional_delivery_charge;

                    $deliveryBreakdown[$cartItem->product->seller->shop_name] = $is_main_location ? $maxCustomerDhaka : $maxCustomerOther;
                }

                if ($cart->is_online_pay_only == false && $cartItem->is_online_pay_only == true){
                    $cart->is_online_pay_only = true;
                }
                if ($cartItem->product->online_payable_type != null) {
                    $cart->partial_payment = true;
                    switch ($cartItem->product->online_payable_type) {
                        case 'half_pay':
                            # half of item subtotal
                            $cart->partial_payment_amount += $cartItem->subtotal / 2;
                            break;
                        case 'full_pay':
                            # full of item subtotal
                            $cart->partial_payment_amount += $cartItem->subtotal;
                            break;
                        default:
                            # delivery charge of item
                            $cart->partial_payment_amount += $is_main_location ? $cartItem->product->delivery_size->customer_dhaka : $cartItem->product->delivery_size->customer_other;
                            break;
                    }
                }

            }
            // $deliveryBreakdown[""]
            $cart->delivery_charge_dhaka += $maxCustomerDhaka;
            $cart->delivery_charge_other += $maxCustomerOther;
            $cart->agent_charge_dhaka    += $maxAgentDhaka;
            $cart->agent_charge_other    += $maxAgentOther;
        }
        $cart->deliveryBreakdown      = $deliveryBreakdown;
        $cart->delivery_charge_dhaka += $totalMallCustomerDhaka;
        $cart->delivery_charge_other += $totalMallCustomerOther;
        $cart->agent_charge_dhaka    += $totalMallAgentDhaka;
        $cart->agent_charge_other    += $totalMallAgentOther;
        $cart->agent_charge_dhaka     = round($cart->agent_charge_dhaka);
        $cart->agent_charge_other     = round($cart->agent_charge_other);

        $cart->delivery_charge = $is_main_location ? $cart->delivery_charge_dhaka : $cart->delivery_charge_other;
        $cart->subtotal = $cart->subtotal_without_coupon;
        $cart->total_dhaka = round($cart->subtotal_without_coupon + $cart->delivery_charge_dhaka);
        $cart->total_other = round($cart->subtotal_without_coupon + $cart->delivery_charge_other);
        $cart->total       = $is_main_location ? $cart->total_dhaka : $cart->total_other;
        $cart->coupon_value = 0;
    }

    private function calculateCartItem($cartItem)
    {
        if ($cartItem->active) {
            $variant                     = collect($cartItem->product->variants)->where('variant_id', $cartItem->variant_id)->first();
            $cartItem->sale_percentage   = $cartItem->product->getSalePercentageAttribute($variant);
            $cartItem->sale_price        = $cartItem->product->getSalePriceAttribute($variant);
            $cartItem->original_price    = $cartItem->variant->price + $cartItem->product->getPriceAdditionAttribute($variant);
            $cartItem->coupon_value      = 0;
            $cartItem->coupon_percentage = 0;
            $cartItem->is_online_pay_only = $cartItem->product->is_online_pay_only;
            $cartItem->is_coupon_applied = false;
            $cartItem->sale_subtotal     = round($cartItem->sale_price * $cartItem->qty);
            $cartItem->original_subtotal = round($cartItem->original_price * $cartItem->qty);
            $cartItem->subtotal          = $cartItem->sale_percentage > 0 ? $cartItem->sale_subtotal : $cartItem->original_subtotal;
            $cartItem->vat               = ($cartItem->sale_percentage > 0 ? ($cartItem->sale_price * ($cartItem->product->sub_category->vat / 100)): ($cartItem->original_price * ($cartItem->product->sub_category->vat / 100)));
            $cartItem->commission        = $cartItem->product->priceAddition;
            $cartItem->seller_id         = $cartItem->product->seller_id;
            $cartItem->variant           = $variant;
            $cartItem->category_id       = $cartItem->product->category_id;
            $cartItem->sub_category_id   = $cartItem->product->sub_category_id;
            $cartItem->child_category_id = $cartItem->product->child_category_id;
            $cartItem->is_anaz_empire    = $cartItem->product->seller->is_anazmall_seller;
            $cartItem->is_anaz_spotlight = $cartItem->product->seller->is_premium;
        }
        return $cartItem;
    }

    private function emptyCart($type = null)
    {
        if ($type == 'fake_cart') {
            session()->remove('fake_cart');
        } else {
            $cart = Cart::whereAuthUser()->first();
            $cart->update([
                'coupon' => null
            ]);
            CartItem::where('cart_id', $cart->id)->delete();
            $cart = $this->calculateCart();
            session()->put('cart', $cart);
        }
    }

    private function emptyCartAPI($user)
    {
        $cart = Cart::where('user_id',$user->id)->first();
        $cart->update([
            'coupon' => null
        ]);
        CartItem::where('cart_id', $cart->id)->delete();
        return true;
    }
}
