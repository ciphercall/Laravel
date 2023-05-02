@extends('admin.layout.master')
@section('title','Order Show')
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
                  action="{{ route('admin.orders.chalan.store') }}">
                @csrf

                <div class="row">
                    <div class="col-sm-6">
                        @if($order->id == null)
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select Order no</label>
                                <select class="form-control chosen-select" name="order_no" id="order_no">
                                    <option>Select Order</option>
                                    @forelse ($orders as $item)
                                        <option value="{{$item->no}}">{{ $item->no }}</option>
                                    @empty
                                        <option>No Orders Available</option>
                                    @endforelse
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <h3>Order no: {{ $order->no }}</h3>
                                <input type="hidden" name="order_no" value="{{$order->no}}">
                            </div>
                        @endif
{{--                        @dd($order)--}}
                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label for="">Chalan No</label>
                            <input type="text" name="chalan_no" id="chalan" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Delivery Charge</label>
                            <input class="form-control" name="delivery_charge"  type="number" id="input_delivery_charge" value="{{$order->shipping_charge}}" placeholder="Enter Delivery Charge">
                            <h5 class="text-danger" id="coupon-message-for-delivery"></h5>
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
                            @foreach($order->items as $item)
                                <tr id="row-{{$item->id}}">
                                    <td><input type='hidden' value='{{$item->id}}' name='order_item[]'><a href="{{route('frontend.product',$item->product->slug)}}">{{$item->product->name}}</a></td>
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
                                <option value="{{$agent->id}}">{{$agent->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                </div>
                <div class="row hidden" id="submit-row ">

                    <div class="col pull-right">
                        <button class="btn btn-sm btn-success" type="button" id="submit-button">Send To Delivery</button>
                        <a href="{{ route('admin.orders.chalan.index') }}" class="btn btn-sm btn-danger">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>

        $(document).ready(function(){
            let chalan = Math.random().toString(36).substring(4);
            $('#chalan').val(chalan.toUpperCase());
            $("#order_no").change(function(){
                let url = "{{ url('/') }}/admin/orders/chalan/"+$(this).val()+"/items";
                let items = "";
                let agents = "<option>Select Delivery Personal</option>";
                $.get(url,function (response){
                    $.each(response['items'],function(index,element){
                        let row = "<tr id='row-"+element.id+"'><td>"+element.product_name+"<input type='hidden' value='"+element.id+"' name='order_item[]'></td><td>"+element.qty+"<input type='hidden' value='"+element.qty+"' name='qty["+element.id+"]'></td><td>"+element.price+"<input type='hidden' value='"+element.price+"' name='price["+element.id+"]'></td><td>"+element.subtotal+"<input type='hidden' value='"+element.subtotal+"' name='subtotal["+element.id+"]'></td><td><button class='btn btn-sm btn-danger' id='deleteRowButton' type='button' data-id='"+element.id+"'><i class='fa fa-minus'></i></button></td></tr>";
                        items += row;
                    });
                    $.each(response['agents'],function(index,agent){
                        agents += "<option value="+agent.id+">"+agent.name+"</option>"
                    });
                    setupView()
                    $('#items').append(items);
                    $('#agents').append(agents);
                    $('#billing_Address').text(response['billing_address'].toString());
                    $('#delivery_Address').val(response['delivery_address'].toString());
                    if (response['isCouponOnDelivery'] == true){
                        $('#coupon-message-for-delivery').html('Order has used a coupon on delivery charge. Be sure to add any other delivery charge.');
                        $('#input_delivery_charge').val(Number(response['order'].shipping_charge) - Number(response['order'].user_coupon.value));
                    }else{
                        $('#input_delivery_charge').val(response['order'].shipping_charge);
                    }
                });
            });
            $('#submit-button').on('click',function(){
                $('.form').submit();
            });
            function setupView(){
                $('#items').empty();
                $('#billing_Address').text('');
                $('#delivery_Address').text('');
                $('#input_delivery_charge').val('');
                $('#agents').empty();
                $(document).find('.hidden').addClass('show')
                $(document).find('.show').removeClass('hidden');
            }
            $(document).on('click','#deleteRowButton',function(){
                $('#row-'+$(this).data('id')).remove();
            });
        });

    </script>
@endpush
