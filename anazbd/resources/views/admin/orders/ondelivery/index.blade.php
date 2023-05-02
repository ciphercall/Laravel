@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Orders
@endsection

@section('content')
    <div class="row">
        @include('admin.orders.partials.filter-i')
        
        <div class="col-12">
            <div class="card">
            <div class="card-header-primary">
                    <div class="row justify-content-between">
                        <p class="col">All On Delivered Orders</p>
                        @include('admin.orders.partials.export',[
                                'route' => 'admin.invoice.export',
                                'status' => 'pending'
                            ])
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr class="text-center">
                                <th width="5%">SL</th>
                                <th width="15%">Agent</th>
                                <th width="15%">Order No</th>
                                <th width="15%">Invoice No</th>
                                <th width="15%">Total</th>
                                <th width="20%">Generated</th>
                                <th width="15%">Payment</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoices as $invoice)
                                <tr class="text-center justify-content-center">
                                    <td>{{ ($invoices->total()-$loop->index)-(($invoices->currentpage()-1) * $invoices->perpage() ) }}</td>
                                    <td>{{ $invoice->agent->name }}</td>
                                    <td>#{{ $invoice->order_no }}</td>
                                    <td>#{{ $invoice->chalan_no }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>{{ Carbon\Carbon::parse($invoice->created_at)->format("d-m-Y h:i A") }}</td>
                                    <td>{{ $invoice->order->payment_status }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{ route('admin.orders.on-delivery.show',$invoice) }}" class="btn btn-sm btn-primary"><i class="material-icons">visibility</i></a>
                                            <a href="{{ route('admin.orders.on-delivery.edit',$invoice) }}" class="btn btn-sm btn-warning"><i class="material-icons">edit</i></a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="table-dark text-dark">
                                    <td colspan="3"></td>
                                    <td >Total</td>
                                    <td>{{$invoices->sum('total')}}</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $invoices->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

