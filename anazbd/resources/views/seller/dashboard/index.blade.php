@extends('material.layouts.master')
@push('css')
    <style>
        .bg-gradient {
            background: rgb(204, 139, 174);
            background: radial-gradient(circle, rgba(204, 139, 174, 1) 23%, rgba(148, 187, 233, 1) 67%);
        }
    </style>
@endpush
@section('page-header')
    <i class="fa fa-home"></i> Dashboard
@endsection
@section('title', 'Home')
@section('content')
    {{--  Content  --}}
    <div class="container">

        <div class="row">
            <div class="card shadow-sm bg-gradient p-4 text-center rounded" style="margin-bottom: 0px !important;">
                <h5><b>{{ Auth('seller')->user()->shop_name ?? Auth('seller')->user()->name }}</b></h5>
            </div>
        </div>
        <div class="row">
            <div class="card shadow-sm bg-gradient p-4 text-center rounded" style="margin-bottom: 0px !important;">
                <form action="{{ route('seller.dashboard.index') }}" method="GET">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h4>Please select a date range to filter activity</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2" style="position: relative;top: 14px;left: 6%;">

                            <h5><b>From</b></h5>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name="from_date" data-date="{{ $from->format('d/m/Y') }}" class="form-control input-group-addon"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2" style="position: relative;top: 14px;left: 6%;">

                            <h5><b>To</b></h5>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' name="to_date" value="{{ $to->format('d/m/Y') }}" class="form-control input-group-addon"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-2" style="position: relative;top: 2px;right: 4%;">
                            <button class="btn btn-success">SUBMIT</button>
                        </div>
                    </div>
               </div>
            </form>
            </div>
        </div>

        <div class="row">
            <div class="card col">

                <div class="row justify-content-start">
                    <div class="card bg-info m-1 p-3 col-sm col-md col-lg">

                        <span class="text-light">Total Active Items</span>
                        <h1>{{ $totalItems->where('status',true)->count() }}</h1>
                    </div>
                    <div class="card bg-dark m-1 p-3 col-sm col-md col-lg">
                        <span class="text-muted">Total Inactive Items</span>
                        <h1>{{ $totalItems->where('status',false)->count() }}</h1>
                    </div>
                    <div class="card bg-success m-1 p-3 col-sm col-md col-lg">
                        <span class="text-light">Total Orders</span>
                        <h1>{{ $orders->count() }}</h1>
                    </div>
                    <div class="card bg-success m-1 p-3 col-sm col-md col-lg">
                        <span class="text-light">Total Orders Delivered</span>
                        <h1>{{ $orders->where('status','Delivered')->count() }}</h1>
                    </div>
                    <div class="card bg-danger m-1 p-3 col-sm col-md col-lg">
                        <span class="text-light">Total Cancelled Orders</span>
                        <h1>{{ $orders->where('status','Cancelled')->count() }}</h1>
                    </div>
                    <div class="card bg-warning m-1 p-3 col-sm col-md col-lg">
                        <span class="text-light">Total Pending Orders</span>
                        <h1>{{ $orders->where('status','Accepted')->count() }}</h1>
                    </div>
                    <div class="card bg-success m-1 p-3 col-sm col-md col-lg">
                        <span class="text-muted">Total Sold Items</span>
                        <h1>{{ $soldItems->count() }}</h1>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col text-center">Showing Reports from {{ $from }} to {{ $to }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="card card-primary">
                    <div class="card-header-primary">
                        Most Ordered Items
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th width="70%">Item</th>
                                <th>Ordered</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($soldItems->sortByDesc('order_items_count')->take(5) as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{ $item->order_items_count }} times</td>
                                    <td>
                                        <a href="{{ route('seller.product.items.edit',$item->id) }}"
                                           class="btn btn-sm btn-info"><i class="material-icons">visibility</i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="card card-primary">
                    <div class="card-header-primary">
                        Recent Items
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th width="40%">Item</th>
                                <th>Price</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($totalItems->reverse()->take(5) as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->diffForhumans() }}</td>
                                    <td>
                                        <a href="{{ route('seller.product.items.edit',$item->id) }}"
                                           class="btn btn-sm btn-info"><i class="material-icons">visibility</i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6">
                <div class="card card-primary">
                    <div class="card-header-primary">
                        Recent Orders
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Payment</th>
                                <th>Ordered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders->reverse()->take(5) as $order)
                                <tr>
                                    <td><b>{{ $order->no }}</b></td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>{{ Carbon\Carbon::parse($order->order_time)->diffForhumans() }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <a href="{{ route('seller.order.pending.show',$order->id) }}"
                                           class="btn btn-sm btn-info"><i class="material-icons">visibility</i></a>
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
@endsection
