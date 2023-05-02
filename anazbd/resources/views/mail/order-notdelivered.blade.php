<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Your Anaz Order</title>
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
        }

        body {
            background-color: #fff;
            margin: auto;
        }

        .container {
            max-width: 600px;
            margin: auto;
            display: flex;
            flex-direction: column;
            background-color: rgb(241, 245, 248);
            padding: 20px;
        }

        .logo {
            width: 217px;
            height: 67px;
            margin: auto;
        }

        .title {
            display: inline-block;
            font-size: 30px;
            letter-spacing: 1px;
            font-weight: bold;
            text-align: center;
            color: #555;
            padding: 30px;
        }

        p {
            padding: 10px;
            color: #777;
            line-height: 1.4rem;
        }

        .box {
            background-color: #fff;
        }

        .footer {
            font-size: 0.8rem;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>

@php
    $cartItemGroup = collect($order->items)->groupBy(function ($cartItem){
        return $cartItem->seller->shop_name;
    });
@endphp

<body>
{{--  <div class="container">
    <img src="{{asset('frontend/assets/anazlogo.png')}}" class="logo" alt="logo">

    <p class="title">Hi {{$name}}!</p>

    <div class="container box">
        <p>
            Sorry, Your order #{{$order_no}} has been cancelled.
            <br>
            Thank you for shopping with us!
        </p>
    </div>

    <p class="footer"></p>
</div>  --}}


<div style="width: 800px;">
    <div>
        <div class="backgroundOrder" style="background-image: url('https://drive.google.com/uc?export=download&id=1ercu3-4rZuv2Qf0NZ76lWGRgOCgR9jH0');height: 211px;background-repeat: no-repeat;background-size: contain;">
            <img src="https://drive.google.com/uc?export=download&id=1BoZ3imbvQx6CO0v8ZiD6LpfQjwQUU5Wj" height="40px" style="margin-top: 38px;margin-left: 79px;">
        </div>
    </div>
    <div>
        <p>
            <h3>Hi {{ $name }}!</h3>
        </p>
        <p style="padding:0;">
            Unfortunately, Your order #{{ $order_no }} has been failed to deliver. We are sorry for this. Please, try again or contact with our customer support team for more details.
        </p>
    </div>
    <div>
        <span class="col-12">
            Regards,
        </span>
        <span class="col-12">
            AnazBD Team.
        </span>
    </div>
</div>
@foreach($cartItemGroup as $shop_name => $group)
<table style="width:800px;margin-top: 25px;">
    <tr style="font-size: 14px;">
        <td colspan="2">
            <strong>By {{ $shop_name }}</strong>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Image</strong>
        </td>
        <td>
            <strong>Item</strong>
        </td>
        <td>
            <strong>Price</strong>
        </td>
        <td>
            <strong>QTY</strong>
        </td>
        <td>
            <strong>Price * QTY</strong>
        </td>
    </tr>
    @foreach($group as $item)
    <tr>
        <td>
            <img src = "{{ asset($item->product->feature_image) }}" width = "40px" height = "40px" alt = "image">
        </td>
        <td>
            <strong>{{$item->product->name}}</strong>
        </td>
        <td>
            <strong>{{ $item->price }} TK</strong>
        </td>
        <td>
            <strong>{{ $item->qty }}</strong>
        </td>
        <td>
            <strong>{{ ($item->price) * $item->qty }} TK</strong>
        </td>
    </tr>
    @endforeach
</table>
@endforeach
        <table style="width:800px;margin-top: 25px;">
            <tr style="padding-top: 44px;">
                <td>
                    <strong>Billing Details</strong>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                    <strong>Summary</strong>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td style="font-size: 14px;">
                    <tr>
                        <td>
                            Customer Name:
                        </td>
                        <td>
                            {{ $order->user->name }}
                        </td>
                        <td>

                        </td>
                        <td>
                            Subtotal ({{ count($order->items) }} item):
                        </td>
                        <td>
                            {{ $order->subtotal }} TK
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Shipping Address:
                        </td>
                        <td>
                            {{$order->billing_address->completeAddress}}
                        </td>
                        <td>

                        </td>
                        <td>
                            Delivery Charge:
                        </td>
                        <td>
                            {{ $order->shipping_charge }} TK
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Phone Number:
                        </td>
                        <td>
                            {{ $order->user->mobile }}
                        </td>
                        <td>

                        </td>
                        <td>
                            Discount Coupon:
                        </td>
                        <td>
                            {{$order->user_coupon->name ?? '0' }} ({{$order->user_coupon->value ?? '0' }} TK)
                        </td>
                    </tr>
                    <tr>
                        <td>
                            payment method:
                        </td>
                        <td>
                            @switch($order->type)
                    @case('cash')
                        Cash On Delivery
                        @break
                    @case('store')
                        Store Pickup
                        @break
                    @case('gateway')
                        Online Payment
                        @break
                @endswitch
                        </td>
                        <td>

                        </td>
                        <td>
                            Total:
                        </td>
                        <td>
                            {{ $order->total }} TK
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Billing Address:
                        </td>
                        <td>
                            {{ $order->billing_address->completeAddress }}
                        </td>
                        <td>

                        </td>
                        <td>
                            @if ($order->payment_status == 'Partially Paid')
                                Parial Payment:
                            @endif

                        </td>
                        <td>
                            @if ($order->payment_status == 'Partially Paid')
                                {{ $order->partial_payment_amount }} TK
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>
                            @if ($order->payment_status == 'Partially Paid')
                                Remaining Total:
                            @endif

                        </td>
                        <td>
                            @if ($order->payment_status == 'Partially Paid')
                                {{ $order->total - $order->partial_payment_amount }} TK
                            @endif
                        </td>
                    </tr>
                </td>
            </tr>
        </table>
</body>
</html>
