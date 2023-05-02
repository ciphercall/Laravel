@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">analytics</i> Transactions
@endsection
@section('title','Transactions')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary text-center">
                    <div class="row">
                        <div class="col-6 text-left">Filter Transactions</div>
                        <div class="col-6 text-right">
                            <div class="card-tool">
                                {{--                                <button data-toggle="collapse" data-target="#filterForm" class="btn btn-sm bg-grey"><i class="material-icons">close</i></button>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <form class="collapse show" id="filterForm" action="{{route('admin.transactions')}}">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Order No</label>
                                    <select class="col-12 chosen-select" name="order" id="">
                                        @foreach($orders as $order)
                                            <option value="{{$order->id}}">{{$order->no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Seller</label>
                                    <select class="col-12 chosen-select" name="shop" id="">
                                        @foreach($sellers as $seller)
                                            <option value="{{$order->id}}">{{$order->shop_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Agent</label>
                                    <select class="col-12 chosen-select" name="agent" id="">
                                        @foreach($agents as $agent)
                                            <option value="{{$agent->id}}">{{$agent->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Type</label>
                                    <select class="col-12 chosen-select" name="type" id="">
                                        <option value="sale">Sale</option>
                                        <option value="withdraw">Withdraw</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Total</label>
                                    <input type="text" name="total" class="col-12 form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <label class="col-12" for="">Date</label>
                                <input type="date" name="date" class="col-12 form-control">
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">search</i>
                            </button>
                            <button type="reset" class="btn btn-sm btn-info"><i class="material-icons">clear</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col-text-center" style="position: relative;left: 14px;top: 8px;">
                            All Transactions
                        </div>
                        <div class="col-text-center" style="margin-left: 70%;">
                            <a href="{{route('admin.transaction.create')}}" type="submit" class="btn btn-sm btn-info">Create New Transaction
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col bg m-3">
                        <table class="table table-responsive">
                            <thead>
                            <tr class="text-center">
                                <th width="5%">SL</th>
                                <th width="15%">Type</th>
                                <th width="10%">Order No.</th>
                                <th width="10%">Admin</th>
                                <th width="10%">Seller</th>
                                <th width="15%">Agent</th>
                                <th width="10%">Total</th>
                                <th width="10%">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ ($transactions->total()-$loop->index)-(($transactions->currentpage()-1) * $transactions->perpage() ) }}</td>
                                    <td>{{ $transaction->type }}</td>
                                    <td>{{ $transaction->order->no }}</td>
                                    <td>{{ $transaction->admin_amount }}</td>
                                    <td>{{ $transaction->seller_amount }}</td>
                                    <td>{{ $transaction->agent_amount }}</td>
                                    <td>{{ $transaction->total_amount }}</td>
                                    <td>{{ $transaction->created_at->format('d-m-y h:i A') }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
@endsection

