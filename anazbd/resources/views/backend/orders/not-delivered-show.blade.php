@extends('backend.layouts.master')
@section('title', 'Show Order')
@section('page-header')
    <i class="fa fa-plus"></i> Show Order
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        table th, table td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .maximize {
            margin-top: -13px;
            margin-bottom: -12px;
            position: relative;
        }

        .maximize table {
            margin-bottom: 0;
        }

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

        .near-postal{
            background-color: #10ac84;
            color: white;
        }
        .near-postal-ex{
            background-color: #10ac84;
            color: white;
        }

        .near-city{
            background-color: #07abce;
            color: white;
        }
        .near-city-ex{
            background-color: #07abce;
            color: white;
        }

        .near-division{
            background-color: #2e86de;
            color: white;
        }
        .near-division-ex{
            background-color: #2e86de;
            color: white;
        }
    </style>
@endpush

@section('content')

    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Waiting List',
       'route' => route('backend.order.waiting.index')
    ])

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
                            <span class="stat-subtotal">&emsp;{{$chalan->order_no}}</span>
                        </div>
                        <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                            <span>Chalan No:</span>
                            <span class="stat-subtotal">&emsp;{{$chalan->chalan_no}}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Subtotal:</span>
                            <span class="stat-subtotal">{{round($chalan->subtotal)}} TK</span>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Delivery:</span>
                            <span class="stat-delivery">{{round($chalan->shipping_charge)}} TK</span>
                        </div>
                        <div style="display: flex; justify-content: space-between">
                            <span>Total:</span>
                            <span class="stat-total">{{round($chalan->total)}} TK</span>
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
                        <div style="display: flex">
                            <label class="col-md-3">
                                Name:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->name}}
                                    </span>
                            </div>
                        </div>

                        <!-- Mobile -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Mobile:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->mobile}}
                                    </span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Email:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->email}}
                                    </span>
                            </div>
                        </div>

                        <!-- Note -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Note:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->note}}
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Division -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Division:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->division->name}}
                                    </span>
                            </div>
                        </div>

                        <!-- City -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                City:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->city->name}}
                                    </span>
                            </div>
                        </div>

                        <!-- Area -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Area:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->area->name ?? ''}}
                                    </span>
                            </div>
                        </div>

                        <!-- Address L1 -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Address L1:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->address_line_1}}
                                    </span>
                            </div>
                        </div>

                        <!-- Address L2 -->
                        <div style="display: flex">
                            <label class="col-md-3">
                                Address L2:
                            </label>
                            <div class="col-md-9">
                                    <span style="font-size: 1.4rem">
                                    {{$chalan->order->billing_address->address_line_2}}
                                    </span>
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
                                <th>Shop</th>
                                <th>Item</th>
                                <th>Variant</th>
                                <th>Unit Price (Seller)</th>
                                <th>Qty</th>
                                <th>Subtotal (Seller)</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $sub = 0;
                            @endphp
                                @foreach($chalan->chalan_items as $item)
                                    <tr>
                                        <td style="max-width: 200px">
                                            {{$item->item->seller->name}}
                                        </td>
                                        <td style="max-width: 200px">
                                            {{$item->item->name}}
                                        </td>
                                        <td>
                                            @if($item->variant->color && $item->variant->size)
                                                {{$item->variant->color->name . ' - ' . $item->variant->size->name}}
                                            @elseif($item->variant->color)
                                                {{$item->variant->color->name}}
                                            @elseif($item->variant->size)
                                                {{$item->variant->size->name}}
                                            @else
                                                Default
                                            @endif
                                        </td>
                                        
                                        <td class="small-input">{{ round($item->price) }}</td>
                                        <td class="small-input">
                                            {{round($item->qty)}}
                                        </td>
                                        <td class="small-input">{{ round($item->subtotal) }}</td>
                                        <td class="small-input">
                                            {{round($item->price)}}
                                        </td>
                                        <td>
                                            <span class="subtotal">{{round($item->subtotal)}}</span>
                                            @php
                                                $sub += round($item->subtotal);
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            <tr>
                                <td colspan="5">Grand Total</td>
                                <td>{{ $chalan->total }}</td>
                                <td></td>
                                <td>{{round($chalan->total)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons -->


    <!-- Buttons -->
    <form action="{{route('backend.order.status.on-delivery', [$order->id, 'Not Delivered'])}}" method="get">
    <div class="form-group text-right" style="height: 100px">
        <div class="col-md-3">
        </div>
        <div class="col-md-9 text-right">
            <a href="{{route('backend.chalan.cancel',[$chalan->chalan_no,'On Delivery'])}}" class="btn btn-sm btn-danger">
                <i class="fa fa-times"></i> Cancel Chalan
            </a>

            {{--  <a href="{{route('backend.chalan.not-delivered', [$chalan->chalan_no, 'On Delivery'])}}"
                class="btn btn-sm btn-warning">
                 <i class="fa fa-exclamation"></i> Not Delivered
             </a>  --}}

            <a href="{{route('backend.order.status.deliver', [$chalan->id, 'On Delivery'])}}"
               class="btn btn-sm btn-primary">
                <i class="fa fa-save"></i> Confirm Delivery
            </a>

            <a class="btn btn-sm btn-gray" href="{{route('backend.order.not-delivered.index')}}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
        {{--  <div class="col-md-6">
            <div class="row">
                <div class="col-md-offset-6 col-md-6 text-center" style="margin-bottom: 15px">
                    <select class="chosen-select"
                            name="agent"
                            required
                            data-placeholder="- Agent -">
                        <option value=""></option>
                        @foreach($agents as $agent)
                            <option value="{{$agent->id}}"
                                    {{$agent->id == $order->delivery_agent_id ? 'selected' : ''}}
                                    class="@switch($agent->order)
                                        @case(-6)
                                            near-postal
                                        @break
                                        @case(-5)
                                            near-postal-ex
                                        @break
                                        @case(-4)
                                            near-city
                                        @break
                                        @case(-3)
                                            near-city-ex
                                        @break
                                        @case(-2)
                                            near-division
                                        @break
                                        @case(-1)
                                            near-division-ex
                                        @break
                                    @endswitch">
                                {{$agent->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <a href="{{route('backend.order.status.cancel', [$order->id, 'Accept'])}}"
               class="btn btn-sm btn-danger">
                <i class="fa fa-trash"></i> Cancel
            </a>

            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fa fa-send"></i> Send to Delivery
            </button>

            <a class="btn btn-sm btn-gray" href="{{route('backend.order.not-delivered.index')}}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>  --}}
    </div>


    </form>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
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
        });
    </script>
@endpush
