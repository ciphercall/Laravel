@extends('backend.layouts.master')
@section('title', 'Withdraw Requests')
@section('page-header')
    <i class="fa fa-list"></i> Withdraw Requests
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
    @include('backend.components.page_header', [
       'fa' => 'fa fa-plus',
       'name' => 'Make Withdrawal',
       'route' => route('backend.withdrawal.create')
    ])

    <form class="form-horizontal"
          method="GET"
          role="form"
          action="/{{request()->route()->uri()}}"
          enctype="multipart/form-data">
        <table class="table table-bordered">
            <tr>
                <th class="bg-dark" style="width: 14.28%"><label for="withdraw_method">Method</label></th>
                <th class="bg-dark" style="width: 14.28%"><label for="status">Status</label></th>
                <th class="bg-dark" style="width: 14.28%"><label for="transaction_id">Transaction ID</label></th>
                <th class="bg-dark" style="width: 14.28%"><label for="amount">Amount</label></th>
                <th class="bg-dark" style="width: 14.28%"><label for="date">Date</label></th>
                <th class="bg-dark" style="width: 14.28%"><label for="">Action</label></th>
            </tr>
            <tr>
                <td>
                    <select class="chosen-select" id="withdraw_method" name="withdraw_method" data-placeholder="- Method -">
                        <option value=""></option>
                        <option value="bKash" {{'bKash' == request()->query('withdraw_method') ? 'selected':''}}>
                            bKash
                        </option>
                        <option value="Nagad" {{'Nagad' == request()->query('withdraw_method') ? 'selected':''}}>
                            Nagad
                        </option>
                        <option value="Rocket" {{'Rocket' == request()->query('withdraw_method') ? 'selected':''}}>
                            Rocket
                        </option>
                        <option value="Bank" {{'Bank' == request()->query('withdraw_method') ? 'selected':''}}>
                            Bank
                        </option>
                        <option value="Other" {{'Other' == request()->query('withdraw_method') ? 'selected':''}}>
                            Other
                        </option>
                    </select>
                </td>
                <td>
                    <select class="chosen-select" id="status" name="status" data-placeholder="- Status -">
                        <option value=""></option>
                        <option value="1" {{'1' == request()->query('status') ? 'selected':''}}>
                            Approved
                        </option>
                        <option value="Nagad" {{'0' == request()->query('status') ? 'selected':''}}>
                            Disapproved
                        </option>
                    </select>
                </td>
                <td>
                    <input type="text"
                           id="transaction_id"
                           name="transaction_id"
                           placeholder="Transaction ID"
                           value="{{request()->query('transaction_id')}}"
                           class="input-sm form-control text-center">
                </td>
                <td>
                    <input type="text"
                           id="amount"
                           name="amount"
                           placeholder="Amount"
                           value="{{request()->query('amount')}}"
                           class="input-sm form-control text-center">
                </td>
                <td>
                    <input type="text"
                           id="date"
                           name="date"
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

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 4%">SL</th>
                <th class="bg-dark" style="width: 16%">Method</th>
                <th class="bg-dark" style="width: 16%">Amount</th>
                <th class="bg-dark" style="width: 16%">Transaction ID</th>
                <th class="bg-dark" style="width: 16%">Approved</th>
                <th class="bg-dark" style="width: 16%">Date</th>
                <th class="bg-dark" style="width: 16%">Actions</th>
            </tr>
            @forelse($withdrawals as $key => $withdrawal)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $withdrawal->method }}</td>
                    <td>{{ $withdrawal->amount }}</td>
                    <td>{{ $withdrawal->transaction_id }}</td>
                    <td>
                        @if($withdrawal->status)
                            <span class="badge badge-pill badge-success">Yes</span>
                        @else
                            <span class="badge badge-pill badge-warning">No</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('Y-m-d') }}</td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <a href="{{route('backend.withdrawal.edit', $withdrawal->id)}}"
                               class="btn btn-xs btn-info"
                               title="Edit">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>
                            @if(!$withdrawal->status)
                            <button type="button"
                                    class="btn btn-xs btn-danger"
                                    onclick="delete_check({{$withdrawal->id}})"
                                    title="Delete">
                                <i class="ace-icon fa fa-trash-o"></i>
                            </button>
                            @endif
                        </div>
                        <form action="{{ route('backend.withdrawal.destroy', $withdrawal->id)}}"
                              id="deleteCheck_{{ $withdrawal->id }}"
                              method="post">
                            @method('DELETE')
                            @csrf
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No data available in table</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('backend.partials._paginate', ['data' => $withdrawals])
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
