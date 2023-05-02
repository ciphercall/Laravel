@extends('backend.layouts.master')
@section('title', 'Waiting')
@section('page-header')
    <i class="fa fa-list"></i> Waiting
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
    @include('backend.components.page_header')

    @include('backend.orders.filter')

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 4%">SL</th>
                <th class="bg-dark" style="width: 14%">Order No.</th>
                <th class="bg-dark" style="width: 14%">Customer</th>
                <th class="bg-dark" style="width: 14%">Total</th>
                <th class="bg-dark" style="width: 14%">Order Date</th>
                <th class="bg-dark" style="width: 14%">Payment</th>
                <th class="bg-dark" style="width: 12%">Action</th>
            </tr>
            @forelse($orders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $order->no }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->total }} TK</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_time)->format('Y-m-d') }}</td>
                    <td>
                        @switch($order->payment_status)
                            @case('Unpaid')
                            <span class="badge badge-pill badge-warning">
                                {{ $order->payment_status }}
                            </span>
                            @break
                            @case('Paid')
                            <span class="badge badge-pill badge-primary">
                                {{ $order->payment_status }}
                            </span>
                            @break
                            @case('Failed')
                            <span class="badge badge-pill badge-danger">
                                {{ $order->payment_status }}
                            </span>
                            @break
                            @case('Cancelled')
                            <span class="badge badge-pill badge-danger">
                                {{ $order->payment_status }}
                            </span>
                            @break
                        @endswitch
                    </td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <a href="{{route('backend.order.waiting.show', $order->id)}}"
                               class="btn btn-xs btn-success"
                               title="Show">
                                <i class="ace-icon fa fa-eye"></i>
                            </a>

                            <a href="{{route('backend.order.waiting.edit', $order->id)}}"
                               class="btn btn-xs btn-info"
                               title="Edit">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-xs btn-danger"
                                    onclick="delete_check({{$order->id}})"
                                    title="Delete">
                                <i class="ace-icon fa fa-trash-o"></i>
                            </button>
                        </div>
                        <form action="{{ route('backend.order.destroy', $order->id)}}"
                              id="deleteCheck_{{ $order->id }}" method="GET">
                            @csrf
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No data available in table</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('backend.partials._paginate', ['data' => $orders])
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
