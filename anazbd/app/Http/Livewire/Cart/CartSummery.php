<?php

namespace App\Http\Livewire\Cart;

use App\Models\Cart;
use App\Models\Coupon;
use App\Traits\CalculateCart;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class CartSummery extends Component
{
    use CalculateCart;

    public $summery = [];
    public $coupon;

    protected $listeners = [
        "itemChanged" => "updateSummery"
    ];
    public  function mount()
    {
        $cart = $this->calculateCart();
        if($cart){
            $this->summery['subtotal_without_coupon'] = $cart->subtotal_without_coupon;
            $this->summery['subtotal'] = $cart->subtotal;
            $this->summery['activeCount'] = $cart->activeCount;
            $this->summery['delivery_charge'] = $cart->delivery_charge;
            $this->summery['total'] = $cart->total;
            $this->summery['coupon_value'] = $cart->coupon_value;
            $this->summery['coupon'] = $cart->coupon;
            $this->coupon = $cart->coupon;
        }else{
            $this->summery['subtotal_without_coupon'] = 0;
            $this->summery['subtotal'] = 0;
            $this->summery['activeCount'] = 0;
            $this->summery['delivery_charge'] = 0;
            $this->summery['total'] = 0;
            $this->summery['coupon_value'] = 0;
            $this->summery['coupon'] = 0;
        }
    }

    public function render()
    {
        $agent = new Agent();
        if($agent->isMobile()){
            return view('livewire.cart.cart-summery-mobile');
        }
        return view('livewire.cart.cart-summery');
    }

    public function applyCoupon()
    {
        Cart::whereAuthUser()->first()->update([
            'coupon' => $this->coupon
        ]);
        $this->coupon = "";
        $this->emit('refresh');
    }

    public function updateSummery($summery){
        $this->summery = $summery;
        // if($summery['coupon'] && $summery['coupon_value'] > 0){
        //     $this->dispatchBrowserEvent('alert',['type' => 'success','message' => 'coupon applied']);
        // }elseif($summery['coupon']){
        //     $this->dispatchBrowserEvent('alert',['type' => 'error','message' => 'No coupon applied']);
        // }
    }
}
