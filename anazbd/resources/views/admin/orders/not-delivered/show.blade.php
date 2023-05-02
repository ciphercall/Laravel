@extends('admin.layout.master')
@section('title','Order Show')
@section('page_header')
    <i class="material-icons">receipt</i> Order
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary">
                    Order <b class="text-white">#{{ $chalan->order_no }}</b> |
                    Invoice <b class="text-warning">#{{ $chalan->chalan_no }}</b> |
                    <span class="col-12 pull-right">
                        Order Time: <b>{{ \Carbon\Carbon::parse($chalan->order->created_at)->format('d M Y h:i A')  }}</b> |
                        Invoice Generated Time: <b>{{ \Carbon\Carbon::parse($chalan->created_at)->format('d M Y h:i A')  }}</b>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            @include('admin.orders.partials.address-edit',['address' => $chalan->order->billing_address])
                        </div>
                        <div class="col-4">
                            @include('admin.orders.partials.summery',['chalan' => $chalan])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="card rounded shadow-sm">
                                <div class="card-body">
                                    @include('admin.orders.partials.items-show',['chalan' => $chalan])
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            @include('admin.orders.partials.coupon-show',['order' => $chalan->order])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-9 text-right">
                            <div class="row">
                                <a href="{{ route('admin.orders.not-delivered.index') }}" class="btn btn-sm btn-info">Invoices (Not Delivered)</a>
{{--                                <form action="{{ route('admin.chalan.status',$chalan) }}" method="post">--}}
{{--                                    @method('PUT')--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="status" value="delivered">--}}
{{--                                    <button type="submit" onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-primary shadow">Delivered</button>--}}
{{--                                </form>--}}
                                <form method="POST" action="{{route('admin.chalan.status',$chalan)}}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Pending">
                                    <button type="submit" onclick="return confirm('Are you sure to renew this invoice?')" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> &nbsp; Retry</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

