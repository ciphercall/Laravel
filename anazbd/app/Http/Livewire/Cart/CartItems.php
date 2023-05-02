<?php

namespace App\Http\Livewire\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Traits\CalculateCart;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class CartItems extends Component
{
    use CalculateCart;

    public $GroupedItems = [], $summery = [], $deliveryBreakdown = [], $isMobile = false;

    protected $listeners = [
        'refresh' => 'couponApplied',
        'cartItemChanged' => 'couponApplied',
        'redirectHome'
    ];

    public function render()
    {
        $this->recalculateCart();
        $agent = new Agent();
        if($agent->isMobile()){
            return view('livewire.cart.cart-items-mobile');
        }
        return view('livewire.cart.cart-items');
    }

    public function redirectHome()
    {
        return redirect('/');
    }
    public function increaseQty($id)
    {
        $item = CartItem::find(az_unhash($id));
        if($item->product->max_orderable_qty > $item->qty){
            $item->qty += 1;
            $item->save();
            $this->recalculateCart();
            $this->emitItemChanged();
            return;
        }
        $this->emitItemChanged("error","Maximum Order Quantity Reached");
    }

    public function decreaseQty($id)
    {
        $item = CartItem::find(az_unhash($id));
        if($item->qty > 1){
            $item->qty -= 1;
            $item->save();
            $this->recalculateCart();
            $this->emitItemChanged();
            return;
        }
        $this->emitItemChanged("error","Minimum Order Quantity Reached");
    }

    public function deleteItem($id)
    {
        CartItem::find(az_unhash($id))->delete();
        $this->recalculateCart();
        $this->emitItemChanged();
        $this->dispatchBrowserEvent('update_cart_count',['count' => $this->summery["activeCount"]]);
//        $cart = $this->calculateCart();
//        if($cart == null){
//            $this->emptyCart();
//            $this->emit('redirectHome');
//        }else{
//            session()->flash('success', 'Item Deleted From Cart.');
//            $this->emitItemChanged();
//        }
    }

    public function couponApplied()
    {
        $this->recalculateCart();
        if($this->successMessages != null){
            $this->dispatchBrowserEvent('alert',['type' => "success",  'message' => $this->successMessages]);
        }elseif($this->errorMessages != null){
            $this->dispatchBrowserEvent('alert',['type' => "error",  'message' => $this->errorMessages]);
        }
        $this->emit('itemChanged',$this->summery);
        // $this->emitItemChanged();
    }

    private function recalculateCart()
    {
        $this->GroupedItems = [];
        $cart = $this->calculateCart();
        if($cart != null){
            $this->deliveryBreakdown = $cart->deliveryBreakdown;
            $this->updateSummery($cart);
            $this->successMessages = $cart->coupon_success_msg;
            $this->errorMessages = $cart->coupon_error_msg;
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
            $this->summery['subtotal'] = 0;
            $this->summery['subtotal_without_coupon'] = 0;
            $this->summery['activeCount'] = 0;
            $this->summery['delivery_charge'] = 0;
            $this->summery['total'] = 0;
            $this->summery['coupon_value'] = 0;
            $this->summery['coupon'] = 0;
        }

    }
    private function updateSummery($cart)
    {
        $this->summery['subtotal'] = $cart->subtotal;
        $this->summery['subtotal_without_coupon'] = $cart->subtotal_without_coupon;
        $this->summery['activeCount'] = $cart->activeCount;
        $this->summery['delivery_charge'] = $cart->delivery_charge;
        $this->summery['total'] = $cart->total;
        $this->summery['coupon_value'] = $cart->coupon_value;
        $this->summery['coupon'] = $cart->coupon;
    }
    private function emitItemChanged($type = "success",$message = 'Item Updated'){

        $this->emit('itemChanged',$this->summery);
        $this->dispatchBrowserEvent('alert',['type' => $type,  'message' => $message]);
    }
}
