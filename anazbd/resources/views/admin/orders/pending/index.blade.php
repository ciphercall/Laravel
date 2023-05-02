@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Orders
@endsection

@section('content')
    <div class="row">
        @include('admin.orders.partials.filter')
        <div class="col-12">
            <div class="card">

                <div class="card-header-primary">
                    <div class="row justify-content-between">
                        <p class="col">All Pending Orders</p>
                        @include('admin.orders.partials.export',[
                                'route' => 'admin.order.export',
                                'status' => 'Pending'
                            ])
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr class="text-center">
                                <th width="5%">SL</th>
                                <th width="15%">User</th>
                                <th width="15%">No</th>
                                <th width="10%">Total</th>
                                <th width="20%">Order Date</th>
                                <th width="10%">Payment</th>
                                <th width="10%">Order Origin</th>
                                <th width="25%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr class="text-center justify-content-center">
                                    <td>{{ ($orders->total()-$loop->index)-(($orders->currentpage()-1) * $orders->perpage() ) }}</td>
                                    <td>{{ $order->user->name ?? $order->user->mobile }}</td>
                                    <td>#{{ $order->no }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ Carbon\Carbon::parse($order->order_time)->format("d-m-Y h:i A") }}</td>
                                    <td>{{ $order->payment_status }} <br><p class="text-muted" style="font-size: 9px;">{{ $order->transaction_no != null ? "#$order->transaction_no" : '' }}</p></td>
                                    <td>{{ $order->platform_origin }}</p></td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{ route('admin.orders.pending.show',$order) }}" class="btn btn-sm btn-primary"><i class="material-icons">visibility</i></a>
                                            <a href="{{ route('admin.orders.pending.edit',$order) }}" class="btn btn-sm btn-warning"><i class="material-icons">edit</i></a>
                                            <form action="{{ route('admin.orders.pending.delete',$order) }}" method="post"">
                                                @csrf
                                                @method('DELETE') 
                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="table-dark text-dark">
                                    <td colspan="2"></td>
                                    <td >Total</td>
                                    <td>{{$orders->sum('total')}}</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

