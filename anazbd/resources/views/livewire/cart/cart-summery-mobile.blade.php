<div class="row card p-2 mt-3">
    <style>
        ::placeholder{
            font-size: 8pt;
        }
    </style>
    <div class="row p-3">
        <h4>Summery</h4>
        <div class="border-bottom">

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
        </div>
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
{{--        <small class="text-muted text-right" style="font-size: 8pt;"><span class="text-danger">*</span> Vat Included</small>--}}
        @if ($summery['subtotal_without_coupon'] > 0)
            <div class="mt-3 mb-4">
                <a href="{{ route('frontend.checkout.index') }}" type="button" class="btn btn-danger btn-block">Proceed to Checkout</a>
            </div>
        @endif
    </div>
</div>
