@extends('delivery.layouts.master')
@section('title', 'New Orders')
@section('page-header')
    <i class="fa fa-list"></i> New Orders
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
    @include('delivery.components.page_header')

    @include('delivery.orders.filter')

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 4%">SL</th>
                <th class="bg-dark" style="width: 14%">Order No.</th>
                <th class="bg-dark" style="width: 14%">Customer</th>
                <th class="bg-dark" style="width: 14%">Order Date</th>
                <th class="bg-dark" style="width: 14%">Location</th>
                <th class="bg-dark" style="width: 12%">Action</th>
            </tr>
            @forelse($orders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $order->no }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_time)->format('Y-m-d') }}
                    <td>
                        {{ $order->billing_address->area->name
                            . ', ' . $order->billing_address->city->name
                            . ', ' . $order->billing_address->division->name }}
                    </td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <a href="{{route('delivery.orders.new-show', $order->no)}}"
                               class="btn btn-xs btn-success"
                               title="Show">
                                <i class="ace-icon fa fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No data available in table</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('delivery.partials._paginate', ['data' => $orders])
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

            const city = $('#city');
            $('#division').change(function () {
                city.empty();
                city.append($('<option>', {
                    value: '',
                    text: ''
                }));
                city.val('').trigger('chosen:updated');

                const id = $(this).val().toString().trim()
                if (id > 0) {
                    $.get('{{route('delivery.cities.ajax', 100)}}'.replace('100', id), function (res) {
                        if (res.cities instanceof Array) {
                            res.cities.forEach(function (s) {
                                city.append($('<option>', {
                                    value: s.id,
                                    text: s.name
                                }));
                            });
                            city.val('').trigger('chosen:updated');
                        }
                    });
                }
            });

            const area = $('#area');
            city.change(function () {
                area.empty();
                area.append($('<option>', {
                    value: '',
                    text: ''
                }));
                area.val('').trigger('chosen:updated');

                const id = $(this).val().toString().trim()
                if (id > 0) {
                    $.get('{{route('delivery.areas.ajax', 100)}}'.replace('100', id), function (res) {
                        if (res.areas instanceof Array) {
                            res.areas.forEach(function (s) {
                                area.append($('<option>', {
                                    value: s.id,
                                    text: s.name
                                }));
                            });
                            area.val('').trigger('chosen:updated');
                        }
                    });
                }
            });
        });
    </script>
@endpush
