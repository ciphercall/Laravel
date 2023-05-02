
<div class="">
    <style>
        .deleteBtn{
            position: relative;
            top: -15px;
            left: 26px;
        }
    </style>
    <div class="row card p-2 bg-light">
        <div class="card-body">
        @foreach ($GroupedItems as $collectionKey => $collectionGroup)
            <div class="row">
                <div class="col bg-dark rounded text-center p-2">
                    <h3 class="text-white ">{{ $collectionKey }}</h3>
                </div>
            </div>
            @foreach($collectionGroup as $shop_name => $group)
            <div class="row border-primary">
                <div class="col-12 py-2 bg-white rounded text-center">
                    <b>{{ $shop_name }}</b>
                </div>
                <hr>
                <div class="col">
                    @foreach($group as $cartItem)
                        {{--  @livewire('cart.cart-item',['isMobile'=>$isMobile, 'cartItem'=>$cartItem])  --}}
                        <div class="row bg-white my-2 pb-2 pr-2 shadow-sm rounded">
                            <div class="" style="height: 0px;">
                                <button type="button" wire:click="deleteItem('{{ az_hash($cartItem->id) }}')"  class="close pull-right deleteBtn" aria-label="Close">
                                    <h2><span aria-hidden="true">&times;</span></h2>
                                  </button>
                            </div>
                            <div class="col-5">
                                <img class="row rounded pt-2 m-auto" style="width: 100px !important; height: auto !important;" src="{{asset($cartItem->product->feature_image)}}" alt="">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-12" style="height: 50px !important;">
                                        <p style="font-size: 10pt"><b><a class="" href="{{ route('frontend.product',$cartItem->product->slug) }}">{{Str::limit($cartItem->product->name,40)}}</a></b></p>
                                    </div>
                                    <div>

                                        <del class="text-danger ">
                                            @if($cartItem->sale_percentage || $cartItem->is_coupon_applied)
                                                {{$cartItem->original_subtotal}}&#2547;
                                            @endif
                                        </del>
                                        <p class="text-info">
                                            @if($cartItem->sale_percentage)
                                                {{ $cartItem->sale_subtotal }} &#2547;
                                            @elseif($cartItem->is_coupon_applied)
                                                {{ $cartItem->subtotal }} &#2547;
                                            @elseif($cartItem->original_price)
                                                {{$cartItem->original_subtotal}} &#2547;
                                            @else
                                            &mdash;
                                            @endif
                                        </p>

                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-2">
                                                @if($cartItem->qty > 1)
                                                    <button class="btn btn-sm rounded-sm btn-outline-info active shadow-sm" wire:click="decreaseQty('{{ az_hash($cartItem->id) }}')"><i class="fa fa-minus"></i></button>
                                                @else
                                                    <button class="btn btn-sm rounded-sm btn-outline-info shadow-sm" disabled><i class="fa fa-minus"></i></button>
                                                @endif
                                            </div>
                                            <div class="col-2 offset-2">
                                                <p class="text-muted">{{ $cartItem->qty }}</p>
                                            </div>
                                            <div class="col-2">
                                                @if($cartItem->qty < $cartItem->product->max_orderable_qty)
                                                    <button class="btn btn-sm rounded-sm btn-outline-info active shadow-sm" wire:click="increaseQty('{{ az_hash($cartItem->id) }}')"><i class="fa fa-plus"></i></button>
                                                @else
                                                    <button class="btn btn-sm rounded-sm btn-outline-info shadow-sm" disabled><i class="fa fa-plus"></i></button>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row pt-2">
                                            @if($cartItem->sale_percentage)
                                                <p style="font-size: 8pt" class="text-danger text-right">You Saved {{ ($cartItem->original_subtotal - $cartItem->subtotal ) }} &#2547;</p>
                                            @elseif($cartItem->is_coupon_applied)
                                                <p style="font-size: 8pt" class="text-danger text-right">You Saved {{ ($cartItem->original_subtotal - $cartItem->subtotal ) }} &#2547;</p>
                                            @else

                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
{{--                        @if ($loop->last && array_key_exists($shop_name,$deliveryBreakdown))--}}
{{--                            <div class="row bg-white mb-2 shadow-sm rounded" >--}}
{{--                                <div class="col text-right text-muted" style="font-size: 9pt;">Delivery Charge For Anaz Empire: {{$deliveryBreakdown[$shop_name]}}</div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    @endforeach
                    </div>
                </div>
                @endforeach
{{--                @if (array_key_exists($collectionKey,$deliveryBreakdown))--}}
{{--                    <div class="row">--}}
{{--                        <div class="col text-right text-muted" style="font-size: 9pt;">Delivery Charge For Anaz Empire: {{$deliveryBreakdown[$collectionKey]}}</div>--}}
{{--                    </div>--}}
{{--                @endif--}}
            @endforeach
        </div>
    </div>
</div>




