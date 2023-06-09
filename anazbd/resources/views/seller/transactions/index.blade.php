@extends('material.layouts.master')
@section('title', 'All Transactions')
@section('page_header')
    <i class="fa fa-list"></i> All Transactions
@stop
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    {{--  @include('seller.components.page_header')  --}}

    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Filter</h4>
        </div>
        <div class="card-body table-responsive">
            <form class="form-horizontal"
                method="GET"
                role="form"
                action="/{{request()->route()->uri()}}"
                enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th style="width: 14.28%"><label for="order">Order No.</label></th>
                    <th style="width: 14.28%"><label for="type">Type</label></th>
                    <th style="width: 14.28%"><label for="amount">Amount</label></th>
                    <th style="width: 14.28%"><label for="date">Date</label></th>
                    <th style="width: 14.28%"><label for="">Action</label></th>
                </tr>
                <tr>
                    <td>
                        <select class="chosen-select" id="order" name="order" data-placeholder="- Order No. -">
                            <option value=""></option>
                            @foreach($orders as $order)
                                <option value="{{$order->id}}" {{$order->id == request()->query('order') ? 'selected':''}}>
                                    {{$order->no}}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="chosen-select" id="type" name="type" data-placeholder="- Type -">
                            <option value=""></option>
                            <option value="Sale" {{'Sale' == request()->query('type') ? 'selected':''}}>
                                Sale
                            </option>
                            <option value="Withdrawal" {{'Withdrawal' == request()->query('type') ? 'selected':''}}>
                                Withdrawal
                            </option>
                        </select>
                    </td>
                    <td>
                        <input type="text"
                            id="amount"
                            name="amount"
                            class="form-control"
                            placeholder="Amount"
                            value="{{request()->query('amount')}}"
                            class="input-sm form-control text-center">
                    </td>
                    <td>
                        <input type="text"
                            id="date"
                            name="date"
                            form="control"
                            placeholder="Date"
                            value="{{request()->query('date')}}"
                            class="input-sm form-control text-center datepicker">
                    </td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <button type="submit"
                                    class="btn btn-xs btn-primary"
                                    title="Search">
                                <i class="ace-icon fa fa-search"></i>
                            </button>

                            <a href="/{{request()->route()->uri()}}"
                            class="btn btn-xs btn-info"
                            title="Show All">
                                <i class="ace-icon fa fa-list"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">All Transactions</h4>
        </div>
        <div class="card-body table-responsive">
                <table class="table  table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Type</th>
                            <th>Order No.</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($transactions as $key => $transaction)
                        <tr>
                            <td>{{ ($transactions->total()-$loop->index)-(($transactions->currentpage()-1) * $transactions->perpage() ) }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ $transaction->type == 'Sale' ? $transaction->order->no : '' }}</td>
                            <td>{{ $transaction->seller_amount }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No data available in table</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            {{ $transactions->links() }}
            {{--  @include('seller.partials._paginate', ['data' => $transactions])  --}}
        </div>
    </div>
    

   
@endsection

@push('js')
    <script type="text/javascript">
        jQuery(function ($) {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                //resize the chosen on window resize
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({'width': '100%'});
                        // $this.next().css({'width': $this.parent().width()});
                    })
                }).trigger('resize.chosen');
            }

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
            });
        });

        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush
