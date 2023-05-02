
<div class="col-8 item-area" style="padding-right: 0">
    @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    @foreach ($GroupedItems as $collectionKey => $collectionGroup)
        <!-- SELECT ALL -->
        <div class="cart-area row">
            <div class="select-all-div">
                <div class="select-all">
                    {{--  <input type="checkbox" id="select-all">
                    <label for="select-all">Select All</label>  --}}
                </div>
                <div>
                    <h4>{{ $collectionKey }}</h4>
                </div>
                <div>
                    {{--  <a class="remove-all" href="#"><i class="fa fa-trash"></i>Delete</a>  --}}
                </div>
            </div>
        </div>

        @foreach($collectionGroup as $shop_name => $group)
            <div class="cart-area row seller-div">
                <div class="seller-items">
                    <div class="seller-header">
                        <div class="left">
                            {{--  <input type="checkbox" id="shop-checkbox-{{$loop->iteration}}"
                                class="seller-checkbox">  --}}
                            <label for="shop-checkbox-{{$loop->iteration}}">{{$shop_name }}</label>
                        </div>
                    </div>
                    <table>
                        <tbody>
                        @foreach($group as $cartItem)
                        <tr class="item-row">
                            {{--  <td>
                                <input type="checkbox" wire:click.prevent="{{ $cartItem->active ? 'deactivateItem' : 'activateItem'}}('{{ az_hash($cartItem->id) }}')"
                                    class="item-checkbox" {{ $cartItem->active ? 'checked=checked' : ''}}>
                            </td>  --}}
                            <td></td>
                            <td>
                                <img src="{{asset($cartItem->product->feature_image)}}" alt="">
                            </td>
                            <td>
                                <div class="details">
                                    <p>
                                        <a class="item-name"
                                        href="{{route('frontend.product', $cartItem->product->slug)}}">
                                            {{$cartItem->product->name}}
                                        </a>
                                    </p>
                                    <p>
                                        @if($cartItem->variant)
                                            @if($cartItem->variant->color)
                                                {{'Color: '.$cartItem->variant->color->name}}
                                            @endif
                                            @if($cartItem->variant->size)
                                                {{'Color: '.$cartItem->variant->size->name}}
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </td>
                            <td>
                                @if ($cartItem->active)
                                    <div class="price">
                                        <p class="last-price">
                                            @if($cartItem->sale_percentage)
                                                {{ $cartItem->sale_subtotal }} TK
                                            @elseif($cartItem->is_coupon_applied)
                                                {{ $cartItem->subtotal }} TK
                                            @elseif($cartItem->original_price)
                                                {{$cartItem->original_subtotal}} TK
                                            @else
                                            &mdash;
                                            @endif
                                        </p>
                                        <p class="original-price">
                                            @if($cartItem->sale_percentage || $cartItem->is_coupon_applied)
                                                {{$cartItem->original_subtotal}} TK
                                            @endif
                                        </p>
                                        <p class="percentage">
                                            @if($cartItem->sale_percentage)
                                                -{{$cartItem->sale_percentage}}%
                                            @endif
                                            @if($cartItem->is_coupon_applied)
                                                -{{ ($cartItem->coupon_percentage ) }}%
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="counter" data-item="{{$cartItem->id}}">
                                    @if($cartItem->qty > 1)
                                        <button class="counter-decrease" wire:click="decreaseQty('{{ az_hash($cartItem->id) }}')">&mdash;</button>
                                    @else
                                        <button class="counter-decrease" disabled>&mdash;</button>
                                    @endif
                                    <p class="couter-input p-4">{{ $cartItem->qty }}</p>
                                    @if($cartItem->qty < $cartItem->product->max_orderable_qty)
                                        <button class="counter-increase" wire:click="increaseQty('{{ az_hash($cartItem->id) }}')">+</button>
                                    @else
                                        <button class="counter-increase">+</button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="btn btn-sm btn-danger" wire:click.prevent="deleteItem('{{ az_hash($cartItem->id) }}')"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                            {{--  @livewire('cart.cart-item',['isMobile'=>$isMobile, 'cartItem'=>$cartItem])  --}}
                        @endforeach
                        </tbody>
                    </table>
{{--                    @if (array_key_exists($shop_name,$deliveryBreakdown))--}}
{{--                        <div class="bg-white">--}}
{{--                            <div class="col text-right text-muted">Delivery Charge For {{ $shop_name }}: {{$deliveryBreakdown[$shop_name]}}</div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>
        @endforeach
{{--        @if (array_key_exists($collectionKey,$deliveryBreakdown))--}}
{{--            <div class="cart-area row seller-div">--}}
{{--                <div class="col text-right text-muted">Delivery Charge For Anaz Empire: {{$deliveryBreakdown[$collectionKey]}}</div>--}}
{{--            </div>--}}
{{--        @endif--}}
    @endforeach

</div>


