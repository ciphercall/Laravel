@extends('backend.layouts.master')
@section('title', 'Add Chalan')
@section('page-header')
    <i class="fa fa-plus"></i> Create Chalan
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Chalan List',
       'route' => route('backend.chalan.index')
    ])

    <div class="col-sm-9">
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
              action="{{ route('backend.chalan.store') }}">
        @csrf

        <div class="row">
            <div class="col-sm-6">
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
            </div>
            <div class="col-sm-5 col-sm-offset-1">
                <div class="form-group">
                    <label for="">Chalan No</label>
                    <input type="text" name="chalan_no" id="chalan" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Delivery Charge</label>
                    <input class="form-control" name="delivery_charge" type="number" id="input_delivery_charge" value="" placeholder="Enter Delivery Charge">
                </div>
            </div>
        </div>
        <hr>
        <div class="row hidden" id="items-div">
            <div class="row text-center" style="border:1px solid; margin:auto; padding:auto;">
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
                        
                </tbody>
            </table>
        </div>
        <div class="row hidden" id="address-row">
            <div class="row text-center" style="border:1px solid; margin:auto; padding:auto;">
                <h3>Addresses</h3>
            </div>
            <div class="row">
                <div class="col-sm-6 justify-content-center">
                    <b>Billing Address</b>
                    <p id="billing_Address"></p>
                </div>
                <div class="col-sm-6 justify-content-center">
                    <b>Shipping Address</b>
                    <p id="delivery_Address"></p>
                </div>
            </div>
            <hr>
        </div>
        <div class="row hidden">
            <div class="col-md-offset-6 col-md-6 text-right" style="margin-bottom: 15px">
                <select name="agent" id="agents">

                </select>
            </div>
            <br>
        </div>
        <div class="row hidden" id="submit-row ">

            <div class="col pull-right">
                <button class="btn btn-sm btn-success" type="button" id="submit-button">Send To Delivery</button>
                <a href="{{ route('backend.chalan.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
        </form>
    </div>
@endsection
@push('js')
 <script>
     
     $(document).ready(function(){
         let chalan = Math.random().toString(36).substring(4);
         $('#chalan').val(chalan.toUpperCase());
        $("#order_no").change(function(){
            let url = "{{ url('/') }}/anaz/superAdmin/chalan/"+$(this).val()+"/items";
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
                $('#input_delivery_charge').val(response['order'].shipping_charge);
                $('#billing_Address').text(response['billing_address'].toString());
                $('#delivery_Address').val(response['delivery_address'].toString());
                
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
