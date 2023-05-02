@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Self Orders
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
{{--            <div class="card">--}}
{{--                <div class="card-header-primary">--}}
{{--                    Filter Self Orders ( Pending )--}}
{{--                </div>--}}
{{--                <form action="{{ route('admin.self-orders.pending.index') }}" method="get">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-3 form-group">--}}
{{--                                <label for="">Customer</label>--}}
{{--                                <select class="form-control" name="user" id="">--}}
{{--                                    <option value="">Select User</option>--}}
{{--                                    @foreach($users as $user)--}}
{{--                                        <option value="{{ $user->id }}" >{{ $user->name ?? $user->mobile }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col-3 form-group">--}}
{{--                                <label for="">From Date</label>--}}
{{--                                <input type="date" name="from" class="form-control" id="">--}}
{{--                            </div>--}}
{{--                            <div class="col-3 form-group">--}}
{{--                                <label for="">To Date</label>--}}
{{--                                <input type="date" name="to" class="form-control" id="">--}}
{{--                            </div>--}}
{{--                            <div class="col-3 form-group">--}}
{{--                                <label for="">Total</label>--}}
{{--                                <input type="text" name="total" class="form-control" id="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-3"></div>--}}
{{--                            <div class="col-3  text-right">--}}
{{--                                <button class="btn btn-sm btn-primary">Filter</button>--}}
{{--                            </div>--}}
{{--                            <div class="col-3 text-left">--}}
{{--                                <button class="btn btn-sm btn-warning" type="reset">Reset</button>--}}
{{--                            </div>--}}
{{--                            <div class="col-3"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
        </div>
        <div class="col-12">
            <div class="card">

                <div class="card-header-primary">
                    All Self-Orders ( Pending )
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr class="text-center">
                                <th width="5%">SL</th>
                                <th width="15%">User Name</th>
                                <th width="15%">Mobile</th>
                                <th width="20%">Address</th>
                                <th width="15%">Images</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr class="text-center justify-content-center">
                                    <td>{{ ($orders->total()-$loop->index)-(($orders->currentpage()-1) * $orders->perpage() ) }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->mobile }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->images_count }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{ route('admin.self-order.pending.show',$order->id) }}" class="btn btn-sm btn-primary"><i class="material-icons">visibility</i></a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

