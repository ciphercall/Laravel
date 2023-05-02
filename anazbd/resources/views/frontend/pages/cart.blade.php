@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Cart
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart.css').'?v='.config()->get('version')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/cart-summary.css').'?v='.config()->get('version')}}">
    <style>

        .cart-area{
            margin: 0 20px 0px;

        }
    </style>
@endpush

@section('content')
    @include('frontend.loader.az-loader', ['left' => '50%'])

    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $cart = session()->get('cart');

        $mallItems = collect($cart->cart_items)->reject(function ($cartItem){
            return $cartItem->seller->is_anazmall_seller != true;
        });
        $otherItems = collect($cart->cart_items)->reject(function ($cartItem){
            return $cartItem->seller->is_premium != true;
        });

        $otherSellerItems = collect($cart->cart_items)->reject(function ($cartItem){
            return $cartItem->seller->is_anazmall_seller == true || $cartItem->seller->is_premium == true;
        });
        $otherSellerGroup = collect($otherSellerItems)->groupBy(function ($cartItem){
            return $cartItem->seller->name;
        });
        $mallGroup = collect($mallItems)->groupBy(function ($cartItem){
            return $cartItem->seller->name;
        });
        $OtherGroup = collect($otherItems)->groupBy(function ($cartItem){
            return $cartItem->seller->name;
        });
    @endphp


    <div class="cart_page_bg">
        <div class="container">

            <div class="row">
                <div class="col-8 item-area" style="padding-right: 0">


                    <!-- ANAZ SELLER ITEMS -->
                    @if($mallGroup->count() > 0)
                        <!-- SELECT ALL -->
                        <div class="cart-area row">
                            <div class="select-all-div">
                                <div class="select-all">
                                    <input type="checkbox" id="select-all">
                                    <label for="select-all">Select All</label>
                                </div>
                                <div>
                                    <h4>ANAZ EMPIRE</h4>
                                </div>
                                <div>
                                    <a class="remove-all" href="#"><i class="fa fa-trash"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        
                        @foreach($mallGroup as $shop_name => $group)
                        <div class="cart-area row seller-div">
                            <div class="seller-items">
                                <div class="seller-header">
                                    <div class="left">
                                        <input type="checkbox" id="shop-checkbox-{{$loop->iteration}}"
                                            class="seller-checkbox">
                                        <label for="shop-checkbox-{{$loop->iteration}}">{{$shop_name }}</label>
                                    </div>
                                </div>
                                <table>
                                    <tbody>
                                    
                                    @foreach($group as $cartItem)
                                    
                                     
                                    
                                        <tr class="item-row"
                                            data-cart-item="{{az_hash($cartItem->id)}}"
                                            data-cart-qty="{{$cartItem->qty}}">
                                            <td>
                                                <input type="checkbox"
                                                    class="item-checkbox" {{$cartItem->active ? 'checked' : ''}}>
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
                                                <div class="counter" data-item="{{$cartItem->id}}">
                                                    <button class="counter-decrease">&mdash;</button>
                                                    <input type="text"
                                                        class="counter-input"
                                                        value="{{$cartItem->qty ?? 1}}"
                                                        max="{{ $cartItem->product->max_orderable_qty }}"
                                                        data-max_limit="{{ $cartItem->product->max_orderable_qty }}">
                                                    <button class="counter-increase" data-limit={{ $cartItem->product->max_orderable_qty }}>+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" class="remove-item" title="Remove">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    @endif

                    <br>
                    <!-- SELLER ITEMS -->
                    @if($OtherGroup->count() > 0)
                        <!-- SELECT ALL -->
                        <div class="cart-area row">
                            <div class="select-all-div">
                                <div class="select-all">
                                    <input type="checkbox" id="select-all">
                                    <label for="select-all">Select All</label>
                                </div>
                                <div>
                                    <h4>ANAZ SPOTLIGHT</h4>
                                </div>
                                <div>
                                    <a class="remove-all" href="#"><i class="fa fa-trash"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        @foreach($OtherGroup as $shop_name => $group)
                        <div class="cart-area row seller-div">
                            <div class="seller-items">
                                <div class="seller-header">
                                    <div class="left">
                                        <input type="checkbox" id="shop-checkbox-{{$loop->iteration}}"
                                            class="seller-checkbox">
                                        <label for="shop-checkbox-{{$loop->iteration}}">{{$shop_name }}</label>
                                    </div>
                                </div>
                                <table>
                                    <tbody>
                                    @foreach($group as $cartItem)
                                        <tr class="item-row"
                                            data-cart-item="{{az_hash($cartItem->id)}}"
                                            data-cart-qty="{{$cartItem->qty}}">
                                            <td>
                                                <input type="checkbox"
                                                    class="item-checkbox" {{$cartItem->active ? 'checked' : ''}}>
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
                                                <div class="counter" data-item="{{$cartItem->id}}">
                                                    <button class="counter-decrease">&mdash;</button>
                                                    <input type="text"
                                                        class="counter-input"
                                                        value="{{$cartItem->qty ?? 1}}"
                                                        max="{{ $cartItem->product->max_orderable_qty }}"
                                                        data-max_limit="{{ $cartItem->product->max_orderable_qty }}">
                                                    <button class="counter-increase" data-limit={{ $cartItem->product->max_orderable_qty }}>+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" class="remove-item" title="Remove">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    <br>
                    <!-- Other SELLER ITEMS -->
                    @if($otherSellerGroup->count() > 0)
                        <!-- SELECT ALL -->
                        <div class="cart-area row">
                            <div class="select-all-div">
                                <div class="select-all">
                                    <input type="checkbox" id="select-all">
                                    <label for="select-all">Select All</label>
                                </div>
                                <div>
                                    <h4>Other Sellers</h4>
                                </div>
                                <div>
                                    <a class="remove-all" href="#"><i class="fa fa-trash"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        
                        @foreach($otherSellerGroup as $shop_name => $group)
                        <div class="cart-area row seller-div">
                            <div class="seller-items">
                                <div class="seller-header">
                                    <div class="left">
                                        <input type="checkbox" id="shop-checkbox-{{$loop->iteration}}"
                                            class="seller-checkbox">
                                        <label for="shop-checkbox-{{$loop->iteration}}">{{$shop_name }}</label>
                                    </div>
                                </div>
                                <table>
                                    <tbody>
                                    
                                    @foreach($group as $cartItem)
                                        <tr class="item-row"
                                            data-cart-item="{{az_hash($cartItem->id)}}"
                                            data-cart-qty="{{$cartItem->qty}}">
                                            <td>
                                                <input type="checkbox"
                                                    class="item-checkbox" {{$cartItem->active ? 'checked' : ''}}>
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
                                                <div class="counter" data-item="{{$cartItem->id}}">
                                                    <button class="counter-decrease">&mdash;</button>
                                                    <input type="text"
                                                        class="counter-input"
                                                        value="{{$cartItem->qty ?? 1}}"
                                                        max="{{ $cartItem->product->max_orderable_qty }}"
                                                        data-max_limit="{{ $cartItem->product->max_orderable_qty }}">
                                                    <button class="counter-increase" data-limit={{ $cartItem->product->max_orderable_qty }}>+</button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" class="remove-item" title="Remove">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>

                <div class="col-4" style="padding-left: 0;">
                    <div class="row summary-div">
                        <p class="summary">Summary</p>
                        <p class="summary-item subtotal">
                            <span class="left">
                                Subtotal ({{ $cart->cart_items->where('active',true)->count() }} items)
                            </span>
                            <span class="right">
                                {{ round($cart->subtotal ) }} TK
                            </span>
                        </p>
                        <p class="summary-item charge">
                            <span class="left">
                                Estimated Delivery Charge <br>
                            </span>
                            
                            <span class="right">
                                {{ $cart->delivery_charge }} TK
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
                                <span class="summary-coupon-input" style="flex: 15">Coupon: {{$cart->coupon}}</span>
                                <button type="button"
                                        class="summary-coupon-btn edit"
                                        style="flex: 1"
                                        title="Edit Coupon">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                            <div class="editable" style="display: {{$cart->coupon ? 'none' : 'flex'}}">
                                <input type="text"
                                       class="summary-coupon-input"
                                       placeholder="Enter coupon"
                                       value="{{$cart->coupon}}">
                                <button type="button" class="summary-coupon-btn apply">Apply</button>
                            </div>
                        </div>
                        <p class="summary-item total">
                            <span class="left">
                                Total
                            </span>
                            <span class="right">
                                {{$cart->total}} TK <br>
                                <small class="text-muted">* Vat Included</small>
                            </span>
                        </p>
                        <div class="summary-checkout">
                            <a href="{{ route('frontend.checkout.index') }}" type="button" class="checkout-btn">Proceed to Checkout</a>
                        </div>
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
                const limit = Number($(this).data("limit"));
                let val = limit, prev = Number(input.val());
                if (Number(input.val()) < limit)
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
                const limit = $(this).data("max_limit");
                if (isNaN(val) || val < 1)
                    val = '';
                else if (val > limit)
                    val = limit;
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
                    if(res.status){
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
                    }else{
                        swal({
                            buttons: false,
                            timer: 2000,
                            icon: 'error',
                            title: 'Failed.',
                            text: "Maximum Valid quantity is "+limit,
                            
                        });
                    }
                    
                    toggleAZLoader();
                });
            }

            function couponUpdateRequest(coupon) {
                toggleAZLoader();
                $.post('{{route('frontend.cart.apply-coupon.ajax')}}', {
                    coupon: coupon
                }, function (res) {
                    location.reload();
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
                    location.reload();
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
                $('.summary-item.subtotal .right').text(res.subtotal + ' TK');
                $('.summary-item.charge .right').text(res.deliveryCharge + ' TK');
                $('.summary-item.discount .right').text(res.couponDiscount + ' TK');
                $('.summary-item.vat .right').text(res.vat + ' TK');
                $('.summary-item.total .right').text(res.total + ' TK');

                if (res.coupon && res.is_coupon_applied) {
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
