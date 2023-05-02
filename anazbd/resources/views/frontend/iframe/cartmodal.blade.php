<!doctype html>
<html lang="en">
<head>
    @include('frontend.include.header')

    <style>
        button {
            border: none;
        }

        .header-modal h3 {
            font-size: 18px;
            color: #4caf50;
            vertical-align: middle;
        }

        .header-modal p {

        }

        .header-modal img {
            width: 100%;
            height: 50%;
        }

        .cart-item-sku {
            font-size: 12px;
            line-height: 16px;
            color: #757575;
        }

        .cart-item-inner {
            width: 100%;
            display: table;
        }

        .cart-item-left {
            display: table-cell;
            vertical-align: top;
        }

        .cart-item-current-price {
            font-size: 18px;
            line-height: 28px;
            color: #f57224;
            font-weight: 500;
            margin-bottom: 4px;
        }


        .cart-item-origin-price {
            color: #757575;
            margin-bottom: 8px;
            text-decoration: line-through;
            margin-right: 5px;
        }

        .cart-item-promotion-ratio {
            color: #212121;
            font-weight: 500;
        }

        .cart-item-origin-price, .cart-item-promotion-ratio {
            font-size: 14px;
            line-height: 16px;
            display: inline-block;
        }

        .cart-item-right {

        }

        .cart-item-quantity {
            text-align: right;
            vertical-align: middle;
        }

        .cart-item-quantity-prefix {
            font-size: 14px;
            color: #757575;
            vertical-align: middle;
        }

        .cart-item-quantity-value {
            font-size: 16px;
            line-height: 28px;
            color: #212121;
            vertical-align: middle;
        }

        .summary-section-heading {
            font-size: 18px;
            color: #212121;
            margin-bottom: 14px;
            position: relative;
            font-weight: 500;
        }

        .checkout-summary-count {
            font-size: 12px;
            color: #757575;
            letter-spacing: 0;
            vertical-align: middle;
            display: inline-block;
            margin-left: 10px;
        }

        .cart-checkout-summary {
            padding: 8px 0 0 12px;
        }

        .checkout-summary-rows {
            margin-bottom: 15px;
        }

        .checkout-summary-row:last-child {
            margin-bottom: 0;
        }

        .checkout-summary-main {
            display: -webkit-box;
            display: flex;
        }

        .cart-checkout-summary .checkout-summary-label {
            font-size: 12px;
            color: #757575;
            letter-spacing: 0;
            line-height: 16px;
        }

        .cart-checkout-summary .checkout-summary-value {
            font-size: 14px;
            color: #424242;
            letter-spacing: 44px;
        }

        .checkout-summary-noline-value {
            margin-right: 5px;
        }

        .cart-order-total .checkout-order-total-title {
            font-weight: 400;
            font-size: 16px;
            float: left;
        }

        .checkout-order-total-fee {
            display: table-cell;
            font-size: 18px;
            color: #f57224;
            text-align: right;
            margin-left: 27%;
        }

        .go-to-cart {
            border: 1px solid #f57224 !important;
            color: #f57224;
            padding: 12px 20px;
            font-size: 13px;
        }

        .btn-checkout {
            border: 1px solid #c40316 !important;
            color: #c40316;
            padding: 12px 20px;
            font-size: 13px;
        }

        .btn-checkout:hover {
            color: white;
            background-color: #c40316;
        }

        .btn-checkout:active {
            color: white;
            background-color: #c40316;
        }

        .go-to-cart:hover {
            color: white;
            background-color: #f57224;
        }

        .go-to-cart:active {
            color: white;
            background-color: #f57224;
        }

        .btn-outline-primary:not(:disabled):not(.disabled).active, .btn-outline-primary:not(:disabled):not(.disabled):active, .show > .btn-outline-primary.dropdown-toggle {
            color: #fff;
            background-color: #f57224;
            /* border-color: #007bff; */
        }

        .checkout-summary-row {
            display: flex;
            justify-content: space-between;
            margin-right: 20px
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row">
        @php
            $cart = session()->get('cart');
        @endphp

        {{-- right part --}}
        <div class="col-md-7 header-modal mt-5 border-right ">
            <h3><i class="fa fa-check-circle" aria-hidden="true"></i> Item has been added to your cart</h3>
            <div class="row">
                <div class="col-md-2">
                    <img src="{{asset($variant->image ?? $item->product->feature_image)}}" alt="">
                </div>
                <div class="col-md-8">
                    <p>{{$item->product->name}}</p>
                    @if($item->variant)
                        @if($item->variant->color)
                            <p class="cart-item-sku">Color: {{$item->variant->color->name}}</p>
                        @endif
                        @if($item->variant->size)
                            <p class="cart-item-sku">Size: {{$item->variant->size->name}}</p>
                        @endif
                    @endif

                    <div class="cart-item-inner">
                        <div class="cart-item-left">
                            @if($item->sale_subtotal)
                                <p class="cart-item-current-price">{{$item->sale_subtotal}} TK</p>
                                <p class="cart-item-origin-price">{{$item->original_subtotal}} TK</p>
                                <p class="cart-item-promotion-ratio">-{{$item->sale_percentage}}%</p>
                            @else
                                <p class="cart-item-current-price">{{$item->subtotal}} TK</p>
                            @endif
                        </div>
                        <div class="cart-item-right">
                            <div class="cart-item-quantity">
                                <span class="cart-item-quantity-prefix">Qty: </span>
                                <span class="cart-item-quantity-value">{{$item->qty}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- left part --}}
        <div class="col-md-5 mt-5">
            <div class="cart-panel cart-panel-right">
                <div class="summary-section">
                    <div class="summary-section-heading">
                        <div class="checkout-summary-title" data-spm-anchor-id="a2a0e.pdp.0.i9.1ae55bdaLCKZhj">My
                            Shopping Cart
                            <span class="checkout-summary-count">
                                    ({{$cart->activeCount > 1 ? $cart->activeCount .' items' : '1 item'}})
                                </span>
                        </div>
                    </div>
                    <div class="summary-section-content">
                        <div class="cart-checkout-summary  checkout-summary">
                            <div class="checkout-summary-rows">
                                <div class="checkout-summary-row">
                                    <span>Subtotal: </span>
                                    <span style="color: #494949">{{round($cart->subtotal_without_coupon+$cart->vat)}} TK</span>
                                </div>
                                <div class="checkout-summary-row">
                                    <span>Delivery Charge: </span>
                                    <span style="color: #494949">{{ $cart->delivery_charge_dhaka }} TK</span>
                                </div>
                                <div class="checkout-summary-row">
                                    <span>Coupon Discount: </span>
                                    <span style="color: #494949">{{ $cart->coupon_value }} TK</span>
                                </div>
                                <div class="checkout-summary-row">
                                    <span>Total: </span>
                                    <span style="color: #494949">{{$cart->total}} TK</span>
                                </div>
                                <div class="cart-order-total checkout-order-total" style="margin-top: 10%">
                                    <a type="button"
                                       class="btn btn-outline-primary go-to-cart">
                                        GO TO CART
                                    </a>
                                    <a type="button"
                                       class="btn buy-now btn-checkout">
                                        CHECK OUT
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function (){
        $('.go-to-cart').on('click', function (){
            window.parent.location.href = "{{ route('frontend.cart.index') }}";
        });
        $('.btn-checkout').on('click', function (){
            window.parent.location.href = "{{ route('frontend.checkout.index') }}";
        });
    });
</script>
</body>
</html>
