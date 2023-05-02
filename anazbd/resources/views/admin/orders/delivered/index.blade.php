@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Orders
@endsection
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="row">
        @include('admin.orders.partials.filter-i')

        <div class="col-12">
            <div class="card">

                <div class="card-header-primary">
                    <div class="row justify-content-between">
                        <p class="col">All Delivered Invoices</p>
                        @include('admin.orders.partials.export',[
                            'route' => 'admin.invoice.export',
                            'status' => 'delivered'
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
                                <th width="15%">Chalan No</th>
                                <th width="15%">Total</th>
                                <th width="20%">Delivered At</th>
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
                                    <td>{{ Carbon\Carbon::parse($invoice->delivered_at ?? $invoice->created_at)->format("d-m-Y h:i A") }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{ route('admin.orders.delivered.show',$invoice) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
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
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.select2').select2();
    </script>
@endpush

