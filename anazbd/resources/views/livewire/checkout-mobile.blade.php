
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
                        <div class="row bg-white my-2 pb-2 pr-2 shadow-sm rounded">
                            <div class="col-5">
                                <img class="row rounded pt-2 m-auto" style="width: 100px !important; height: auto !important;" src="{{asset($cartItem->product->feature_image)}}" alt="">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-12 mb-1" style="height: 50px !important;">
                                        <p style="font-size: 9pt">
                                            <b>
                                                <a class="" href="{{ route('frontend.product',$cartItem->product->slug) }}">{{Str::limit($cartItem->product->name,40)}}</a>
                                            </b>

                                        </p>
                                    </div>
                                    {{--  <div class="col-12">
                                        <p class="">
                                            Price: {{ }}
                                        </p>
                                    </div>  --}}
                                    <div class="col">
                                        <div class="row pl-3">
                                            QTY: {{ $cartItem->qty }}
                                        </div>
                                        <div class="col price">

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


                                        </div>
                                        @if($cartItem->is_online_pay_only)
                                            <div class="row pt-1">
                                                <small style="font-size: 8pt;" class="text-muted">This item supports online payment only.</small>
                                            </div>
                                        @endif
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
                        @if ($loop->last && array_key_exists($shop_name,$deliveryBreakdown))
                            <div class="row bg-white mb-2 shadow-sm rounded" >
                                <div class="col text-right text-muted" style="font-size: 9pt;">Delivery Charge For {{ $shop_name }}: {{$deliveryBreakdown[$shop_name]}}</div>
                            </div>
                        @endif
                @endforeach
                </div>
            </div>
            @endforeach
            @if (array_key_exists($collectionKey,$deliveryBreakdown))
                <div class="row">
                    <div class="col text-right text-muted" style="font-size: 9pt;">Delivery Charge For Anaz Empire: {{$deliveryBreakdown[$collectionKey]}}</div>
                </div>
            @endif
        @endforeach
        <div class="form-group my-3">
            <label for="">Extra Instructions</label>
            <textarea name="note" class="form-control" placeholder="পণ্য সংক্রান্ত নির্দেশনাবলি লিখুন" wire:model.debounce.500ms="note" cols="30" rows="3"></textarea>
        </div>
            <div class="card rounded shadow-sm mb-2">
                <div class="row bg-danger rounded text-center">
                    <h5 class="text-white ">Summery</h5>
                </div>
                <div class="card-body row">
                    <p class="border-bottom">
                        @if($userRedeems->count() > 0)
                            <p class="border-sm">
                                <div class="row ">
                                    <div class="col py-1 ">
                                        <input type="text" style="border:0px;border-bottom:1px solid coral;" class="w-100"
                                            placeholder="Enter Redeem Code" wire:model="redeem">
                                            <small style="font-size: 9px;" class="text-muted">You have {{$userRedeems->count()}} redeem available.</small>
                                    </div>
                                    <div class="col-2 py-1">
                                        <button type="button" wire:click.prevent="applyRedeem" class="btn btn-sm"
                                                style="background-color: coral">Apply
                                        </button>
                                    </div>
                                </div>
                            </p>
                        @endif
                    <div class="row ">
                        @if ($summery['subtotal_without_coupon'] > 0)
                            <div class="col py-1 ">
                                <input type="text" style="border:0px;border-bottom:1px solid coral;" class="w-100" placeholder="Enter Coupon" wire:model="coupon">
                            </div>
                            <div class="col-2 py-1">
                                <button type="button" wire:click.prevent="applyCoupon" class="btn btn-sm" style="background-color: coral">Apply</button>
                            </div>
                        @endif
                    </div>
                    </p><br>
                <p class="border-bottom">
                    <span class="pull-left font-weight-bold">
                        Subtotal ({{ $summery['activeCount'] }} items)
                    </span>
                    <span class="pull-right text-info">
                        {{ round($summery['subtotal_without_coupon'] ) }} &#2547;
                    </span>
                </p>
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Estimated Delivery Charge <br>
            </span>

            <span class="pull-right text-info">
                {{ $summery['delivery_charge'] }} &#2547;
            </span>
        </p>
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Total
            </span>
            <span class="pull-right text-info">
                {{ $summery['subtotal'] + $summery['delivery_charge'] + $summery['coupon_value'] }} &#2547; <br>
            </span>

        </p>
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Coupon Discount
            </span>
            <span class="pull-right text-danger">
                -{{$summery['coupon_value']}} &#2547;
            </span>
        </p>
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Redeem Discount
            </span>
            <span class="pull-right text-danger">
                -{{$summery['redeem_value']}} &#2547;
            </span>
        </p>
        @if($summery["redeem"] != null && $summery["redeem_value"] > 0)
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Redeem: {{ $summery["redeem"] }}<br>
            </span>

            <span class="badge badge-success pull-right">
                <i class="fa fa-check"></i>
            </span>
        </p>
        @endif
        @if($summery["coupon"] != null && $summery["coupon_value"] > 0)
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Coupon: {{ $summery["coupon"] }}<br>
            </span>

            <span class="badge badge-success pull-right">
                <i class="fa fa-check"></i>
            </span>
        </p>
        @endif
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Grand Total
            </span>
            <span class="pull-right text-success">
                {{$summery['total']}} &#2547; <br>
            </span>

        </p>
                </div>
            </div>
            <form action="{{ route('frontend.checkout.pay_online') }}" method="POST" class="col-12 my-1">
                @csrf
                <button id="btn_pay_online" class="btn btn-block btn-primary">Pay Online {{ $summery['total'] }} ৳</button>
            </form>
            @if($summery['partial_payment'] )
                        <form action="{{ route('frontend.checkout.pay_partial') }}" method="POST"
                                class="col-12 my-1">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $summery['partial_payment_amount'] }}">
                            <button class="btn btn-block btn-success">Pay Online {{ $summery['partial_payment_amount'] }} ৳</button>
                            <small class="text-muted" style="font-size: 9px">You need to pay minimum {{ $summery['partial_payment_amount'] }} ৳ to order.</small>
                        </form>
                    @endif
            @if(!$summery['partial_payment'] )
                {{--  @if($summery['is_main_location'])  --}}
                @if($config->is_cod_enabled)
                    <form action="{{ route('frontend.checkout.cash_on_delivery') }}" method="POST"
                          class="col-12 my-1">
                        @csrf
                        <button id="btn_cash_on_delivery" class="btn btn-block btn-warning">Cash On Delivery</button>
                    </form>
                @endif
            @endif
        </div>

    </div>
</div>
