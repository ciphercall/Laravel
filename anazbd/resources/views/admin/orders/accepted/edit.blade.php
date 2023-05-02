@extends('admin.layout.master')
@section('title','Order Edit')
@section('page_header')
    <i class="material-icons">receipt</i> <a class="text-dark" href="{{route('admin.orders.accepted.index')}}">Accepted Order</a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary">
                    Order <b>#{{ $order->no }}</b>
                    <span class="col-12 pull-right">
                        Order Time: <b>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y h:i A')  }}</b>
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.orders.accepted.update',$order)}}" method="POST">
                    <div class="row">
                        <div class="col-8">
                            @include('admin.orders.partials.address-edit')
                        </div>
                        <div class="col-4">
                            @include('admin.orders.partials.summery')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="card rounded shadow-sm">
                                <div class="card-body">
                                    @include('admin.orders.partials.items-edit')
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            @include('admin.orders.partials.coupon-show')
                        </div>
                    </div>
                        <div class="row justify-content-center">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-warning" onclick="return confirm('Are You Sure?')" type="submit">Update</button>
                        </div>
                    </form>
                    <div class="row justify-content-center">

                        <a href="{{ route('admin.orders.accepted.index',$order) }}" class="btn btn-sm btn-info">Accepted Orders</a>
{{--                                <form action="{{ route('admin.orders.status',$order) }}" method="post">--}}
{{--                                    @method('PUT')--}}
{{--                                    <input type="hidden" name="status" value="On Delivery">--}}
{{--                                    <button type="submit" class="btn btn-sm btn-primary shadow">Accept Order & Send it to Sellers</button>--}}
{{--                                </form>--}}
{{--                                <a href="{{ route('admin.orders.chalan.create',$order) }}" class="btn btn-sm btn-primary">Make Chalan for Delivery</a>--}}
                        <form action="{{ route('admin.orders.status',$order) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="status" value="Pickup From Seller">
                            <button type="submit" class="btn btn-sm btn-primary">Send For Pickup</button>
                        </form>
                        <form action="{{ route('admin.orders.status',$order) }}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="status" value="Cancelled">
                            <button type="submit" class="btn btn-sm btn-danger">Cancel Order</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('keyup','#price',function (){
            let id = $(this).data('id');
            let val = $(this).val();
            let qty = $('.qty-'+id).val();
            let subtotal = $("#subtotal-"+id);

            if (Number(val) > 0 && Number(qty) > 0){
                subtotal.html(Number(val) * Number(qty))
            }
        });
        $(document).on('keyup','#qty',function (){
            let id = $(this).data('id');
            let val = $(this).val();
            let price = $('.price-'+id).val();
            let subtotal = $("#subtotal-"+id);

            if (Number(val) > 0 && Number(price) > 0){
                subtotal.html(Number(val) * Number(price))
            }
        });
    </script>
@endpush

