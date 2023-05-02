@extends('backend.layouts.master')
@section('title', 'Edit Order')
@section('page-header')
    <i class="fa fa-plus"></i> Edit Order
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        /****************/
        .ck-editor__editable {
            min-height: 250px !important;
        }

        .ck-editor__editable:nth-of-type(1) {
            margin-bottom: 20px;
        }

        /****************/
        table th, table td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .small-input {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .small-input input {
            width: 100px;
        }

        .maximize {
            margin-top: -13px;
            margin-bottom: -12px;
            position: relative;
        }

        .maximize table {
            margin-bottom: 0;
        }

        /****************/
        .widget-box {
            margin-bottom: 20px;
            box-shadow: 0 0 4px #d7d7d7;
            border: none;
        }

        .widget-header {
            font-size: 14px;
            border-bottom: 1px solid #eee;
            /* background: #5877b8; */
            background: #8e8f92bf;
        }

        .widget-title {
            color: white;
        }

        .widget-toolbar > .nav-tabs > li:not(.active) > a {
            color: white;
        }

        label {
            color: #5c5c5c;
        }

        .chosen-select.color + .chosen-container a.chosen-single {
            min-width: 120px;
        }

        .chosen-select.size + .chosen-container a.chosen-single {
            min-width: 112px;
        }
    </style>
@endpush
@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Pending List',
       'route' => route('backend.order.pending.index')
    ])

    <form role="form"
          method="post"
          class="form-horizontal"
          enctype="multipart/form-data"
          action="{{route('backend.order.pending.update', $order->id)}}">
    @csrf
    <!-- Summary -->
    <div class="widget-box" id="summary" style="width: 30%; margin-left: auto">
        <div class="widget-header widget-header-blue widget-header-flat">
            <h4 class="widget-title">Summary</h4>
            <div class="widget-toolbar">
                <a href="#" data-action="collapse" class="white">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main" style="margin-bottom: 20px">
                <div class="row" style="display: flex; justify-content: center">
                    <div class="col-md-12">
                        <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                            <span>Order No:</span>
                            <span class="stat-subtotal">&emsp;{{$order->no}}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Subtotal:</span>
                            <span class="stat-subtotal">{{round($order->seller_subtotal)}} TK</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>VAT & Other Charges:</span>
                            <span class="stat-vat">{{round($order->total - $order->seller_total - $order->shipping_charge)}} TK</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px; padding-bottom: 4px; border-bottom: 1px solid #ddd">
                            <span>Coupon:</span>
                            <span class="stat-coupon">- {{round($order->user_coupon->value ?? 0)}} TK</span>
                        </div>

                        <div style="display: flex; justify-content: space-between">
                            <span>Total:</span>
                            <span class="stat-total">{{round($order->subtotal)}} TK</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #ddd"">
                            <span>Delivery:</span>
                            <span class="stat-delivery">{{round($order->shipping_charge)}} TK</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; ">
                            <span>Grand Total:</span>
                            <span class="stat-total">{{round($order->total)}} TK</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Billing -->
        <div class="widget-box" id="billing">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title">Billing Information</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse" class="white">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="name">
                                    Name <sup class="red">*</sup>
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control input-sm"
                                           id="name"
                                           name="name"
                                           placeholder="Name"
                                           type="text"
                                           value="{{$order->billing_address->name}}">
                                    <strong class="red">{{$errors->first('name')}}</strong>
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="mobile">
                                    Mobile <sup class="red">*</sup>
                                </label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <input class="form-control input-sm"
                                               id="mobile"
                                               name="mobile"
                                               placeholder="Mobile no"
                                               type="text"
                                               value="{{$order->billing_address->mobile}}">
                                    </div>
                                    <strong class="red">{{$errors->first('mobile')}}</strong>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="email">
                                    Email <sup class="red">*</sup>
                                </label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <input class="form-control input-sm"
                                               id="email"
                                               name="email"
                                               placeholder="Email address"
                                               type="text"
                                               value="{{$order->billing_address->email}}">
                                    </div>
                                    <strong class="red">{{$errors->first('email')}}</strong>
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="note">
                                    Note
                                </label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <textarea class="form-control input-sm"
                                                  id="note"
                                                  name="note"
                                                  placeholder="Order related instruction"
                                                  rows="3">{{$order->note}}</textarea>
                                    </div>
                                    <strong class="red">{{$errors->first('note')}}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Division -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="division">Division <sup
                                        class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Division -"
                                                id="division"
                                                name="division">
                                            <option value=""></option>
                                            @foreach($divisions as $division)
                                                <option value="{{$division->id}}"
                                                    {{$division->id == $order->billing_address->division_id ? 'selected' : ''}}>
                                                    {{$division->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('division')}}</strong>
                                </div>
                            </div>

                            <!-- City -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="city">City <sup
                                        class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- City -"
                                                id="city"
                                                name="city">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('city')}}</strong>
                                </div>
                            </div>

                            <!-- Area -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="area">Area</label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Area -"
                                                id="area"
                                                name="area">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('area')}}</strong>
                                </div>
                            </div>

                            <!-- Address L1 -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="address_l1">
                                    Address L1 <sup class="red">*</sup>
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control input-sm"
                                           id="address_l1"
                                           name="address_l1"
                                           placeholder="Street address"
                                           type="text"
                                           value="{{$order->billing_address->address_line_1}}">
                                    <strong class="red">{{$errors->first('address_l1')}}</strong>
                                </div>
                            </div>

                            <!-- Address L2 -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="address_l2">
                                    Address L2
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control input-sm"
                                           id="address_l2"
                                           name="address_l2"
                                           placeholder="Apartment, floor"
                                           type="text"
                                           value="{{$order->billing_address->address_line_2}}">
                                    <strong class="red">{{$errors->first('address_l2')}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="widget-box" id="items">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title">Items</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse" class="white">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="maximize">
                            <table class="table table-bordered text-center" id="items-table">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Shop</th>
                                    <th>Item</th>
                                    <th>Variant</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Delivery Cost</th>
                                    {{--  <th>Seller Price</th>
                                    <th>Seller Subtotal</th>  --}}
                                    <th>Sub Total</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sub = 0;
                                    $isDhaka = az_is_dhaka($order->billing_address->city_id);
                                    $mallGroup = $order->details->groupBy(function($detail){
                                        if($detail->seller->is_anazmall_seller == true){
                                            return "Anaz Empire";
                                        }else{
                                            return "Anaz Spotlight";
                                        }
                                    });
                                @endphp
                                @foreach($mallGroup as $shop => $orderDetails)
                                @php
                                    $attachedRowspan = false;
                                    $deliveryCostAttached = false;
                                    $empireDeliveryCost = 0;
                                @endphp
                                    @foreach($orderDetails as $detail)
                                        @php
                                            $grouped = $orderDetails->map(function($detail){
                                                return $detail->items->count();
                                            });
                                            $spotlightRowAttached = false;
                                            $deliveryCost = 0;
                                            if($shop = "Anaz Spotlight"){
                                                foreach($detail->items as $item){
                                                    $cost = $isDhaka ? $item->product->delivery_size->customer_dhaka : $item->product->delivery_size->customer_other;
                                                    if($cost > $deliveryCost){
                                                        $deliveryCost = $cost;
                                                    }
                                                };
                                            }
                                        @endphp
                                        @foreach($detail->items as $item)
                                       
                                            <tr class="{{ $shop == "Anaz Empire" ? 'warning' : 'info' }}">
                                                @php
                                                    $cost = $isDhaka ? $item->product->delivery_size->customer_dhaka : $item->product->delivery_size->customer_other;
                                                    if($shop == "Anaz Empire"){
                                                        $empireDeliveryCost += $deliveryCost < $cost ? $cost : $deliveryCost;
                                                    }
                                                @endphp
                                                @if ($attachedRowspan == false)
                                                    @php
                                                        $attachedRowspan = true;
                                                    @endphp
                                                    <td rowspan="{{ $grouped->sum() }}">{{ $shop }}</td>
                                                @endif
                                                <td style="max-width: 200px">
                                                    <select class="chosen-select shops"
                                                            name="sellers[]"
                                                            data-placeholder="- Shop -">
                                                        <option value=""></option>
                                                        @foreach($sellers as $seller)
                                                            <option value="{{$seller->id}}"
                                                                {{$detail->seller_id == $seller->id ? 'selected' : ''}}>
                                                                {{$seller->shop_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="max-width: 200px">
                                                    <select class="chosen-select items"
                                                            name="items[{{$detail->seller_id}}][]"
                                                            data-placeholder="- Item -">
                                                        <option value=""></option>
                                                        <option value="{{$item->item_id}}"
                                                                data-vat="{{$item->product->sub_category->vat}}"
                                                                selected>
                                                            {{$item->product->name}}
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="chosen-select variants"
                                                            name="variants[{{$item->item_id}}][]"
                                                            data-placeholder="- Variant -">
                                                        <option value=""></option>
                                                        @foreach($item->product->variants as $variant)
                                                            <option value="{{$variant->id}}"
                                                                    data-price="{{$item->product->getPriceAttribute($variant, $order->order_time)}}"
                                                                {{$variant->id == $item->variant_id ? 'selected' : ''}}>
                                                                @if($variant->color && $variant->size)
                                                                    {{$variant->color->name . ' - ' . $variant->size->name}}
                                                                @elseif($variant->color)
                                                                    {{$variant->color->name}}
                                                                @elseif($variant->size)
                                                                    {{$variant->size->name}}
                                                                @else
                                                                    Default
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="small-input">
                                                    <input class="input-sm text-center qty"
                                                        type="text"
                                                        name="qty[{{$item->variant_id}}]"
                                                        required
                                                        placeholder="0"
                                                        value="{{round($item->qty)}}">
                                                </td>
                                                <td class="small-input">
                                                    <input class="input-sm text-center price"
                                                        name="prices[{{$item->variant_id}}]"
                                                        type="text"
                                                        required
                                                        placeholder="0"
                                                        value="{{round($item->price)}}">
                                                </td>

                                                @if($deliveryCostAttached == false && $shop == "Anaz Empire")
                                                    @dd($grouped->sum())
                                                    <td class="small-input" rowspan="{{ $grouped->sum() }}">
                                                        {{ $empireDeliveryCost }}
                                                    </td>
                                                    @php $deliveryCostAttached = true @endphp
                                                @elseif ($spotlightRowAttached == false && $shop == "Anaz Spotlight")
                                                    <td class="small-input" rowspan="{{ $detail->items->count() }}">
                                                        {{ $deliveryCost }}
                                                    </td>
                                                    @php $spotlightRowAttached = true @endphp
                                                @endif
                                                {{--  <td class="small-input">
                                                    <input class="input-sm text-center price"
                                                        name="seller_price[{{$item->variant_id}}]"
                                                        type="text"
                                                        required
                                                        placeholder="0"
                                                        value="{{round($item->seller_price)}}">
                                                </td>
                                                <td class="small-input">
                                                    <input class="input-sm text-center price"
                                                        name="seller_subtotal[{{$item->variant_id}}]"
                                                        type="text"
                                                        required
                                                        placeholder="0"
                                                        value="{{round($item->seller_subtotal)}}">
                                                </td>  --}}
                                                <td>
                                                    <span class="subtotal">{{round($item->subtotal)}}</span>
                                                    @php
                                                        $sub += round($item->subtotal);
                                                    @endphp
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm btn-corner">
                                                        <button type="button" onclick="deleteRow(this)"
                                                                class="btn btn-sm btn-danger"><span
                                                                class="bolder">-</span></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td colspan="7">
                                    </td>
                                    <td class="total">{{$sub}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-group text-right" style="height: 100px">
            <div class="col-md-6">
            </div>
            <div class="col-md-6 text-right">
                <a href="{{route('backend.order.status.cancel', [$order->id, 'Pending'])}}"
                   class="btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i> Cancel
                </a>

                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fa fa-save"></i> Send to Sellers
                </button>

                <a class="btn btn-sm btn-gray" href="{{route('backend.order.pending.index')}}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </form>

@endsection

@push('js')
    <script src="{{asset('assets/js/ckeditor.js')}}"></script>
    <script>
        $(document).ready(() => {

            ////////////// jquery configuration
            chosen_trigger()

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            })

            autosize($('textarea'))

            ////////////// ajax
            const division = $('#division');
            const city = $('#city');
            const area = $('#area');
            division.change(function () {
                city.empty();
                city.append($('<option>', {
                    value: '',
                    text: ''
                }));

                area.empty();
                area.append($('<option>', {
                    value: '',
                    text: ''
                }));
                city.val('').trigger('chosen:updated');
                area.val('').trigger('chosen:updated');

                let division_id = $(this).val().toString().trim();
                if (division_id > 0) {
                    $.get('{{route("backend.order.cities.ajax", 100)}}'.replace('100', division_id), function (res) {
                        res.cities.forEach(function (c, i) {
                            city.append($('<option>', {
                                value: c.id,
                                text: c.name,
                            }));
                        });
                        const city_id = division_id == {{$order->billing_address->division_id}} ? {{$order->billing_address->city_id}} : res.cities[0].id;
                        city.val(city_id).trigger('chosen:updated');

                        $.get('{{route("backend.order.areas.ajax", 100)}}'.replace('100', city_id), function (res) {
                            res.areas.forEach(function (a, i) {
                                area.append($('<option>', {
                                    value: a.id,
                                    text: a.name,
                                }));
                            });

                            const area_id = city_id == {{$order->billing_address->city_id}} ? {{$order->billing_address->post_code_id ?? '0'}} : res.areas[0].id;
                            area.val(area_id).trigger('chosen:updated');
                        });
                    });
                }
            });

            division.val('{{$order->billing_address->division_id}}').trigger('change');

            city.change(function () {
                area.empty();
                area.append($('<option>', {
                    value: '',
                    text: ''
                }));
                area.val('').trigger('chosen:updated');

                const id = $(this).val().toString().trim()
                if (id > 0) {
                    $.get('{{route("backend.order.areas.ajax", 100)}}'.replace('100', id), function (res) {
                        res.areas.forEach(function (a, i) {
                            area.append($('<option>', {
                                value: a.id,
                                text: a.name,
                            }));
                        });
                        area.val(res.areas[0].id).trigger('chosen:updated');
                    });
                }
            });

            $('.chosen-select.shops').change(shopChanged);
            $('.chosen-select.items').change(itemChanged);
            $('.chosen-select.variants').change(variantChanged);
            $('input.price').on('input', updateSubtotal);
            $('input.qty').on('input', updateSubtotal);
        });

        function resetRow(tr, excludes = []) {
            if (!excludes.includes('product')) {
                const product = tr.find('.chosen-select.items');
                product.empty();
                product.append($('<option>', {
                    value: '',
                    text: ''
                }));
                product.val('').trigger('chosen:updated');
            }

            if (!excludes.includes('variants')) {
                const variants = tr.find('.chosen-select.variants');
                variants.empty();
                variants.append($('<option>', {
                    value: '',
                    text: ''
                }));
                variants.val('').trigger('chosen:updated');
            }

            if (!excludes.includes('qty')) {
                const qty = tr.find('.qty');
                qty.val('');
            }

            if (!excludes.includes('price')) {
                const price = tr.find('.price');
                price.val('0');
            }

            if (!excludes.includes('subtotal')) {
                const subtotal = tr.find('.subtotal');
                subtotal.text('0');
            }
        }

        function shopChanged() {
            let id = $(this).val();
            const tr = $(this).closest('tr');
            resetRow(tr, ['qty']);

            const product = tr.find('.chosen-select.items');
            product.attr('name', `items[${id}][]`);

            if (id > 0) {
                $.get('{{route('backend.order.products.ajax', 999)}}'.replace('999', id), function (res) {
                    res.products.forEach(function (p, i) {
                        product.append(`<option value="${p.id}" data-vat=${p.vat} ${i === 0 ? 'selected' : ''}>${p.name}</option>`)
                    });
                    product.val(res.products[0].id).trigger('chosen:updated');
                    product.trigger('change');
                });
            }
        }

        function itemChanged() {
            let id = $(this).val();
            const tr = $(this).closest('tr');
            resetRow(tr, ['shops', 'product', 'qty']);

            const variants = tr.find('.chosen-select.variants');
            variants.attr('name', `variants[${id}][]`);

            if (id > 0) {
                $.get(`/sadmin/orders/variants/${id}/` + '{{$order->id}}', function (res) {
                    const price = tr.find('input.price');
                    res.variants.forEach(function (v, i) {
                        variants.append(`<option value="${v.id}" data-price="${v.price}" ${i === 0 ? 'selected' : ''}>${v.name}</option>`)
                        price.val(v.price);
                    })
                    variants.val(res.variants[0].id).trigger('chosen:updated');
                    variants.trigger('change');
                });
            }
        }

        function variantChanged() {
            let id = $(this).val();
            const tr = $(this).closest('tr');
            resetRow(tr, ['shops', 'product', 'variants', 'qty']);

            tr.find('input.qty').attr('name', `qty[${id}]`);
            tr.find('input.price').attr('name', `prices[${id}]`);

            if (id > 0) {
                const price = tr.find('input.price');
                price.val($(this).find(':selected').data('price').toString().trim());
            }
            $('#items-table input.price').eq(0).trigger('input');
        }

        function updateSubtotal() {
            const trList = $('#items-table tbody tr');
            let total = 0;
            trList.each(function (i) {
                if (i === trList.length - 1) {
                    $(this).find('.total').text(total);
                }

                const price = $(this).find('.price').val();
                const qty = $(this).find('.qty').val();
                const subtotal = price * qty;
                $(this).find('.subtotal').text(subtotal);
                total += subtotal;
            });
        }

        function shouldGenRow() {
            let flag = true;
            $('.chosen-select.shops').each(function () {
                if ($(this).val().toString() === '')
                    flag = false;
            });
            $('.chosen-select.items').each(function () {
                if ($(this).val().toString() === '')
                    flag = false;
            });
            $('.chosen-select.variants').each(function () {
                if ($(this).val().toString() === '')
                    flag = false;
            });
            $('.chosen-select.qty').each(function () {
                if (isNaN($(this).val()))
                    flag = false;
            });
            $('.chosen-select.price').each(function () {
                if (isNaN($(this).val()))
                    flag = false;
            });
            return flag;
        }

        let rowId = 1;

        function genRow() {
            if (!shouldGenRow())
                return;

            const template = `
<tr>
    <td style="max-width: 200px">
        <select class="chosen-select shops"
                name="sellers[]"
                data-placeholder="- Shop -">
                <option value=""></option>
            @foreach($sellers as $seller)
            <option value="{{$seller->id}}">
                {{$seller->shop_name}}
            </option>
            @endforeach
            </select>
        </td>
        <td style="max-width: 200px">
            <select class="chosen-select items"
                    data-placeholder="- Item -">
                <option value=""></option>
            </select>
        </td>
        <td>
            <select class="chosen-select variants"
                    data-placeholder="- Variant -">
                <option value=""></option>
            </select>
        </td>
        <td class="small-input">
            <input class="input-sm text-center qty"
                   type="text"
                   required
                   placeholder="0"
                   value="1">
        </td>
        <td class="small-input">
            <input class="input-sm text-center price"
                   type="text"
                   required
                   placeholder="0">
        </td>
        <td></td>
        <td></td>
        <td>
            <span class="subtotal">0</span>
        </td>
        <td>
            <div class="btn-group btn-group-sm btn-corner">
                <button type="button" onclick="genRow()"
                        class="btn btn-sm btn-primary"><span
                        class="bolder">+</span>
                </button>
                <button type="button" onclick="deleteRow(this)"
                        class="btn btn-sm btn-danger"><span
                        class="bolder">-</span></button>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="5">
        </td>
        <td class="total">{{$sub}}</td>
    </tr>`;
            rowId++;
            const tbody = $('#items-table tbody');
            tbody.find('.total').closest('tr').remove();
            tbody.append(template)
                .on('change', '.chosen-select.shops', shopChanged)
                .on('change', '.chosen-select.items', itemChanged)
                .on('change', '.chosen-select.variants', variantChanged)
                .on('input', 'input.price', updateSubtotal)
                .on('input', 'input.qty', updateSubtotal);

            chosen_trigger();
        }

        function deleteRow(el) {
            if ($('#items-table tbody').find('tr').length > 2) {
                $(el).closest('tr').remove();
            }
        }

        function chosen_trigger() {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({
                            'width': '100%',
                        });
                    })
                }).trigger('resize.chosen');
            } else {
                $('.chosen-select').css('width', '100%');
            }
        }

        function round(num, precision = 0) {
            return parseFloat((Math
                .round((num * Math.pow(10, precision)) + ((num >= 0 ? 1 : -1) * 0.0001)) / Math.pow(10, precision))
                .toFixed(precision));
        }
    </script>
@endpush
