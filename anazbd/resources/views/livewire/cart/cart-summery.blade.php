<div class="col-4 " style="padding-left: 0;">
    <div class="row summary-div">
        <p class="summary">Cart Summary</p>
        <p class="">

{{--            <div class="row ">--}}
{{--                @if ($summery['subtotal_without_coupon'] > 0)--}}
{{--                    <div class="col py-1 ">--}}
{{--                        <input type="text" style="border:0px;border-bottom:1px solid coral;" class="w-100" placeholder="Enter Coupon" wire:model="coupon">--}}
{{--                    </div>--}}
{{--                    <div class="col-2 py-1">--}}
{{--                        <button type="button" wire:click.prevent="applyCoupon" class="btn btn-sm" style="background-color: coral">Apply</button>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--            </div>--}}
        </p>
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Subtotal ({{ $summery['activeCount'] }} items)
            </span>
            <span class="pull-right text-info">
                {{ round($summery['subtotal_without_coupon'] ) }} &#2547;
            </span>
        </p>
{{--        <p class="border-bottom">--}}
{{--            <span class="pull-left font-weight-bold">--}}
{{--                Estimated Delivery Charge <br>--}}
{{--            </span>--}}

{{--            <span class="pull-right text-info">--}}
{{--                {{ $summery['delivery_charge'] }} &#2547;--}}
{{--            </span>--}}
{{--        </p>--}}
        <p class="border-bottom">
            <span class="pull-left font-weight-bold">
                Total
            </span>
            <span class="pull-right text-info">
                {{ $summery['subtotal_without_coupon'] }} &#2547; <br>
            </span>

        </p>

{{--        <p class="border-bottom">--}}
{{--            <span class="pull-left font-weight-bold">--}}
{{--                Coupon Discount--}}
{{--            </span>--}}
{{--            <span class="pull-right text-danger">--}}
{{--                -{{$summery['coupon_value']}} &#2547;--}}
{{--            </span>--}}
{{--        </p>--}}
{{--        @if($summery["coupon"] != null && $summery["coupon_value"] > 0)--}}
{{--        <p class="border-bottom">--}}
{{--            <span class="pull-left font-weight-bold">--}}
{{--                Coupon: {{ $summery["coupon"] }}<br>--}}
{{--            </span>--}}

{{--            <span class="badge badge-success pull-right">--}}
{{--                <i class="fa fa-check"></i>--}}
{{--            </span>--}}
{{--        </p>--}}
{{--        @endif--}}
{{--        <p class="border-bottom">--}}
{{--            <span class="pull-left font-weight-bold">--}}
{{--                Grand Total--}}
{{--            </span>--}}
{{--            <span class="pull-right text-success">--}}
{{--                {{$summery['total']}} &#2547; <br>--}}
{{--            </span>--}}

{{--        </p>--}}
        @if ($summery['subtotal_without_coupon'] > 0)
            <div class="summary-checkout">
                <a href="{{ route('frontend.checkout.index') }}" type="button" class="checkout-btn">Proceed to Checkout</a>
            </div>
        @endif
    </div>
</div>
