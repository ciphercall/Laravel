@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Order Details
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart-summary.css').'?v='.config()->get('version')}}">
@endpush

@section('content')
    @include('frontend.loader.az-loader', ['left' => '32%'])

    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li><a href="/account">Order</a></li>
                            <li class="active">{{ $order->no }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php

        $groupedItems = [];
        foreach($order->items as $item){
            $key = "";
            if ($item->seller->is_anazmall_seller){
                $key = "Anaz Empire";
            }elseif ($item->seller->is_premium){
                $key = "Anaz Spotlight";
            }else{
                $key = "Other Sellers";
            }
            $groupedItems[$key][$item->seller->shop_name][] = $item;
        }
        if ($order->delivery_breakdown){
            $chunks = array_chunk(preg_split('/(:|,)/', $order->delivery_breakdown), 2);
            $deliveryBreakdown = array_combine(array_column($chunks, 0), array_column($chunks, 1));
        }else{
            $deliveryBreakdown = [];
        }

    @endphp
    <div class="cart_page_bg">
        <div class="container" style="margin-left: 10px;margin-right:10px">
            <div class = "row">
                @if(session()->has('success'))
                    <div class = "col text-center">
                        <h4  class = "text-danger">{{ session('success') }}</h4>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-8 item-area" style="padding-right: 0">
                        @foreach ($groupedItems as $collectionKey => $collectionGroup)
                            <div class="row" style="margin-top: 10px;">
                                <div class="col bg-dark rounded text-center p-2">
                                    <h3 class="text-white rounded">{{ $collectionKey }}</h3>
                                </div>
                            </div>
                            @foreach($collectionGroup as $shop_name => $group)
                                <div class="row border-primary">
                                    <div class="col-12 py-2 bg-white rounded text-center">
                                        <b>{{ $shop_name }}</b>
                                    </div>
                                    <hr>
                                    <div class="col">
                                        @foreach($group as $item)
                                            <div class="row bg-white my-2 pb-2 pr-2 shadow-sm rounded">
                                                <div class="col-4">
                                                    <img class="img-fluid border-sm" style="width: 200px !important; height: auto !important; max-height: 200px;" src="{{asset($item->product->feature_image)}}" alt="">
                                                </div>
                                                <div class="col">
                                                    <div class="row">

                                                        <div class="col-12 my-3" style="height: 94px">
                                                            <p><b><a class="" href="{{ route('frontend.product',$item->product->slug) }}">{{$item->product->name,40}}</a></b>
                                                                <br>
                                                                {!! Str::limit($item->product->short_description,150) !!}
                                                            </p>
                                                        </div>

                                                        <div class="col">
                                                            <div class="">
                                                                Quantity: {{ $item->qty }}
                                                            </div>
                                                            <div class="price">
                                                                <p class="text-danger">
                                                                    {{$item->subtotal}}
                                                                    <del class="text-info">
                                                                        @if($item->discount > 0)
                                                                            {{$item->subtotal + $item->discount}} TK
                                                                        @endif
                                                                    </del>
                                                                </p>
                                                            </div>
                                                            <div class="" style="position: relative">
                                                                @if($item->discount > 0)
                                                                    <p style="font-size: 8pt" class="text-danger text-right">You Saved {{ ($item->discount ) }} &#2547;</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($loop->last && array_key_exists($shop_name,$deliveryBreakdown))
                                                        <div class="row">
                                                            <div class="col-12 text-right">
                                                                <div class="col text-right text-muted" style="font-size: 9pt;">Delivery Charge For {{ $shop_name }}: {{$deliveryBreakdown[$shop_name]}}</div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @if (array_key_exists($collectionKey,$deliveryBreakdown))
                                <div class="row rounded">
                                    <div class="col text-right text-muted" style="font-size: 9pt;">Delivery Charge For Anaz Empire: {{$deliveryBreakdown[$collectionKey]}}</div>
                                </div>
                            @endif
                        @endforeach
                </div>

                <div class="col-4" style="padding-left: 0;">
                    <div class="row summary-div rounded shadow-sm" style="margin-top: 8%;">
                        <p class="summary">Summary</p>
                        <p class="summary-item subtotal">
                            <span class="left">
                                Payment Status
                            </span>
                            <span class="right {{ $order->payment_status == "Paid" ? 'text-success' : 'text-danger' }}">
                                {{ $order->payment_status }}
                            </span>
                        </p>
                        <p class="summary-item subtotal">
                            <span class="left">
                                Subtotal ({{ count($order->items) }} items)
                            </span>
                            <span class="right">
                                {{ round($order->subtotal) }} TK
                            </span>
                        </p>
                        <p class="summary-item charge">
                            <span class="left">
                                Delivery Charge
                            </span>
                            <span class="right">
                                {{$order->shipping_charge}} TK
                            </span>
                        </p>
                        <p class="summary-item discount">
                            <span class="left">
                                Coupon Discount
                            </span>
                            <span class="right">
                                @php
                                    $value = 0;
                                    if($order->user_coupon != null){
                                        $value = $order->user_coupon->value;
                                    }

                                @endphp
                                - {{$value}} TK
                            </span>
                        </p>
                        <p class="summary-item discount">
                            <span class="left">
                                Redeem Discount
                            </span>
                            <span class="right">
                                @php
                                    $redeemValue = 0;
                                    if($order->point_redeem != null){
                                        $redeemValue = $order->point_redeem->value;
                                    }

                                @endphp
                                - {{$redeemValue}} TK
                            </span>
                        </p>
                        <p class="summary-item total">
                            <span class="left">
                                Total
                            </span>
                            <span class="right">
                                {{$order->total}} TK
                            </span>
                        </p>
                    @if ($order->partial_payment)

                        <p class="summary-item">
                            <span class="left">
                                Paid
                            </span>
                            <span class="right text-success">
                                {{$order->partial_payment_amount}} TK
                            </span>
                        </p>
                        <p class="summary-item total">
                            <span class="left">
                                Remaining Total
                            </span>
                            <span class="right">
                                {{$order->total - $order->partial_payment_amount}} TK
                            </span>
                        </p>
                            
                        @endif
                    </div>
                    <div class="row summary-div  rounded shadow-sm" style="margin-top: 8%;">
                        <p class="summary">Billing Details</p>
                        <p class="summary-item subtotal">
                            <span class="left">
                                Customer Name
                            </span>
                            <span class="right">
                                {{ auth()->user()->name }}
                            </span>
                        </p>
                        <p class="summary-item charge">
                            <span class="left">
                                Shipping Address
                            </span>
                            <span class="right text-right" style="font-size: 9px; margin-right:0% !important;">
                                {{ $order->delivery_address ? $order->delivery_address->completeAddress : $order->billing_address->completeAddress }}
                            </span>
                        </p>
                        <p class="summary-item discount">
                            <span class="left">
                                Phone Number
                            </span>
                            <span class="right">
                                    {{ $order->billing_address->mobile }}
                            </span>
                        </p>
                        <p class="summary-item discount">
                            <span class="left">
                                Payment Method
                            </span>
                            <span class="right">
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
                            </span>
                        </p>
                        <p class="summary-item discount">
                            <span class="left">
                                Billing Address
                            </span>
                            <span class="text-right" style="font-size: 9px;margin-right:0% !important;">
                                {{ $order->billing_address->completeAddress }}
                            </span>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
