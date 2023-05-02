@extends('admin.layout.master')
@section('title','Order Show')
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
                                    @include('admin.orders.partials.items-show')
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            @include('admin.orders.partials.coupon-show')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9 text-right">
                            <div class="row">
                                <a href="{{ route('admin.orders.accepted.edit',$order) }}" class="btn btn-sm btn-info">Edit Order</a>
{{--                                <a href="{{ route('admin.orders.chalan.create',$order) }}" class="btn btn-sm btn-primary">Make Chalan for Delivery</a>--}}
                                <form action="{{ route('admin.orders.status',$order) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="status" value="Pickup From Seller">
                                    <button type="submit" class="btn btn-sm btn-primary">Send for pickup</button>
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
        </div>
    </div>
@endsection

