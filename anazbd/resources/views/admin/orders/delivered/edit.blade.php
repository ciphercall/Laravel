@extends('admin.layout.master')
@section('title','Order Edit')
@section('page_header')
    <i class="material-icons">receipt</i> Order
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
                    <form action="{{route('admin.orders.pending.update',$order)}}" method="post">
                        @csrf
                        @method('PUT')
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
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9 text-right">
                            <div class="row">
                                <a href="{{ route('admin.orders.pending.index') }}" class="btn btn-sm btn-info">Pending Orders</a>
                                <form action="{{ route('admin.orders.pending.status',$order) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Accepted">
                                    <button type="submit" class="btn btn-sm btn-primary shadow">Accept Order & Send it to Sellers</button>
                                </form>
                                <form action="{{ route('admin.orders.pending.status',$order) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Cancelled">
                                    <button type="submit" class="btn btn-sm btn-danger">Cancel Order</button>
                                </form>
                            </div>
                        </div>
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
