@extends('backend.layouts.master')
@section('title', 'Edit Item')
@section('page-header')
    <i class="fa fa-plus"></i> Edit Item
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        /****************/
        .modal-open{
            z-index: 100;
            opacity: 0.5;
        }

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
            background: #5877b8;
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

        .modal {
            z-index: 1050;
        }

        .modal-body .col {
            width: 55%;
            margin: auto;
            text-align: left;
        }

        @media (min-width: 768px) {
            .modal-dialog {
                width: 400px;
            }
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
       'name' => 'Item List',
       'route' => route('backend.product.items.unpublished.index')
    ])

    <form role="form"
          method="post"
          class="form-horizontal"
          enctype="multipart/form-data"
          action="{{route('backend.product.items.update', $item->id)}}">
    @csrf

    <!-- BASIC -->
        <div class="widget-box" id="basic">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title">Basic Information</h4>
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
                                    Product Name <sup class="red">*</sup>
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control input-sm"
                                           id="name"
                                           name="name"
                                           placeholder="Name"
                                           type="text"
                                           value="{{$item->name}}">
                                    <strong class="red">{{$errors->first('name')}}</strong>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="category_id">Category
                                    <sup class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select
                                            class="chosen-select form-control"
                                            data-placeholder="- Category - "
                                            name="category_id"
                                            id="category_id">
                                            <option></option>

                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"
                                                    {{$item->category_id == $category->id ? 'selected' : ''}}>
                                                    {{$category->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('category_id')}}</strong>
                                </div>
                            </div>

                            <!-- Sub Category -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="sub_category_id">Sub
                                    Category
                                    <sup class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Sub Category -"
                                                id="sub_category_id"
                                                name="sub_category_id">
                                            <option value=""></option>

                                            @foreach($sub_categories as $sub_category)
                                                <option value="{{$sub_category->id}}"
                                                    {{$item->sub_category_id == $sub_category->id ? 'selected' : ''}}>
                                                    {{$sub_category->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('sub_category_id')}}</strong>
                                </div>
                            </div>

                            <!-- Child Category -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="child_category_id">Child
                                    Category
                                </label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Child Category -"
                                                id="child_category_id"
                                                name="child_category_id">
                                            <option value=""></option>

                                            @foreach($child_categories as $child_category)
                                                <option value="{{$child_category->id}}"
                                                    {{$item->child_category_id == $child_category->id ? 'selected' : ''}}>
                                                    {{$child_category->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('child_category_id')}}</strong>
                                </div>
                            </div>

                            <!-- status -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="status">
                                    Status
                                </label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Status -"
                                                id="status"
                                                name="status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('status')}}</strong>
                                </div>
                            </div>

                            @php
                                $tag_ids = collect($item->tags)->pluck('id')->toArray();
                            @endphp
                            {{-- tag --}}
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="tag_ids">Tags</label>

                                <div class="col-sm-9">
                                    <div class="text-center">
                                        <textarea name="tags" id="" cols="30" rows="5" class="form-control">{{ $item->tags->implode('name',',') }}</textarea>
                                                <small class="text-muted">Ex: Badam, Peanut, pesta</small>
                                        {{-- <select class="chosen-select"
                                                multiple
                                                id="tag_ids"
                                                name="tag_ids[]"
                                                data-placeholder="Select Tags">
                                            @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, $tag_ids) ? 'selected' : ''}}>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    <strong class="red">{{ $errors->first('tag_ids') }}</strong>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="">Make Online Payable Only</label>

                                {{-- <label class="col-md-3 control-label no-padding-right" for="digital_sheba">Digital Sheba</label> --}}
                                <div class="col-md-1">
                                    <input type="checkbox" id="digital_sheba" name="is_online_pay_only" {{$item->is_online_pay_only ? 'checked' : ''}} style="margin-top: 9px">
                                    <strong class="red">{{$errors->first('digital_sheba')}}</strong>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="">Online Payable Type</label>

                                <div class="col-sm-9">
                                    <div class="text-center">
                                        <select name="online_payable_type" id="" class="form-control">
                                            <option>Select Payable Type</option>
                                            <option value="delivery_charge" @if ($item->online_payable_type == "delivery_charge") selected='selected' @endif>Delivery Charge</option>
                                            <option value="half_pay" @if ($item->online_payable_type == "half_pay") selected='selected' @endif>Half Payment</option>
                                            <option value="full_pay" @if ($item->online_payable_type == "full_pay") selected='selected' @endif>Full Payment</option>
                                        </select>
                                    </div>
                                    <strong class="red">{{ $errors->first('online_payable_type') }}</strong>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <!-- Brand -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="brand_id">Brand <sup
                                        class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Brand -"
                                                id="brand_id"
                                                name="brand_id">
                                            <option value=""></option>

                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}"
                                                    {{$item->brand_id == $brand->id ? 'selected' : ''}}>
                                                    {{$brand->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('brand_id')}}</strong>
                                </div>
                            </div>

                            <!-- Unit -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="unit_id">Unit <sup
                                        class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Unit -"
                                                id="unit_id"
                                                name="unit_id">
                                            <option value=""></option>


                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}"
                                                    {{$item->unit_id == $unit->id ? 'selected' : ''}}>
                                                    {{$unit->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('unit_id')}}</strong>
                                </div>
                            </div>

                            <!-- Origin -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="origin_id">Origin <sup
                                        class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Origin -"
                                                id="origin_id"
                                                name="origin_id">
                                            <option value=""></option>

                                            @foreach($origins as $origin)
                                                <option value="{{$origin->id}}"
                                                    {{$item->origin_id == $origin->id ? 'selected' : ''}}>
                                                    {{$origin->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('origin_id')}}</strong>
                                </div>
                            </div>

                            <!-- Collection -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="collection_id">Collection</label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Collection -"
                                                id="collection_id"
                                                name="collection_id">
                                            <option value=""></option>

                                            @foreach($colls as $col)
                                                <option value="{{$col->id}}"{{ $col->id == $item->collection_id ? 'Selected': '' }}>
                                                    {{$col->title}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('collection_id')}}</strong>
                                </div>
                            </div>

                            <!-- Delivery Size -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="delivery_size_id">Delivery Size <sup
                                        class="red">*</sup></label>

                                <div class="col-md-9">
                                    <div class="text-center">
                                        <select class="chosen-select form-control"
                                                data-placeholder="- Delivery Size -"
                                                id="delivery_size_id"
                                                name="delivery_size_id">
                                            <option value=""></option>

                                            @foreach($delivery_sizes as $delivery_size)
                                                <option value="{{$delivery_size->id}}"
                                                    {{$item->delivery_size_id == $delivery_size->id ? 'selected' : ''}}>
                                                    {{$delivery_size->name}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class="red">{{$errors->first('delivery_size_id')}}</strong>
                                </div>
                            </div>

                            {{--  Maximum orderable Quantity  --}}
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="max_orderable_qty">
                                    Maximum Orderable Quantity
                                </label>
                                <div class="col-md-9">
                                    <input class="form-control input-sm"
                                           id="max_orderable_qty"
                                           name="max_orderable_qty"
                                           type="text"
                                           value="{{$item->max_orderable_qty}}">
                                    <strong class="red">{{$errors->first('max_orderable_qty')}}</strong>
                                </div>
                            </div>
                            
                            <!-- Digital Sheba + Best Seller -->
                            <div class="form-group">
                                <label class="col-md-3 control-label no-padding-right" for="digital_sheba">Digital Sheba</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="digital_sheba" name="digital_sheba" {{$item->digital_sheba ? 'checked' : ''}} style="margin-top: 9px">
                                    <strong class="red">{{$errors->first('digital_sheba')}}</strong>
                                </div>
                                <label class="col-md-2 control-label no-padding-right" for="best_seller">Best Seller</label>
                                <div class="col-md-1">
                                    <input type="checkbox" id="best_seller" name="best_seller" {{$item->best_seller ? 'checked' : ''}} style="margin-top: 9px">
                                    <strong class="red">{{$errors->first('best_seller')}}</strong>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- PRICE -->
        <div class="widget-box" id="price">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title">Price & Stock</h4>
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
                            <table class="table table-bordered text-center" id="price-table">
                                <thead>
                                <tr>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Sku</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item->variants as $variant)
                                    <tr>
                                        <td>
                                            <select class="chosen-select color"
                                                    name="v_color_id[{{$variant->id}}]"
                                                    data-placeholder="- Color -">
                                                <option value=""></option>
                                                @foreach($colors as $color)
                                                    <option value="{{$color->id}}"
                                                        {{$variant->color_id == $color->id ? 'selected' : ''}}>
                                                        {{$color->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="chosen-select size"
                                                    name="v_size_id[{{$variant->id}}]"
                                                    data-placeholder="- Size -">
                                                <option value=""></option>
                                                @foreach($sizes as $size)
                                                    <option value="{{$size->id}}"
                                                        {{$variant->size_id == $size->id ? 'selected' : ''}}>
                                                        {{$size->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="small-input">
                                            <input class="input-sm"
                                                   name="v_sku[{{$variant->id}}]"
                                                   type="text"
                                                   value="{{$variant->sku}}">
                                        </td>
                                        <td class="small-input">
                                            <input class="input-sm"
                                                   type="text"
                                                   name="v_qty[{{$variant->id}}]"
                                                   required
                                                   placeholder="0"
                                                   value="{{$variant->qty}}">
                                        </td>
                                        <td class="small-input">
                                            <input class="input-sm"
                                                   name="v_price[{{$variant->id}}]"
                                                   required
                                                   type="text"
                                                   placeholder="0"
                                                   value="{{$variant->price}}">
                                        </td>
                                        <td class="small-input">
                                            <input class="input-sm"
                                                   name="v_mrp[{{$variant->id}}]"
                                                   type="text"
                                                   placeholder="0"
                                                   value="{{$variant->mrp}}">
                                        </td>
                                        <td>
                                            <button type="button" data-toggle="modal"
                                                    data-target="#v-sale-price-modal-{{$variant->id}}-o">
                                                <i class="fa fa-edit" style="font-size: 20px"></i>
                                            </button>
                                            <div class="modal" id="v-sale-price-modal-{{$variant->id}}-o">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Sale Price
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">
                                                                    &times;
                                                                </button>
                                                            </h4>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="modal-body" style="width: auto;height: 80%">
                                                            <div class="form-group">
                                                                <div class="col">
                                                                    <label for="sale-price">Sale Price</label>
                                                                </div>
                                                                <div class="col">
                                                                    <input id="sale-price"
                                                                           name="v_sale_price[{{$variant->id}}]"
                                                                           type="text"
                                                                           value="{{$variant->sale_price}}"
                                                                           placeholder="0">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col">
                                                                    <label for="start-day">Start Day</label>
                                                                </div>
                                                                <div class="col">
                                                                    <input id="start-day"
                                                                           name="v_start_day[{{$variant->id}}]"
                                                                           type="text"
                                                                           class="datepicker"
                                                                           value="{{$variant->sale_start_day}}"
                                                                           placeholder="2030-12-01">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col">
                                                                    <label for="end-day">End Day</label>
                                                                </div>
                                                                <div class="col">
                                                                    <input id="end-day"
                                                                           name="v_end_day[{{$variant->id}}]"
                                                                           type="text"
                                                                           class="datepicker"
                                                                           value="{{$variant->sale_end_day}}"
                                                                           placeholder="2030-12-01">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-group text-right" style="height: 100px">
            <div class="col-sm-offset-3 col-md-9">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fa fa-save"></i> Update
                </button>

                <a class="btn btn-sm btn-gray" href="{{route('backend.product.items.unpublished.index')}}">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </form>

@endsection

@push('js')
    <script>
        $(document).ready(() => {

            ////////////// jquery configuration
            chosen_trigger()

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            })

            ////////////// ajax
            const category = $('#category_id');
            const sub_category = $('#sub_category_id');
            const child_category = $('#child_category_id');
            category.change(function () {
                sub_category.empty();
                sub_category.append($('<option>', {
                    value: '',
                    text: ''
                }));

                child_category.empty();
                child_category.append($('<option>', {
                    value: '',
                    text: ''
                }));

                const id = $(this).val().toString().trim()
                if (id > 0) {
                    $.get('ajax/sub-categories/' + id, function (res) {
                        genSubCats(res)
                    });
                }

                sub_category.val('').trigger('chosen:updated');
                child_category.val('').trigger('chosen:updated');
            });

            sub_category.change(function () {
                child_category.empty();
                child_category.append($('<option>', {
                    value: '',
                    text: ''
                }));

                const id = $(this).val().toString().trim()
                if (id > 0) {
                    $.get('ajax/child-categories/' + id, function (res) {
                        genChildCats(res)
                    });
                }

                child_category.val('').trigger('chosen:updated');
            })

            ////////////// template
            function genSubCats(subs) {
                if (subs instanceof Array) {
                    subs.forEach(function (s) {
                        sub_category.append($('<option>', {
                            value: s.id,
                            text: s.name
                        }));
                    });
                    sub_category.val('').trigger('chosen:updated');
                }
            }

            function genChildCats(childCats) {
                if (childCats instanceof Array) {
                    childCats.forEach(function (s) {
                        child_category.append($('<option>', {
                            value: s.id,
                            text: s.name
                        }));
                    });
                    child_category.val('').trigger('chosen:updated');
                }
            }
        })

        function chosen_trigger() {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({'width': '100%'});
                    })
                }).trigger('resize.chosen');
            } else {
                $('.chosen-select').css('width', '100%');
            }
        }
    </script>
@endpush
