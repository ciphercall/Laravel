<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\PointRedeem;
use App\SiteConfig;
use App\Temp;
use App\Traits\CalculateCart;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class Checkout extends Component
{
    use CalculateCart;

    public $GroupedItems, $config, $note, $summery,$deliveryBreakdown = [],$coupon , $message = [
        'success' => null,
        'error' => null
    ];

    public $redeem, $userRedeems;

    protected $listeners = [
        'addressUpdated' => '$refresh',
        'refresh' => '$refresh',
        'couponApplied',
    ];

    public function mount()
    {
        $this->config = SiteConfig::first();
        $this->userRedeems = PointRedeem::where('user_id',auth()->id())->where('status','active')->get();
    }

    public function render()
    {
        $this->recalculateCart();
        $this->noteUpdate();
        $agent = new Agent();
        if($agent->isMobile()){
            return view('livewire.checkout-mobile');
        }
        return view('livewire.checkout');
    }

    public function noteUpdate()
    {
        // dd($this->note);
        // add Temp Note
        Temp::updateOrCreate([
            'user_id' => auth('web')->id() == null ? auth('api')->id() : auth('web')->id(),
        ],[
            'note' => $this->note
        ]);
    }

    public function applyRedeem()
    {
        Cart::whereAuthUser()->first()->update([
            'redeem' => $this->redeem
        ]);
        $this->redeem = "";
        $this->emitSelf('couponApplied');
    }

    private function recalculateCart()
    {
        $this->GroupedItems = [];
        $cart = $this->calculateCart();
        if($cart){
            $this->deliveryBreakdown = $cart->deliveryBreakdown;
            $this->updateSummery($cart);
            $this->message['success'] = $cart->coupon_success_msg != null ? $cart->coupon_success_msg : $cart->redeem_success_msg;
            $this->message['error'] = $cart->coupon_error_msg != null ? $cart->coupon_error_msg : $cart->redeem_error_msg;
            foreach($cart->cart_items as $item){
                if($item->seller->is_anazmall_seller){
                    $key = "Anaz Empire";
                }else if($item->seller->is_premium){
                    $key = "Anaz Spotlight";
                }else{
                    $key = "Other Sellers";
                }
                $this->GroupedItems[$key][$item->seller->shop_name][] = $item;
            }
        }else{
            $this->dispatchBrowserEvent('redirectHome');
            $this->summery['subtotal'] = 0;
            $this->summery['subtotal_without_coupon'] = 0;
            $this->summery['activeCount'] = 0;
            $this->summery['delivery_charge'] = 0;
            $this->summery['total'] = 0;
            $this->summery['coupon_value'] = 0;
            $this->summery['coupon'] = 0;
            $this->summery['redeem'] = null;
            $this->summery['redeem_value'] = 0;
            $this->summery['is_main_location'] = false;
            $this->summery['partial_payment'] = false;
            $this->summery['partial_payment_amount'] = 0;
        }

    }

    public function applyCoupon()
    {
        Cart::whereAuthUser()->first()->update([
            'coupon' => $this->coupon
        ]);
        $this->emitSelf('couponApplied');
    }

    public function couponApplied()
    {
        if($this->message['success'] != null){
            $this->dispatchBrowserEvent('alert',['type' => "success",  'message' => $this->message['success']]);
        }else if($this->message['error'] != null){
            $this->dispatchBrowserEvent('alert',['type' => "error",  'message' => $this->message['error']]);
        }
        $this->emitSelf('refresh');
    }

    private function updateSummery($cart)
    {
        $this->summery['is_main_location'] = $cart->is_main_location;
        $this->summery['subtotal'] = $cart->subtotal;
        $this->summery['subtotal_without_coupon'] = $cart->subtotal_without_coupon;
        $this->summery['activeCount'] = $cart->activeCount;
        $this->summery['delivery_charge'] = $cart->delivery_charge;
        $this->summery['total'] = $cart->total;
        $this->summery['coupon_value'] = $cart->coupon_value;
        $this->summery['coupon'] = $cart->coupon;
        $this->summery['redeem'] = $cart->redeem;
        $this->summery['redeem_value'] = $cart->redeem_value;
        $this->summery['is_online_pay_only'] = $cart->is_online_pay_only;
        $this->summery['partial_payment'] = $cart->partial_payment;
        $this->summery['partial_payment_amount'] = $cart->partial_payment_amount;
    }
}
