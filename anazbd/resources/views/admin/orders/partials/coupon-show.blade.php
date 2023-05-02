@if($order->user_coupon && $order->user_coupon->coupon && $order->user_coupon->coupon->couponExtra)
    <div class="card rounded shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col p-1 text-center rounded bg-dark text-white">
                    <h5>Coupon Details</h5>
                </div>
            </div>
            <div class="row text-center mt-2">
                <div class="col-12">
                    Coupon: {{$order->user_coupon->name}}
                </div>
                <div class="col-12">
                    Value: {{$order->user_coupon->value}}
                </div>
                <div class="col-12">
                    Minimum Amount: {{$order->user_coupon->coupon->min_amount}}
                </div>
                <hr>
                @foreach($order->user_coupon->coupon->couponExtra as $extra)
                    <div class="col-12 border border-primary border-rounded">
                        <div class="row border border-bottom">
                            <div class="col-12">
                                Coupon On: {{$extra->coupon_on}}
                            </div>
                            <div class="col-12">
                                Type: {{$extra->type}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Minimum Amount: {{$extra->min_amount}}
                            </div>
                            <div class="col">
                                Value: {{$extra->value}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
