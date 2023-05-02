<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Interfaces\Coupon\CouponInterface;
use App\Interfaces\Coupon\CouponValidityInterface;
use App\Models\Coupon;

class CouponApplyRepository implements CouponInterface{

    protected $cart;
    protected $coupon;
    private $value = 0,$permitedTotal = 0,$permittedDeliveryCharge = 0;

    public function __construct($cart,$coupon)
    {
        $this->cart = $cart;
        $this->coupon = $coupon;
    }

    public function apply()
    {
        //apply coupon value
        foreach($this->coupon->couponExtra as $index => $extra){
            if($extra->coupon_on == "delivery_charge"){
                if(($this->permitedTotal > 0 ? $this->permitedTotal : $this->cart->subtotal) >= $extra->min_amount ){
                    $value = floor($this->calculateValue($extra->type,$extra->value,$this->permittedDeliveryCharge == 0 ? $this->cart->delivery_charge : $this->permittedDeliveryCharge));
                    $this->cart->coupon_value += $value;
                }else{
                    $this->cart->error_msg = $this->coupon->error_msg;
                }
            }else{
                // dd($extra);
                $this->ApplyCouponOnItem($extra->coupon_on,$extra->couponable_id,$extra->min_amount ?? $this->coupon->min_amount,$extra->type,$extra->value);
            }
        }
        $this->substractCouponValue($this->cart->coupon_value);
        $this->cart->is_coupon_applied = true;
        return $this->cart;
    }

    private function ApplyCouponOnItem($coupon_on,$couponable_id,$min_amount,$type,$value)
    {
        switch ($coupon_on){

            case 'subtotal':
                // apply on subtotal
                if ($this->permitedTotal == 0 && $this->cart->subtotal >= $min_amount ){
                    $this->applyOnSubtotal($type,$value,$this->cart->subtotal);
                }elseif ($this->permitedTotal != 0 && $this->permitedTotal >= $min_amount){
                    $this->applyOnSubtotal($type,$value,$this->permitedTotal);
                }
                $this->setPermittedDeliveryCharge($this->cart->delivery_charge);
                return;
            case 'Category':
                // get all the items from category apply value evenly
                $permittedItems = $this->cart->cart_items->where('active',true)->filter(function($item) use($couponable_id){
                    return $item->product->category_id == $couponable_id;
                });

                // get delivery charges for permitted item and set it as permitted delivery charge
                $this->setPermittedDeliveryCharge($this->getDeliveryCharges($permittedItems));


                $total = $permittedItems->sum('subtotal');

                $this->setPermittedTotal($total);
                if($total >= $min_amount){
                    $value = $this->calculateValue($type,$value,$permittedItems->sum('subtotal'));
                // $couponValueAfterContribution = 0;
                // dump($value,$permittedItems->sum('subtotal'),$this->cart->cart_items->sum('subtotal'));
                    foreach($permittedItems as $item){
                        $contribution = 1 / (($total / 100) / $item->subtotal);
                        $item->coupon_value = floor(($value / 100 ) * $contribution);
                        // $couponValueAfterContribution = $couponValueAfterContribution + $item->coupon_value;

                        $item->is_coupon_applied = true;
                        $item->subtotal = round($item->original_subtotal - $item->coupon_value);
                        $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);
                        // if($index == 4){
                        //     dd($permittedItems->sum('subtotal'),$value,$contribution,$item->coupon_value,$item->original_subtotal,$item->subtotal);
                        // }
                    }
                    // dd($couponValueAfterContribution);
                    $this->cart->coupon_value += floor($value);
                    // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                    // $this->substractCouponValue($this->cart->coupon_value);
                }
                return;

            case 'SubCategory':

                // get all the items from sub category apply value evenly
                $permittedItems = $this->cart->cart_items->where('active',true)->filter(function($item) use($couponable_id){
                    return $item->product->sub_category_id == $couponable_id;
                });

                // get delivery charges for permitted item and set it as permitted delivery charge
                $this->setPermittedDeliveryCharge($this->getDeliveryCharges($permittedItems));

                $total = $permittedItems->sum('subtotal');
                $this->setPermittedTotal($total);
                if($total >= $min_amount){
                    $value = $this->calculateValue($type,$value,$permittedItems->sum('subtotal'));
                    // $couponValueAfterContribution = 0;
                    // dump($value,$permittedItems->sum('subtotal'),$this->cart->cart_items->sum('subtotal'));
                    foreach($permittedItems as $item){
                        $contribution = 1 / (($total / 100) / $item->subtotal);
                        $item->coupon_value = floor(($value / 100 ) * $contribution);
                        // $couponValueAfterContribution = $couponValueAfterContribution + $item->coupon_value;

                        $item->is_coupon_applied = true;
                        $item->subtotal = round($item->original_subtotal - $item->coupon_value);
                        $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);
                        // if($index == 4){
                        //     dd($permittedItems->sum('subtotal'),$value,$contribution,$item->coupon_value,$item->original_subtotal,$item->subtotal);
                        // }
                    }
                    // dd($couponValueAfterContribution);
                    $this->cart->coupon_value += floor($value);
                    // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                    // $this->substractCouponValue($this->cart->coupon_value);
                }
                return;
            case 'ChildCategory':

