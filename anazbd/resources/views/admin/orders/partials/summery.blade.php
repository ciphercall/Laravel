@isset($chalan)
    <div class="card rounded shadow-sm">
        <div class="card-body">
            <div class="col-12 bg-dark rounded">
                <h4 class="text-white text-center p-2">Summery</h4>
            </div>
            @php
                $value = $chalan->order->user_coupon != null ? $chalan->order->user_coupon->value : 0;
            @endphp
            <div class="col-12 text-center">
                <table class="table table-bordered">
                    <tr>
                        <td>Subtotal</td>
                        <td>{{ $chalan->subtotal }} Tk</td>
                    </tr>
                    <tr>
                        <td>Delivery Charge</td>
                        <td><input type="text" name="shipping_charge" value="{{ $chalan->order->shipping_charge }}"class="form-control"> Tk</td>
                    </tr>
                    <tr>
                        <td>Vat</td>
                        <td>{{ $chalan->order->vat ?? 0 }} Tk</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{ $chalan->subtotal }} Tk</td>
                    </tr>
                    <tr>
                        <td>Coupon Discount</td>
                        <td>{{ $value }} Tk</td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td>{{ $chalan->total }} Tk</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
@else
    <div class="card rounded shadow-sm">
        <div class="card-body">
            <div class="col-12 bg-dark rounded">
                <h4 class="text-white text-center p-2">Summery</h4>
            </div>
            @php
                $value = $order->user_coupon != null ? $order->user_coupon->value : 0;
            @endphp
            <div class="col-12 ">
                <table >
                    <tr class="border-bottom">
                        <td>Payment Status</td>
                        <td>{{ $order->payment_status }}</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>Subtotal</td>
                        <td>{{ $order->subtotal }} Tk</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>Delivery Charge (TK)</td>
                        <td><input type="text" name="shipping_charge" value="{{ $order->shipping_charge }}"class="form-control"></td>
                    </tr>
                    <tr class="border-bottom">
                        <td>Vat</td>
                        <td>{{ $order->vat ?? 0 }} Tk</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>Total</td>
                        <td>{{ (($order->vat ?? 0) + $order->subtotal + $order->shipping_charge) }} Tk</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>Coupon Discount</td>
                        <td>{{ $value }} Tk</td>
                    </tr>
                    <tr class="border-bottom">
                        <td>Grand Total</td>
                        <td>{{ $order->total }} Tk</td>
                    </tr>
                    @if($order->partial_payment)
                        <tr class='text-success border-bottom'>
                            <td>Paid</td>
                            <td>{{ $order->partial_payment_amount }} Tk</td>
                        </tr>
                        <tr>
                            <td class='text-danger  border-bottom'>Remaining</td>
                            <td>{{ $order->total - $order->partial_payment_amount }} Tk</td>
                        </tr>
                    @endif
                    
                </table>

            </div>
        </div>
    </div>
@endisset

