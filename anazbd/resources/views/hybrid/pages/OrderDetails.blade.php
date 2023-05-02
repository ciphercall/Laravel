@extends('hybrid.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Cart
@endsection
@push('css')
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style2.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/themes/metroui.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/noty.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart-summary.css').'?v='.config()->get('version')}}">
@endpush

@section('mobile')
    {{--  @include('frontend.loader.az-loader', ['left' => '32%'])  --}}

    {{--  <div class="breadcrumbs_area">
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
    </div>  --}}

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
    <div class = "">
        <div class = "container">
            <div class = "row">
                @if(session()->has('success'))
                    <div class = "col text-center">
                        <h4  class = "text-danger">{{ session('success') }}</h4>
                    </div>
                @endif
            </div>
            <div class = "row">

                <div class = "col-12" style = "padding-right: 0">
                    <!-- SELECT ALL -->

                    <!-- SELLER ITEMS -->

                    <div class = "">

                        <div style="
    margin-left: 3%;
" class="left">
                            <label><strong style = "font-size: 19px;">Order No. {{ $order->no }}</strong></label>
                        </div>
                    </div>

                    @foreach ($groupedItems as $collectionKey => $collectionGroup)
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
                                                        <p style="font-size: 9pt"><b><a class="" href="{{ route('frontend.product',$cartItem->product->slug) }}">{{Str::limit($cartItem->product->name,40)}}</a></b></p>
                                                    </div>
                                                    {{--  <div class="col-12">
                                                        <p class="">
                                                            Price: {{ }}
                                                        </p>
                                                    </div>  --}}
                                                    <div class="col">
                                                        <p class="row pl-3">
                                                            QTY: {{ $cartItem->qty }}
                                                        </p>
                                                        <div class="text-info">
                                                            {{ $cartItem->subtotal }} &#2547;
                                                            <del class="text-danger ">
                                                                @if($cartItem->discount > 0)
                                                                    {{$cartItem->subtotal + $cartItem->discount}}&#2547;
                                                                @endif
                                                            </del>
                                                        </div>
                                                    </div>
                                                    @if($cartItem->discount > 0)
                                                        <div class="col-12">
                                                            <p> You saved {{ $cartItem->discount }} &#2547;</p>
                                                        </div>
                                                    @endif
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
                </div>
                <div class="col-12" style="font-size: 10pt">
                    <div class="row bg-white m-1 rounded shadow-sm">
                        <p class="col-12 text-center"><b>Summary</b></p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Payment Status
                                </span>
                                <span class="col-6 text-right {{ $order->payment_status == "Paid" ? 'text-success' : 'text-danger' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </div>
                        </p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Subtotal ({{ count($order->items) }} items)
                                </span>
                                <span class="col-6 text-right">
                                    {{ round($order->subtotal) }} TK
                                </span>
                            </div>

                        </p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Delivery Charge
                                </span>
                                <span class="col-6 text-right">
                                    {{$order->shipping_charge}} TK
                                </span>
                            </div>

                        </p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Coupon Discount
                                </span>
                                <span class="col-6 text-right">

                                    {{$order->user_coupon->value ?? 0}} TK
                                </span>
                            </div>

                        </p>
                        <p class="summary-item total">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Total
                                </span>
                                <span class="col-6 text-right">
                                    {{$order->total}} TK
                                </span>
                            </div>

                        </p>
                    </div><div class="row bg-white m-1 rounded shadow-sm">
                        <p class="col-12 text-center"><b>Billing Details</b></p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Customer Name
                                </span>
                                <span class="col-6 text-right">
                                    {{ ucwords($order->billing_address->name) }}
                                </span>
                            </div>
                        </p>
                        <p class="col-12">
                        <div class="row">
                                <span class="col-6 text-left">
                                    Payment Method
                                </span>
                            <span class="col-6 text-right">
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
                        </div>

                        </p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Address
                                </span>
                                <span class="col-12 text-right" style="font-size: 7pt; margin-right:0% !important;">
                                    {{ $order->billing_address->completeAddress }}
                                </span>
                            </div>

                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

