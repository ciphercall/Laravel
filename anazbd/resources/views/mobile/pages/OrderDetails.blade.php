@extends('mobile.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Order Details
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

                                    - {{$order->user_coupon->value ?? 0}} TK
                                </span>
                            </div>

                        </p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Redeem Discount
                                </span>
                                <span class="col-6 text-right">

                                    - {{$order->point_redeem->value ?? 0}} TK
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
                        @if ($order->partial_payment)

                        <p class="summary-item">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Paid
                                </span>
                                <span class="col-6 text-right text-success">
                                    {{$order->partial_payment_amount}} TK
                                </span>
                            </div>
                        </p>
                        <p class="summary-item total">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Remaining Total
                                </span>
                                <span class="col-6 text-right text-danger">
                                    {{$order->total - $order->partial_payment_amount}} TK
                                </span>
                            </div>
                        </p>
                            
                        @endif
                    </div>
                    <div class="row bg-white m-1 rounded shadow-sm">
                        <p class="col-12 text-center"><b>Billing Details</b></p>
                        <p class="col-12">
                            <div class="row">
                                <span class="col-6 text-left">
                                    Customer Name
                                </span>
                                <span class="col-6 text-right">
                                    {{ ucwords(auth()->user()->name) }}
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
                                    {{ $order->delivery_address ? $order->delivery_address->completeAddress : $order->billing_address->completeAddress }}
                                </span>
                            </div>

                        </p>
{{--                        <p class="col-12">--}}
{{--                            <div class="row">--}}
{{--                            --}}
{{--                            </div>--}}
{{--                            <span class="col-6 text-left">--}}
{{--                                Phone Number--}}
{{--                            </span>--}}
{{--                            <span class="col-6 text-right">--}}

{{--                            </span>--}}
{{--                        </p>--}}

{{--                        <p class="col-12">--}}
{{--                            <div class="row">--}}
{{--                            <span class="col-6 text-left">--}}
{{--                                Billing Address--}}
{{--                            </span>--}}
{{--                            <span class="col-6 text-right" style="font-size: 9px;margin-right:0% !important;">--}}
{{--                                {{ $order->billing_address->completeAddress }}--}}
{{--                            </span>--}}
{{--                            </div>--}}
{{--                        </p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('.counter-increase').on('click', function (e) {
                const input = $(this).parent().find('input');
                let val = 99, prev = Number(input.val());
                if (Number(input.val()) < 99)
                    val = Number(input.val()) + 1;
                input.val(val);
                if (val !== prev)
                    counterUpdateRequest(this, val);
            });
            $('.counter-decrease').on('click', function (e) {
                const input = $(this).parent().find('input');
                let val = 1, prev = Number(input.val());
                if (Number(input.val()) > 1)
                    val = Number(input.val()) - 1;
                input.val(val);
                if (val !== prev)
                    counterUpdateRequest(this, val);
            });
            $('.counter-input').on('input', function (e) {
                let val = $(this).val().substring(0, 2);
                if (isNaN(val) || val < 1)
                    val = '';
                else if (val > 99)
                    val = 99;
                $(this).val(val)
                if (val > 0)
                    counterUpdateRequest(this, val);
            });

            $('#select-all').on('change', function () {
                const checked = $(this).prop('checked');
                const cartItems = [];
                const actives = [];
                $(this).closest('.item-area').find('input[type=checkbox].seller-checkbox').each(function () {
                    $(this).prop('checked', checked);
                });
                $(this).closest('.item-area').find('input[type=checkbox].item-checkbox').each(function () {
                    $(this).prop('checked', checked);
                    cartItems.push($(this).closest('tr').data('cart-item').toString().trim());
                    actives.push(checked);
                });
                statusUpdateRequest(cartItems, actives);
            });
            $('.seller-checkbox').on('change', function () {
                const checked = $(this).prop('checked');
                const table = $(this).closest('.seller-items').find('table');
                const cartItems = [];
                const actives = [];
                table.find('input[type=checkbox]').each(function () {
                    cartItems.push($(this).closest('tr').data('cart-item').toString().trim());
                    actives.push(checked);
                    $(this).prop('checked', checked);
                });
                $('#select-all').prop('checked', allChecked());
                statusUpdateRequest(cartItems, actives);
            });
            $('.item-checkbox').on('change', function () {
                const tbody = $(this).closest('tbody');
                let flag = true;
                const cartItems = [];
                const actives = [];
                tbody.find('input[type=checkbox]').each(function () {
                    cartItems.push($(this).closest('tr').data('cart-item').toString().trim());
                    actives.push($(this).prop('checked'));

                    if (!$(this).prop('checked')) {
                        flag = false;
                        return 0;
                    }
                });
                $(this).closest('.seller-items').find('.seller-checkbox').prop('checked', flag);

                if (flag) {
                    flag = allChecked();
                }
                $('#select-all').prop('checked', flag);
                statusUpdateRequest(cartItems, actives);
            });

            $('.remove-item').on('click', function () {
                const cartItems = [];
                cartItems.push($(this).closest('tr').data('cart-item').toString().trim());
                destroyRequest(cartItems);
            })
            $('.remove-all').on('click', function (e) {
                e.preventDefault();
                if ($('#select-all').prop('checked')) {
                    const cartItems = [];
                    $('tr.item-row').each(function () {
                        cartItems.push($(this).data('cart-item').toString().trim());
                    })
                    destroyRequest(cartItems);
                }
            })

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

            $('.checkout-btn').on('click', function (e) {
                e.preventDefault();
                if (anyChecked())
                    window.location.href = $(this).attr('href');
            });


            function counterUpdateRequest(el, val) {
                const tr = $(el).closest('tr');
                const cart_qty = Number(tr.data('cart-qty').toString().trim());
                if (cart_qty === Number(val))
                    return 0;
                toggleAZLoader();
                const cart_item = tr.data('cart-item').toString().trim();
                $.post('{{route('frontend.cart.update.ajax')}}', {
                    cart_item: cart_item,
                    qty: val
                }, function (res) {
                    if (!res.sale_percentage) {
                        tr.find('.last-price').html(res.original_subtotal == null ? '&mdash;' : (res.original_subtotal + ' TK'));
                        try {
                            tr.find('.original-price').html('');
                            tr.find('.percentage').html('');
                        } catch (e) {
                        }
                    } else {
                        tr.find('.original-price').html(res.original_subtotal == null ? '&mdash;' : (res.original_subtotal + ' TK'));
                        tr.find('.last-price').html(res.sale_subtotal == null ? '&mdash;' : (res.sale_subtotal + ' TK'));
                        tr.find('.percentage').html(res.sale_percentage == null ? '&mdash;' : ('-' + res.sale_percentage + '%'));
                    }
                    tr.data('cart-qty', val);
                    setupSummary(res);
                    toggleAZLoader();
                });
            }

            function couponUpdateRequest(coupon) {
                toggleAZLoader();
                $.post('{{route('frontend.cart.apply-coupon.ajax')}}', {
                    coupon: coupon
                }, function (res) {
                    setupSummary(res);
                    toggleAZLoader();
                })
            }

            function statusUpdateRequest(items, statuses) {
                toggleAZLoader();
                $.post('{{route('frontend.cart.update-status.ajax')}}', {
                    cart_items: $.extend({}, items),
                    actives: $.extend({}, statuses),
                }, function (res) {
                    setupSummary(res);
                    if (res.prices.length) {
                        res.prices.forEach(function (p) {
                            const tr = $('tr[data-cart-item="' + p.item + '"]');
                            if (p.sale_percentage === 0 || p.sale_percentage === null) {
                                tr.find('.last-price').html(p.original_subtotal == null ? '&mdash;' : (p.original_subtotal + ' TK'));
                                try {
                                    tr.find('.original-price').html('');
                                    tr.find('.percentage').html('');
                                } catch (e) {
                                }
                            } else {
                                tr.find('.original-price').html(p.original_subtotal == null ? '&mdash;' : (p.original_subtotal + ' TK'));
                                tr.find('.last-price').html(p.sale_subtotal == null ? '&mdash;' : (p.sale_subtotal + ' TK'));
                                tr.find('.percentage').html(p.sale_percentage == null ? '&mdash;' : ('-' + p.sale_percentage + '%'));
                            }
                        });
                    }
                    toggleAZLoader();
                });
            }

            function destroyRequest(items) {
                toggleAZLoader();
                const trList = $('tr.item-row');
                $.post('{{route('frontend.cart.destroy.ajax')}}', {
                    cart_items: $.extend({}, items),
                }, function (res) {
                    trList.each(function () {
                        if (items.includes($(this).data('cart-item').toString().trim())) {
                            $(this).remove();
                        }
                    })

                    $('tbody').each(function () {
                        if ($(this).find('tr').length === 0)
                            $(this).closest('.seller-div').remove();
                    });
                    $('.cart_count').text(res.count);
                    setupSummary(res);
                    toggleAZLoader();
                });
            }

            function setupSummary(res) {
                $('.summary-item.subtotal .left').text('Subtotal (' + res.activeCount + ' items)');
                $('.summary-item.subtotal .right').text(res.subtotalWithoutCoupon + ' TK');
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

            const itemArea = $('.item-area');

            function allChecked() {
                let flag = true;
                itemArea.find('input[type=checkbox].item-checkbox').each(function () {
                    if (!$(this).prop('checked')) {
                        flag = false;
                        return 0;
                    }
                });
                return flag;
            }

            function anyChecked() {
                let flag = false;
                itemArea.find('input[type=checkbox].item-checkbox').each(function () {
                    if ($(this).prop('checked')) {
                        flag = true;
                        return 0;
                    }
                });
                return flag;
            }
        });
    </script>
@endpush
