@extends('mobile.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Checkout
@endsection
@push('css')

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css').'?v='.config()->get('version')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style2.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/themes/metroui.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/noty.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css').'?v='.config()->get('version')}}">


{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" rel="stylesheet"/>--}}
    <link rel="stylesheet" href="{{asset('frontend/assets/css/checkout.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart-summary.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/toggle.css').'?v='.config()->get('version')}}">

    <style>
        /* body .ui-autocomplete .ui-menu-item .ui-corner-all {
            background-color: white;
        } */
        /* .ui-menu-item .ui-menu-item-wrapper:hover
        {
            border: none !important;
            background-color: white;
        } */
        .ui-autocomplete {
            width: 100px;
            border-radius: 0.25rem;
            background-color: #eceff1;}
        .ui-menu-item {
            border: 1px solid #eceff1;
            border-radius: 0.25rem;}
        .ui-state-active,
        .ui-widget-content .ui-state-active,
        .ui-widget-header .ui-state-active,
        a.ui-button:active,
        .ui-button:active,
        .ui-button.ui-state-active:hover {
            background-color: #eceff1;
            border-color: #eceff1;
            color: #0d47a1;
        }


        .no-padding-margin{
            padding-right: 0px;
            padding-left: 0px;
        }

    </style>
@endpush

@section('mobile')
    @include('frontend.loader.az-loader')

{{--    <!--breadcrumbs area start-->--}}
{{--    <div class="breadcrumbs_area">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="breadcrumb_content">--}}
{{--                        <ul>--}}
{{--                            <li><a href="/">home</a></li>--}}
{{--                            <li>Checkout</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--breadcrumbs area end-->--}}

    <!--Checkout page section-->
    <div class="checkout_page_bg">
        <div class="container">
            @if ($errors->any())
                <div class="row">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="Checkout_section">
                <div class="checkout_form">
                    @php
                        $mallItems = collect($cart->cart_items)->reject(function ($cartItem){
                            return $cartItem->seller->is_anazmall_seller != true;
                        });
                        $otherItems = collect($cart->cart_items)->reject(function ($cartItem){
                            return $cartItem->seller->is_premium != true;
                        });
                        $mallGroup = collect($mallItems)->groupBy(function ($cartItem){
                            return $cartItem->seller->name;
                        });
                        $OtherGroup = collect($otherItems)->groupBy(function ($cartItem){
                            return $cartItem->seller->name;
                        });

                        $anaz_empire_shipping = [];
                        $other_seller_shipping = []
                    @endphp
                    <div class="row">
                        <div class="col-12">
                            @if ($mallGroup->count() > 0)
                                <div class="checkout_form_left">
                                    <div class="row">

                                        <div class="col text-center">
                                            <h4>ANAZ EMPIRE</h4>
                                        </div>
                                    </div>
                                    @php
                                        $shipping_dhaka = 0;
                                        $shipping_other = 0;
                                    @endphp
                                    @foreach($mallGroup as $shop_name => $group)
                                        <div class="seller-items">
                                            <div class="seller-header">
                                                <div class="left">
                                                    <label>{{$shop_name}}</label>
                                                </div>
                                            </div>
                                            <table>
                                                <tbody>
                                                @foreach($group as $cartItem)
                                                    @php

                                                        if($cartItem->shipping_charge_dhaka > $shipping_dhaka){
                                                            $shipping_dhaka = $cartItem->shipping_charge_dhaka;
                                                        }
                                                        if($cartItem->shipping_charge_other > $shipping_other){
                                                            $shipping_other = $cartItem->shipping_charge_other;
                                                        }
                                                    @endphp
                                                    <tr class="item-row">
                                                        <td>
                                                            #{{$loop->iteration}}
                                                        </td>
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
                                                        </td>
                                                        <td>
                                                            <p class="qty">x {{$cartItem->qty}}</p>
                                                        </td>
                                                        <td>
                                                            <p class="subtotal">
                                                                @if($cartItem->sale_percentage)
                                                                    {{$cartItem->sale_subtotal}} TK
                                                                @else
                                                                    {{$cartItem->original_subtotal}} TK
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                    @php
                                        $anaz_empire_shipping = [
                                            $shipping_dhaka,$shipping_other
                                        ]
                                    @endphp
                                    <div class="row">
                                        <div class="col text-right text-muted text">
                                            Delivery: <span class="anaz_empire"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($OtherGroup->count() > 0)
                                <div class="checkout_form_left">
                                    <div class="col text-center">
                                        <h4>ANAZ SPOTLIGHT</h4>
                                    </div>

                                    @foreach($OtherGroup as $shop_name => $group)
                                        <div class="seller-items">
                                            <div class="seller-header">
                                                <div class="left">
                                                    <label>{{$shop_name}}</label>
                                                </div>
                                            </div>
                                            <table>
                                                <tbody>
                                                @php
                                                    $shipping_charge_dhaka = 0;
                                                    $shipping_charge_other = 0;
                                                @endphp
                                                @foreach($group as $cartItem)
                                                    @php
                                                        if($cartItem->shipping_charge_dhaka > $shipping_charge_dhaka){
                                                            $shipping_charge_dhaka = $cartItem->shipping_charge_dhaka;
                                                        }
                                                        if($cartItem->shipping_charge_other > $shipping_charge_other){
                                                            $shipping_charge_other = $cartItem->shipping_charge_other;
                                                        }
                                                    @endphp
                                                    <tr class="item-row">
                                                        <td>
                                                            #{{$loop->iteration}}
                                                        </td>
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
                                                            <div class="price">
                                                                <p class="last-price">
                                                                    @if($cartItem->sale_percentage)
                                                                        {{$cartItem->sale_price}} TK
                                                                    @elseif($cartItem->original_price)
                                                                        {{$cartItem->original_price}} TK
                                                                        @else
                                                                        &mdash;
                                                                    @endif
                                                                </p>
                                                                <p class="original-price">
                                                                    @if($cartItem->sale_percentage)
                                                                        {{$cartItem->original_price}} TK
                                                                    @endif
                                                                </p>
                                                                <p class="percentage">
                                                                    @if($cartItem->sale_percentage)
                                                                        -{{$cartItem->sale_percentage}}%
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="qty">x {{$cartItem->qty}}</p>
                                                        </td>
                                                        <td>
                                                            <p class="subtotal">
                                                                @if($cartItem->sale_percentage)
                                                                    {{$cartItem->sale_subtotal}} TK
                                                                @else
                                                                    {{$cartItem->original_subtotal}} TK
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                @php
                                                    $other_seller_shipping[] = [strtolower(str_replace(' ','_',$shop_name)) => [$shipping_charge_dhaka,$shipping_charge_other]]
                                                @endphp
                                            </table>
                                            <div class="row">
                                                <div class="col text-right text-muted text">
                                                    Delivery: <span class="{{ strtolower(str_replace(' ','_',$shop_name)) }}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="checkout_form_left">
                                <h3>Delivery Details</h3>
                                <form action="{{route('frontend.checkout.post')}}" id="checkout-form" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="cash">
                                    <input type="hidden" name="buy_now" value="{{$buy_now}}">
                                    <div class="row">
                                        <div class="col text-center m-2 p-1 bg-dark">
                                            <span class="text-white">Billing Informations</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-20">
                                            <label for="bill_name">Full Name <span>*</span></label>
                                            <input type="text"
                                                   id="bill_name"
                                                   name="bill_name"
                                                   value="{{auth('web')->user()->name}}"
                                                   placeholder="Full Name">
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-6 mb-20">
                                            <label for="bill_mobile">Mobile <span>*</span></label>
                                            <input type="text"
                                                   id="bill_mobile"
                                                   name="bill_mobile"
                                                   value="{{auth('web')->user()->mobile}}"
                                                   placeholder="01xxxxxxxxx">
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-6 mb-20">
                                            <label for="bill_email">Email <span>*</span></label>
                                            <input type="email"
                                                   id="bill_email"
                                                   name="bill_email"
                                                   value="{{auth('web')->user()->email}}"
                                                   placeholder="example@email.com">
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-6 mb-20">
                                            <label for="bill_division">Division <span>*</span></label><br>
                                            <select name="bill_division" id="bill_division" class="select2"
                                                    style='width:100%;'>
                                                <option value="" disabled>Select Division</option>
                                                @foreach($divisions as $div)
                                                    <option value="{{az_hash($div->id)}}"
                                                        {{auth('web')->user()->division_id == $div->id ? 'selected' : ''}}>
                                                        {{$div->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-6 mb-20">
                                            <label for="bill_city">City <span>*</span></label>
                                            <br>
                                            <select name="bill_city" id="bill_city" class="select2" style='width:100%;'>
                                                <option value="" disabled>Select City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{az_hash($city->id)}}"
                                                        {{auth('web')->user()->city_id == $city->id ? 'selected' : ''}}>
                                                        {{$city->name}}
                                                    </option>$billing_address->city_id ??
                                                @endforeach
                                            </select>
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-6 mb-20">
                                            <label for="bill_area">Area <span>*</span></label><br>
                                            <select name="bill_area" id="bill_area" class="select2" style='width:100%;'>
                                                <option value="" disabled>Select Area</option>
                                                @foreach($areas as $area)
                                                    <option value="{{az_hash($area->id)}}"
                                                        {{auth('web')->user()->post_code_id == $area->id ? 'selected' : ''}}>
                                                        {{$area->name}}
                                                    </option>$billing_address->post_code_id ??
                                                @endforeach
                                            </select>
                                            <span class="error"></span>
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label for="bill_address_line_1">Billing address <span>*</span></label>
                                            <input type="text"
                                                   id="bill_address_line_1"
                                                   name="bill_address_line_1"
                                                   value="{{auth('web')->user()->address_line_1 ?? ''}}"
                                                   placeholder="House number and street name">
                                            <span class="error"></span>
                                        </div>

                                        <div class="col-12 mb-20">
                                            <input type="text"
                                                   id="bill_address_line_2"
                                                   name="bill_address_line_2"
                                                   value="{{auth('web')->user()->address_line_2 ?? ''}}"
                                                   placeholder="Apartment, suite, unit etc. (optional)">
                                            <span class="error"></span>
                                        </div>
{{--                                        <div class="col-12 mb-20">--}}
{{--                                            <label for="bill_address_line_1">--}}
{{--                                                Shipping Address is Same as billing address<span>*</span></label>--}}
{{--                                            <input id="checkBox" name="is_same_as_Bill_add" type="checkbox" data-toggle="toggle" data-on="Yes" data-off="No">--}}
{{--                                        </div>--}}
                                        {{--  Shipping Adress Area Start  --}}
{{--                                        <div class="col-12" id="delAdd" style="display: block;">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col text-center m-2 p-1 bg-dark">--}}
{{--                                                    <span class="text-white">Shipping Informations</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-6 mb-20">--}}
{{--                                                    <label for="ship_name">Full Name <span>*</span></label>--}}
{{--                                                    <input type="text"--}}
{{--                                                           id="ship_name"--}}
{{--                                                           name="ship_name"--}}
{{--                                                           value="{{auth('web')->user()->name}}"--}}
{{--                                                           placeholder="Full Name">--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-6 mb-20">--}}
{{--                                                    <label for="ship_mobile">Mobile <span>*</span></label>--}}
{{--                                                    <input type="text"--}}
{{--                                                           id="ship_mobile"--}}
{{--                                                           name="ship_mobile"--}}
{{--                                                           value="{{auth('web')->user()->mobile}}"--}}
{{--                                                           placeholder="01xxxxxxxxx">--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-6 mb-20">--}}
{{--                                                    <label for="ship_email">Email <span>*</span></label>--}}
{{--                                                    <input type="email"--}}
{{--                                                           id="ship_email"--}}
{{--                                                           name="ship_email"--}}
{{--                                                           value="{{auth('web')->user()->email}}"--}}
{{--                                                           placeholder="example@email.com">--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-6 mb-20">--}}
{{--                                                    <label for="ship_division">Division <span>*</span></label><br>--}}
{{--                                                    <select name="ship_division" id="ship_division" class="ship select2"--}}
{{--                                                            style='width:100%;'>--}}
{{--                                                        <option value="" disabled>Select Division</option>--}}
{{--                                                        @foreach($divisions as $div)--}}
{{--                                                            <option value="{{az_hash($div->id)}}"--}}
{{--                                                                {{auth('web')->user()->division_id == $div->id ? 'selected' : ''}}>--}}
{{--                                                                {{$div->name}}--}}
{{--                                                            </option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-6 mb-20">--}}
{{--                                                    <label for="ship_city">City <span>*</span></label>--}}
{{--                                                    <br>--}}
{{--                                                    <select name="ship_city" id="ship_city" class="ship select2" style='width:100%;'>--}}
{{--                                                        <option value="" disabled>Select City</option>--}}
{{--                                                        @foreach($cities as $city)--}}
{{--                                                            <option value="{{az_hash($city->id)}}"--}}
{{--                                                                {{auth('web')->user()->city_id == $city->id ? 'selected' : ''}}>--}}
{{--                                                                {{$city->name}}--}}
{{--                                                            </option>$billing_address->city_id ??--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-6 mb-20">--}}
{{--                                                    <label for="ship_area">Area <span>*</span></label><br>--}}
{{--                                                    <select name="ship_area" id="ship_area" class="ship select2" style='width:100%;'>--}}
{{--                                                        <option value="" disabled>Select Area</option>--}}
{{--                                                        @foreach($areas as $area)--}}
{{--                                                            <option value="{{az_hash($area->id)}}"--}}
{{--                                                                {{auth('web')->user()->post_code_id == $area->id ? 'selected' : ''}}>--}}
{{--                                                                {{$area->name}}--}}
{{--                                                            </option>$billing_address->post_code_id ??--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="row">--}}
{{--                                                <div class="col-12 mb-20" >--}}
{{--                                                    <label for="ship_address_line_1">Delivery address <span>*</span></label>--}}
{{--                                                    <input type="text"--}}
{{--                                                           id="ship_address_line_10"--}}
{{--                                                           name="ship_address_line_1"--}}
{{--                                                           value="{{auth('web')->user()->address_line_1 ?? ''}}"--}}
{{--                                                           placeholder="House number and street name">--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-12 mb-20">--}}
{{--                                                    <input type="text"--}}
{{--                                                           id="ship_address_line_20"--}}
{{--                                                           name="ship_address_line_2"--}}
{{--                                                           value="{{auth('web')->user()->address_line_2 ?? ''}}"--}}
{{--                                                           placeholder="Apartment, suite, unit etc. (optional)">--}}
{{--                                                    <span class="error"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        {{--  Shipping Address Area End  --}}

                                        <div class="col-12">
                                            <div class="order-notes">
                                                <label for="order_note">Order Notes</label>
                                                <textarea id="order_note"
                                                          name="order_note"
                                                          placeholder="Notes about your order, e.g. special notes for delivery."
                                                ></textarea>
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12" style="margin-left:auto;">
                            <div class="row summary-div">
                                <h3>Summary</h3>
                                <p class="summary-item subtotal">
                            <span class="left">
                                Subtotal ({{$cart->activeCount}} items)
                            </span>
                                    <span class="right">
                                {{round($cart->subtotal )}} TK
                            </span>
                                </p>
                                <p class="summary-item charge">
                            <span class="left">
                                Delivery Charge
                            </span>
                                    <span class="right">
                                {{$cart->delivery_charge}} TK
                            </span>
                                </p>
                                <p class="summary-item discount">
                            <span class="left">
                                Coupon Discount
                            </span>
                                    <span class="right">
                                {{$cart->coupon_value}} TK
                            </span>
                                </p>

                                <div class="summary-coupon-div">
                                    <div class="readable" style="display: {{$cart->coupon ? 'flex' : 'none'}}">
                                        <span class="summary-coupon-input"
                                              style="flex: 15">Coupon: {{$cart->coupon}}</span>
                                        <button type="button"
                                                class="summary-coupon-btn edit"
                                                style="flex: 1"
                                                title="Edit Coupon">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                    <div class="editable" style="display: {{$cart->coupon ? 'none' : 'flex'}}">
                                        <input type="text"
                                               disabled
                                               class="summary-coupon-input"
                                               placeholder="Enter coupon"
                                               value="{{$cart->coupon}}">
                                        {{--                                        @dd($cart)--}}
                                        <button type="button" class="summary-coupon-btn apply" disabled style="background-color: lightgrey">Apply</button>
                                    </div>
                                </div>
                                <p class="summary-item total">
                            <span class="left">
                                Total
                            </span>
                                    <span class="right">
                                {{ $cart->total }} TK <br>
                            </span>
                                </p>
                                <div class="summary-btn-group">
                                    <a href="#"
                                       type="button"
                                       id="sslczPayBtn"
                                       class="pay-btn"
                                       postdata="bla"
                                       order="bla"
                                       endpoint="{{ url('/') }}/checkout">
                                        Pay Online
                                    </a>
                                    <a href="#" type="button" class="cash-btn">Cash on delivery</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script>
        var isShipping = true;
        $(document).on('change', "#checkBox", function() {
            // this will contain a reference to the checkbox
            if (this.checked) {
                // the checkbox is now checked
                //alert('on');
                isShipping = false;
                $("#delAdd").fadeOut();
                var selct = $( "#bill_city option:selected" ).text().toString().trim();
                $("#bill_city option:contains("+selct+")").attr('selected', 'selected');
                // alert(isShipping+"-"+selct);
                // For Dhaka as Main
                //if(selct === "Dhaka"){
                //    $(".charge span.right").text({{$cart->delivery_charge_dhaka}}+" TK");
                //    $(".anaz_empire").text({{$cart->delivery_charge_dhaka}}+" TK");
                //}else{
                //    $(".charge span.right").text({{$cart->delivery_charge_other}}+" TK");
                //    $(".anaz_empire").text({{$cart->delivery_charge_other}}+" TK");
                //}
                // For Chittagong as Main
                if(selct === "Chattogram" || selct === "Chattogram Sadar"){
                    $(".charge span.right").text({{$cart->delivery_charge_dhaka}}+" TK");
                    $(".anaz_empire").text({{$cart->delivery_charge_dhaka}}+" TK");
                }else{
                    $(".charge span.right").text({{$cart->delivery_charge_other}}+" TK");
                    $(".anaz_empire").text({{$cart->delivery_charge_other}}+" TK");
                }
            } else {
                // the checkbox is now no longer checked
                //alert('off');
                isShipping = true;
                $("#delAdd").fadeIn();
                var selct = $( "#ship_city option:selected" ).text().toString().trim();
                $("#ship_city option:contains("+selct+")").attr('selected', 'selected');
                // alert(isShipping+"-"+selct);
                // For Dhaka as Main
                //if(selct === "Dhaka"){
                //    $(".charge span.right").text({{$cart->delivery_charge_dhaka}}+" TK");
                //    $(".anaz_empire").text({{$cart->delivery_charge_dhaka}}+" TK");
                //}else{
                //    $(".charge span.right").text({{$cart->delivery_charge_other}}+" TK");
                //    $(".anaz_empire").text({{$cart->delivery_charge_other}}+" TK");
                //}
                // For Chittagong as Main
                if(selct === "Chattogram" || selct === "Chattogram Sadar"){
                    $(".charge span.right").text({{$cart->delivery_charge_dhaka}}+" TK");
                    $(".anaz_empire").text({{$cart->delivery_charge_dhaka}}+" TK");
                }else{
                    $(".charge span.right").text({{$cart->delivery_charge_other}}+" TK");
                    $(".anaz_empire").text({{$cart->delivery_charge_other}}+" TK");
                }
            }
        });
        $(document).ready(function () {
            // $(window).load(function() {
            //     $("#delAdd").hide();
            // });
            $("#checkBox").attr('checked', false);
            $('.select2').chosen();
            const mobilePattern = /^01[0-9]{9}$/;
            const emailPattern = /^\S+@\S+\.\S+$/;
            const bill_name = $('#bill_name');
            const bill_mobile = $('#bill_mobile');
            const bill_email = $('#bill_email');
            const bill_division = $('#bill_division');
            const bill_city = $('#bill_city');
            const bill_area = $('#bill_area');
            const bill_address_line_1 = $('#bill_address_line_1');
            const bill_address_line_2 = $('#bill_address_line_2');
            const anaz_empire = $('.anaz_empire');
            const ship_name = $('#ship_name');
            const ship_mobile = $('#ship_mobile');
            const ship_email = $('#ship_email');
            const ship_division = $('#ship_division');
            const ship_city = $('#ship_city');
            const ship_area = $('#ship_area');
            const ship_address_line_1 = $('#ship_address_line_1');
            const ship_address_line_2 = $('#ship_address_line_2');
            let other_seller_shipping = @json($other_seller_shipping);
            let anaz_empire_shipping = @json($anaz_empire_shipping);
            (function(){
                const isDhaka = bill_city.find('option:selected').text().toString().trim().includes('Chattogram');
                anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])
                $.each(other_seller_shipping,function(index,value){
                    let data = Object.entries(value)[0];
                    $('.'+data[0]).empty();
                    $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])
                })
            })();
            {{--if(isShipping){--}}
            {{--    ship_name.on('input', function () {--}}
            {{--        if ($(this).val().trim().length <= 3) {--}}
            {{--            $(this).parent().find('.error').text('Name is required');--}}
            {{--        } else {--}}
            {{--            $(this).parent().find('.error').text('');--}}
            {{--        }--}}
            {{--    });--}}
            {{--    ship_mobile.on('input', function () {--}}
            {{--        if (!mobilePattern.test($(this).val())) {--}}
            {{--            $(this).parent().find('.error').text('Valid mobile number is required');--}}
            {{--        } else {--}}
            {{--            $(this).parent().find('.error').text('');--}}
            {{--        }--}}
            {{--    });--}}
            {{--    ship_email.on('input', function () {--}}
            {{--        if (!emailPattern.test($(this).val())) {--}}
            {{--            $(this).parent().find('.error').text('Valid email address is required');--}}
            {{--        } else {--}}
            {{--            $(this).parent().find('.error').text('');--}}
            {{--        }--}}
            {{--    });--}}
            {{--    ship_address_line_1.on('input', function () {--}}
            {{--        if ($(this).val().toString().trim().length > 255)--}}
            {{--            $(this).val($(this).val().toString().trim().substring(0, 255));--}}
            {{--    });--}}
            {{--    ship_address_line_2.on('input', function () {--}}
            {{--        if ($(this).val().toString().trim().length > 255)--}}
            {{--            $(this).val($(this).val().toString().trim().substring(0, 255));--}}
            {{--    });--}}
            {{--    ship_division.on('change', function () {--}}
            {{--        updateCities($(this).val(),'ship');--}}
            {{--        const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Chattogram');--}}
            {{--        anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])--}}
            {{--        $.each(other_seller_shipping,function(index,value){--}}
            {{--            let data = Object.entries(value)[0];--}}
            {{--            $('.'+data[0]).empty();--}}
            {{--            $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])--}}
            {{--        });--}}
            {{--        const charge = isDhaka ? {{$cart->delivery_charge_dhaka}} : {{$cart->delivery_charge_other}};--}}
            {{--        const total = isDhaka ? {{$cart->total_dhaka}} : {{$cart->total_other}};--}}
            {{--        updateSummary(charge, total);--}}
            {{--    });--}}
            {{--    ship_city.on('change', function () {--}}
            {{--        const val = $(this).val();--}}
            {{--        const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Chattogram');--}}
            {{--        updateAreas(val,'ship');--}}
            {{--        anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])--}}
            {{--        $.each(other_seller_shipping,function(index,value){--}}
            {{--            let data = Object.entries(value)[0];--}}
            {{--            $('.'+data[0]).empty();--}}
            {{--            $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])--}}
            {{--        })--}}
            {{--        const charge = isDhaka ? {{$cart->delivery_charge_dhaka}} : {{$cart->delivery_charge_other}};--}}
            {{--        const total = isDhaka ? {{$cart->total_dhaka}} : {{$cart->total_other}};--}}
            {{--        updateSummary(charge, total);--}}
            {{--    });--}}
            {{--}--}}
            bill_name.on('input', function () {
                if ($(this).val().trim().length <= 3) {
                    $(this).parent().find('.error').text('Name is required');
                } else {
                    $(this).parent().find('.error').text('');
                }
            });
            bill_mobile.on('input', function () {
                if (!mobilePattern.test($(this).val())) {
                    $(this).parent().find('.error').text('Valid mobile number is required');
                } else {
                    $(this).parent().find('.error').text('');
                }
            });
            bill_email.on('input', function () {
                if (!emailPattern.test($(this).val())) {
                    $(this).parent().find('.error').text('Valid email address is required');
                } else {
                    $(this).parent().find('.error').text('');
                }
            });
            bill_address_line_1.on('input', function () {
                if ($(this).val().toString().trim().length > 255)
                    $(this).val($(this).val().toString().trim().substring(0, 255));
            });
            bill_address_line_2.on('input', function () {
                if ($(this).val().toString().trim().length > 255)
                    $(this).val($(this).val().toString().trim().substring(0, 255));
            });
            {{--  bill_division.niceSelect();  --}}
            bill_division.on('change', function () {
                {{--if($("#checkBox").is(':checked')){--}}
                {{--    const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Chattogram');--}}
                {{--    anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])--}}
                {{--    $.each(other_seller_shipping,function(index,value){--}}
                {{--        let data = Object.entries(value)[0];--}}
                {{--        $('.'+data[0]).empty();--}}
                {{--        $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])--}}
                {{--    })--}}
                {{--    const charge = isDhaka ? {{$cart->delivery_charge_dhaka}} : {{$cart->delivery_charge_other}};--}}
                {{--    const total = isDhaka ? {{$cart->total_dhaka}} : {{$cart->total_other}};--}}
                {{--    updateSummary(charge, total);--}}
                {{--}--}}
                const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Chattogram');
                const isDhakaCity = bill_city.find('option:selected').text().toString().trim().includes('Chattogram');
                anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])
                $.each(other_seller_shipping,function(index,value){
                    let data = Object.entries(value)[0];
                    $('.'+data[0]).empty();
                    $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])
                })
                updateCities($(this).val());
                if (isDhaka === true){
                    if(isDhakaCity === true){
                        anaz_empire.text(anaz_empire_shipping[0]);
                        const charge = {{$cart->delivery_charge_dhaka}};
                        const total = {{$cart->total_dhaka}};
                        updateSummary(charge, total);
                    }else{
                        anaz_empire.text(anaz_empire_shipping[1]);
                        const charge = {{$cart->delivery_charge_other}};
                        const total = {{$cart->total_other}};
                        updateSummary(charge, total);
                    }
                }else {
                    anaz_empire.text(anaz_empire_shipping[1]);
                    const charge = {{$cart->delivery_charge_other}};
                    const total = {{$cart->total_other}};
                    updateSummary(charge, total);
                }
            });
            {{--  bill_city.niceSelect();  --}}
            bill_city.on('change', function () {
                {{--if($("#checkBox").is(':checked')){--}}
                {{--    const val = $(this).val();--}}
                {{--    const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Chattogram');--}}
                {{--    updateAreas(val);--}}
                {{--    anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])--}}
                {{--    $.each(other_seller_shipping,function(index,value){--}}
                {{--        let data = Object.entries(value)[0];--}}
                {{--        $('.'+data[0]).empty();--}}
                {{--        $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])--}}
                {{--    })--}}
                {{--    const charge = isDhaka ? {{$cart->delivery_charge_dhaka}} : {{$cart->delivery_charge_other}};--}}
                {{--    const total = isDhaka ? {{$cart->total_dhaka}} : {{$cart->total_other}};--}}
                {{--    updateSummary(charge, total);--}}
                {{--}--}}
                const val = $(this).val();
                const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Chattogram');
                updateAreas(val);
                anaz_empire.text(isDhaka ? anaz_empire_shipping[0] : anaz_empire_shipping[1])
                $.each(other_seller_shipping,function(index,value){
                    let data = Object.entries(value)[0];
                    $('.'+data[0]).empty();
                    $('.'+data[0]).text(isDhaka ? data[1][0] : data[1][1])
                })
                const charge = isDhaka ? {{$cart->delivery_charge_dhaka}} : {{$cart->delivery_charge_other}};
                const total = isDhaka ? {{$cart->total_dhaka}} : {{$cart->total_other}};
                updateSummary(charge, total);
            });
            {{--  bill_area.niceSelect();  --}}
            const order_note = $('#order_note');
            order_note.on('input', function () {
                if ($(this).val().toString().trim().length > 255)
                    $(this).val($(this).val().toString().trim().substring(0, 255));
            });
            $('.summary-coupon-btn.edit').on('click', function () {
                $('.summary-coupon-div .readable').css('display', 'none');
                $('.summary-coupon-div .editable').css('display', 'flex');
            });
            $('.summary-coupon-btn.apply').on('click', function () {
                const code = $('.editable .summary-coupon-input').val().trim();
                if (code !== '') {
                    couponUpdateRequest(code);
                }
            });
            const cashBtn = $('.cash-btn');
            const payNowBtn = $('.pay-btn');
            const form = $('#checkout-form');
            cashBtn.on('click', function (e) {
                e.preventDefault();
                if (formCheck()) {
                    form.submit();
                }else{
                    alert('Please Fill all required fields.');
                }
            });
            payNowBtn.on('click',function(e){
                e.preventDefault();
                $('input[name=type]').val('gateway');
                if(formCheck()){
                    form.submit();
                }else{
                    alert('Please Fill all required fields.');
                }
            });
            function formCheck() {
                return !(bill_name.val().trim() === ''
                    || !mobilePattern.test(bill_mobile.val())
                    || !emailPattern.test(bill_email.val())
                    || bill_division.val() === ''
                    || bill_city.val() === ''
                    || bill_area.val() === ''
                    || bill_address_line_1.val().trim() === '');
            }
            function shippingDetailsCheck(){
            }
            function couponUpdateRequest(coupon) {
                toggleAZLoader();
                $.post('{{route("frontend.cart.apply-coupon.ajax")}}', {coupon: coupon}, function (res) {
                    setupSummary(res);
                    toggleAZLoader();
                });
            }
            function setupSummary(res) {
                $('.summary-item.subtotal .left').text('Subtotal (' + res.activeCount + ' items)');
                $('.summary-item.subtotal .right').text(res.subtotal + ' TK');
                $('.summary-item.charge .right').text(res.deliveryCharge + ' TK');
                $('.summary-item.discount .right').text(res.couponDiscount + ' TK');
                $('.summary-item.vat .right').text(res.vat + ' TK');
                $('.summary-item.total .right').text(res.total + ' TK');
                if (res.coupon) {
                    $('.summary-coupon-div input.summary-coupon-input').val(res.coupon);
                    $('.summary-coupon-div span.summary-coupon-input').text('Coupon: ' + res.coupon);
                    $('.summary-coupon-div .editable').css('display', 'none');
                    $('.summary-coupon-div .readable').css('display', 'flex');
                } else {
                    $('.summary-coupon-div input.summary-coupon-input').val('');
                    $('.summary-coupon-div span.summary-coupon-input').text('Coupon: ');
                    $('.summary-coupon-div .editable').css('display', 'flex');
                    $('.summary-coupon-div .readable').css('display', 'none');
                }
            }
            function updateSummary(deliveryCharge, total) {
                $('.summary-item.charge .right').text(deliveryCharge + ' TK');
                $('.summary-item.total .right').text(total + ' TK');
            }
            function updateCities(division,type = 'bill') {
                $.get('{{route('frontend.checkout.cities.ajax')}}?division=' + division, function (res) {
                    if (res.cities) {
                        if(type == 'bill'){
                            bill_city.empty();
                            console.log(type)
                            bill_city.append(`<option value="" disabled>Select Cities</option>`);
                            let first = 0;
                            res.cities.forEach(function (c, i) {
                                if (i === 0)
                                    first = c.id;
                                bill_city.append(`<option value="${c.id}" ${i === 0 ? 'selected' : ''}>${c.name}</option>`);
                            });
                            bill_city.val(first).trigger('chosen:updated');
                            {{--  bill_city.('update');  --}}
                        }else{
                            console.log(type)
                            ship_city.empty();
                            ship_city.append(`<option value="" disabled>Select Cities</option>`);
                            let first = 0;
                            res.cities.forEach(function (c, i) {
                                if (i === 0)
                                    first = c.id;
                                ship_city.append(`<option value="${c.id}" ${i === 0 ? 'selected' : ''}>${c.name}</option>`);
                            });
                            ship_city.val(first).trigger('chosen:updated');
                            {{--  ship_city.niceSelect('update');  --}}
                        }
                    }
                });
            }
            function updateAreas(city,type = 'bill') {
                $.get('{{route('frontend.checkout.areas.ajax')}}?city=' + city, function (res) {
                    if (res.areas) {
                        if(type == 'bill'){
                            bill_area.empty();
                            bill_area.append(`<option value="" disabled>Select Areas</option>`);
                            res.areas.forEach(function (a) {
                                bill_area.append(`<option value="${a.id}">${a.name}</option>`);
                            });
                            bill_area.trigger('chosen:updated');
                        }else{
                            ship_area.empty();
                            ship_area.append(`<option value="" disabled>Select Areas</option>`);
                            res.areas.forEach(function (a) {
                                ship_area.append(`<option value="${a.id}">${a.name}</option>`);
                            });
                            ship_area.trigger('chosen:updated');
                        }
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link rel="stylesheet" href="{{asset('frontend/assets/css/checkout.css').'?v='.config()->get('version')}}">

    @if(config()->get('sslcommerz.connect_from_localhost'))
        <style>
            .cash-btn {
                margin-top: 8px;
            }
        </style>
    @endif
@endpush
