@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Invoices
@endsection

@section('content')
    <div class="row">
{{--        <div class="col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header-primary">--}}
{{--                    Filter Invoices--}}
{{--                </div>--}}
{{--                <form action="{{ route('admin.orders.pending.index') }}" method="get">--}}
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
{{--        </div>--}}
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary">
                    All Order Invoices <a href="{{route('admin.orders.chalan.create')}}" class="col-12 text-white pull-right">New Chalan</a>
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr class="text-center">
                                <th width="5%">SL</th>
                                <th width="15%">Invoice NO</th>
                                <th width="15%">Order No</th>
                                <th width="15%">Total</th>
                                <th width="20%">Generated At</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoices as $item)
                                <tr class="text-center justify-content-center">
                                    <td>{{ ($invoices->total()-$loop->index)-(($invoices->currentpage()-1) * $invoices->perpage() ) }}</td>
                                    <td>{{ $item->chalan_no }}</td>
                                    <td>#{{ $item->order_no }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ Carbon\Carbon::parse($item->created_at)->format("d-m-Y h:i A") }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="{{ route('backend.chalan.view',$item->chalan_no) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.orders.chalan.edit',$item) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot class="text-center">
                            <tr class="table-dark text-dark">
                                <td colspan="2"></td>
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