                // get all the items from child category apply value evenly

                $permittedItems = $this->cart->cart_items->where('active',true)->filter(function($item) use($couponable_id){
                    return $item->product->child_category_id == $couponable_id;
                });

                // get delivery charges for permitted item and set it as permitted delivery charge
                $this->setPermittedDeliveryCharge($this->getDeliveryCharges($permittedItems));

                $total = $permittedItems->sum('subtotal');
                $this->setPermittedTotal($total);
                if($total >= $min_amount){
                    $value = $this->calculateValue($type,$value,$permittedItems->sum('subtotal'));
                    // $couponValueAfterContribution = 0;
                    // dump($value,$permittedItems->sum('subtotal'),$this->cart->cart_items->sum('subtotal'));
                    foreach($permittedItems as $item){
                        $contribution = 1 / (($total / 100) / $item->subtotal);
                        $item->coupon_value = floor(($value / 100 ) * $contribution);
                        // $couponValueAfterContribution = $couponValueAfterContribution + $item->coupon_value;

                        $item->is_coupon_applied = true;
                        $item->subtotal = round($item->original_subtotal - $item->coupon_value);
                        $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);
                        // if($index == 4){
                        //     dd($permittedItems->sum('subtotal'),$value,$contribution,$item->coupon_value,$item->original_subtotal,$item->subtotal);
                        // }
                    }
                    // dd($couponValueAfterContribution);
                    $this->cart->coupon_value += floor($value);
                    // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                    // $this->substractCouponValue($this->cart->coupon_value);
                }

                return;

            case 'Item':
                // get the specific item and substract coupon value
                $item = $this->cart->cart_items->where('item_id',$couponable_id)->where('active',true)->first();
                $this->setPermittedDeliveryCharge($this->cart->is_main_location ? $item->product->delivery_size->customer_dhaka : $item->product->delivery_size->customer_dhaka);
                $this->setPermittedTotal($item->subtotal);
                if($item->subtotal >= $min_amount){
                    $value = floor($this->calculateValue($type,$value,$item->subtotal));
                    $item->coupon_value = $value;
                    $item->is_coupon_applied = true;
                    $item->subtotal = $item->original_subtotal - floor($item->coupon_value);
                    $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);

                    $this->cart->coupon_value += $value;
                    // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                    // $this->substractCouponValue($this->cart->coupon_value);
                }

                return;
            case 'Seller':

                // get all the items from seller apply value evenly
                $permittedItems = $this->cart->cart_items->where('active',true)->filter(function($item) use($couponable_id){
                    return $item->seller_id == $couponable_id;
                });
                $total = $permittedItems->sum('subtotal');

                // get delivery charges for permitted item and set it as permitted delivery charge
                $this->setPermittedDeliveryCharge($this->getDeliveryCharges($permittedItems));

                $this->setPermittedTotal($total);
                if($total >= $min_amount){
                    $value = $this->calculateValue($type,$value,$permittedItems->sum('subtotal'));
                    // $couponValueAfterContribution = 0;
                    // dump($value,$permittedItems->sum('subtotal'),$this->cart->cart_items->sum('subtotal'));
                    foreach($permittedItems as $item){
                        $contribution = 1 / (($total / 100) / $item->subtotal);
                        $item->coupon_value = floor(($value / 100 ) * $contribution);
                        // $couponValueAfterContribution = $couponValueAfterContribution + $item->coupon_value;

                        $item->is_coupon_applied = true;
                        $item->subtotal = round($item->original_subtotal - $item->coupon_value);
                        $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);
                        // if($index == 4){
                        //     dd($permittedItems->sum('subtotal'),$value,$contribution,$item->coupon_value,$item->original_subtotal,$item->subtotal);
                        // }
                    }
                    // dd($couponValueAfterContribution);
                    $this->cart->coupon_value += floor($value);
                    // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                    // $this->substractCouponValue($this->cart->coupon_value);
                }

                return;
            case 'User':
                // apply on subtotal
                $this->setPermittedTotal($this->cart->subtotal);
                $this->setPermittedDeliveryCharge($this->cart->delivery_charge);
                if($this->cart->subtotal >= $min_amount){
                    $this->applyOnSubtotal($type,$value,$this->cart->subtotal);
                }
                return;

            case 'anaz_empire':

                // get all the items from anaz empire & apply value evenly
                $permittedItems = $this->cart->cart_items->where('active',true)->filter(function($item){
                    return $item->product->seller->is_anazmall_seller == true;
                });
                $this->setPermittedTotal($permittedItems->sum('subtotal'));

                // get delivery charges for permitted item and set it as permitted delivery charge
                $this->setPermittedDeliveryCharge($this->getDeliveryCharges($permittedItems));

                if($permittedItems->sum('subtotal') >= $min_amount){
                    $value = floor($this->calculateValue($type,$value,$permittedItems->sum('subtotal')));
                    // dd($type,$value,$permittedItems->sum('subtotal'),$value);
                    $couponValueAfterContribution = 0;
                    foreach($permittedItems as   $item){
                        $contribution = floor(1 / (($permittedItems->sum('subtotal') / 100) / $item->subtotal));
                        $item->coupon_value = floor(($value / 100 ) * $contribution);
                        $couponValueAfterContribution = $couponValueAfterContribution + $item->coupon_value;
                        $item->is_coupon_applied = true;
                        $item->subtotal = $item->original_subtotal - floor($item->coupon_value);
                        $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);
                    }
                    // dd($couponValueAfterContribution);
                    $this->cart->coupon_value += floor($value);
                    // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                    // $this->substractCouponValue($this->cart->coupon_value);
                }
                return;


            case 'anaz_spotlight':

                // get all the items from anazspotlight & apply value evenly
                $permittedItems = $this->cart->cart_items->where('active',true)->filter(function($item){
                    return $item->product->seller->is_premium == true;
                });
                $this->setPermittedTotal($permittedItems->sum('subtotal'));

                // get delivery charges for permitted item and set it as permitted delivery charge
                $this->setPermittedDeliveryCharge($this->getDeliveryCharges($permittedItems));

                $value = floor($this->calculateValue($type,$value,$permittedItems->sum('subtotal')));
                $couponValueAfterContribution = 0;
                foreach($permittedItems as  $index => $item){
                    $contribution = floor(1 / (($permittedItems->sum('subtotal') / 100) / $item->subtotal));
                    $item->coupon_value = floor(($value / 100 ) * $contribution);
                    $couponValueAfterContribution = $couponValueAfterContribution + $item->coupon_value;
                    $item->is_coupon_applied = true;
                    $item->subtotal = $item->original_subtotal - floor($item->coupon_value);
                    $item->coupon_percentage = round((($item->original_subtotal - $item->subtotal) / $item->original_subtotal) * 100);
                    // if($index == 4){
                    //     dd($permittedItems->sum('subtotal'),$value,$contribution,$item->coupon_value,$item->original_subtotal,$item->subtotal);
                    // }
                }
                $this->cart->coupon_value += floor($value);
                // $this->cart->subtotal = $this->cart->subtotal - $this->cart->coupon_value;
                // $this->substractCouponValue($this->cart->coupon_value);
                return;
            case 'Location':
                // apply on subtotal
                if ($this->permitedTotal == 0){
                    $this->applyOnSubtotal($type,$value,$this->cart->subtotal);
                }elseif ($this->permitedTotal != 0 && $this->permitedTotal >= $min_amount){
                    $this->applyOnSubtotal($type,$value,$this->cart->subtotal);
                }
                $this->setPermittedDeliveryCharge($this->cart->delivery_charge);
                return;
            default:
                return false;
        }
    }

    private function calculateValue($type = "percent",$value,$amount)
    {
        return $type == "percent" ? ($amount * ($value/100)) : $value;
    }
    private function applyOnSubtotal($type,$value,$subtotal)
    {
        $this->setPermittedTotal($subtotal);
        $value = round($this->calculateValue($type,$value,$subtotal));
        $this->cart->coupon_value += $value;
        // $this->substractCouponValue($value);
    }
    private function substractCouponValue($value){
        $this->cart->total_dhaka = $this->cart->total_dhaka - $value;
        $this->cart->total_other = $this->cart->total_other - $value;
        $this->cart->subtotal = $this->cart->subtotal - $value;
        $this->cart->total = $this->cart->total - $value;
    }

    private function setPermittedTotal($subtotal){
        if ($this->permitedTotal == 0){
            $this->permitedTotal = $subtotal;
        }
    }

    private function setPermittedDeliveryCharge($delivery_charge){
        if ($this->permittedDeliveryCharge < $delivery_charge){
            $this->permittedDeliveryCharge = $delivery_charge;
        }
    }

    private function getDeliveryCharges($items){
        $deliveryCharge = 0;
         foreach ($items as $item){
             $itemDeliveryCharge = ($this->cart->is_main_location ?? false) ? $item->product->delivery_size->customer_dhaka : $item->product->delivery_size->customer_other;
             if ($deliveryCharge < $itemDeliveryCharge){
                 $deliveryCharge = $itemDeliveryCharge;
             }
         }
         return $deliveryCharge;
    }

}
