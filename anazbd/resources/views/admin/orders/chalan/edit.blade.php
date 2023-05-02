@extends('admin.layout.master')
@section('title','Edit Invoice')
@section('page_header')
    <i class="material-icons">receipt</i> Invoice
@endsection
@push('css')
    <style>
        .hidden{
            display: {{$order->id == null ? 'none' : 'block'}};
        }
    </style>
@endpush
@section('content')

    <div class="card rounded col-sm-9">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form role="form"
                  method="POST"
                  class="form form-horizontal"
                  enctype="multipart/form-data"
                  action="{{ route('admin.orders.chalan.update',$chalan) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <h3>Order no: <span class="text-muted"> #{{ $order->no }}</span></h3>
                            <h3>Invoices: <span class="text-muted"> #{{ $chalan->chalan_no }}</span></h3>
                            <input type="hidden" name="order_no" value="{{$order->no}}">
                        </div>
                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label for="">Delivery Charge</label>
                            <input class="form-control" name="shipping_charge"  type="number" id="input_delivery_charge" value="{{$chalan->shipping_charge}}" placeholder="Enter Delivery Charge">
                            <h5 class="text-danger" id="coupon-message-for-delivery">{{$order->user_coupon != null ? 'Coupon Used in this order':''}}</h5>
                        </div>
                        <div class="row form-group">
                            <label for="">Subtotal</label>
                            <input class="form-control" id="subtotal" name="subtotal_chalan"  type="number" value="{{$chalan->subtotal}}" placeholder="Enter Delivery Charge">
                            <hr>
                            <label for="" id="total">Total: {{ $chalan->total }}</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row hidden" id="items-div">
                    <div class="col-12 justify-content-center p-2 border border-primary rounded" >
                        <h3>Items</h3>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="items">
                        @foreach($chalan->chalan_items as $item)
                            <tr id="row-{{$item->id}}">
                                <td><input type='hidden' value='{{$item->id}}' name='order_item[]'><a href="{{route('frontend.product',$item->item->slug)}}">{{$item->item->name}}</a></td>
                                <td>{{$item->qty}}<input type='hidden' value='{{$item->qty}}' name='qty[{{$item->id}}]'></td>
                                <td>{{$item->price}}<input type='hidden' value='{{$item->price}}' name='price[{{$item->id}}]'></td>
                                <td>{{$item->subtotal}}<input type='hidden' value='{{$item->subtotal}}' name='subtotal[{{$item->id}}]'></td>
                                <td><button class='btn btn-sm btn-danger' id='deleteRowButton' type='button' data-id='{{$item->id}}'><i class='fa fa-minus'></i></button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row hidden" id="address-row">
                    <div class="col-12 text-center justify-content-center p-2 border border-primary rounded">
                        <h3>Addresses</h3>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-6 justify-content-center">
                                <b>Billing Address</b>
                                <p id="billing_Address">{{$order->billing_address != null ? $order->billing_address->complete_address : ''}}</p>
                            </div>
                            <div class="col-sm-6 justify-content-center">
                                <b>Shipping Address</b>
                                <p id="delivery_Address"></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="row hidden">
                    <div class="col-md-6 form-group" style="margin-bottom: 15px">
                        <label for="">Delivery Agent <sup class="text-danger">*</sup></label>
                        <select class="form-control" name="agent" id="agents">
                            @foreach($agents as $agent)
                                <option value="{{$agent->id}}" @if($agent->id == $chalan->agent_id) selected="selected" @endif>{{$agent->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>
                <div class="row hidden" id="submit-row ">

                    <div class="col pull-right">
                        <button class="btn btn-sm btn-success" type="submit" id="submit-button">Update Invoice</button>
                        <a href="{{ route('admin.orders.chalan.index') }}" class="btn btn-sm btn-danger">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var shipping_charge_input = $('#input_delivery_charge');
        var subtotal_input = $('#subtotal');
        var total = $('#total');
        
        $(document).on('keyup',shipping_charge_input,function(){
            var shippingCharge = shipping_charge_input.val();
            var subtotal = subtotal_input.val();
            total.html(parseInt(shippingCharge) + parseInt(subtotal));
        });

        $(document).on('keyup',subtotal_input,function(){
            var shippingCharge = shipping_charge_input.val();
            var subtotal = subtotal_input.val();
            total.html(parseInt(shippingCharge) + parseInt(subtotal));
        });

    </script>
@endpush
