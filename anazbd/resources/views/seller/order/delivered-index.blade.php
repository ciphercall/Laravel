@extends('material.layouts.master')
@section('title','Delivered List')
@section('page_header')
    <i class="fa fa-list"></i> Delivered List
@stop

@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        input {
            width: 100%;
        }
        .chosen-container.chosen-container-single{
            max-width: 300px;
        }
    </style>
@endpush

@section('content')

    {{--  @include('seller.components.page_header')  --}}
    <div class="card">
        <div class="card-header-primary">
            Filter Orders
        </div>
        <div class="card-body">
            @include('seller.order.filter')
        </div>
        
    </div>

    <div class="card">
        <div class="card-header-primary">
            Delivered Orders
        </div>
        <div class="card-body table-responsive">

            <table class="table table-bordered ">
                <tbody>
                <tr>
                    <th style="">SL</th>
                    <th style="">Order No.</th>
                    <th style="">Product Name</th>
                    <th style="">Quantity</th>
                    <th style="">Total</th>
                    <th style="">Order Date</th>
                    <th style="">Action</th>
                </tr>
                @forelse($details as $key => $detail)
                    <tr>
                        <td>{{($details->total()-$loop->index)-(($details->currentpage()-1) * $details->perpage() )}}</td>
                        <td>{{$detail->order->no}}</td>
                        <td style="width:30%; max-width:50%;">
                            {{ Str::limit($detail->items->pluck('product.name')->implode(','),100) }}
                        </td>
                        <td>{{$detail->items_count}}</td>
                        <td>{{round($detail->total)}} TK</td>
                        <td>{{Carbon\Carbon::parse($detail->order->order_time)->format('Y-m-d')}}</td>
                        <td>
                            <div class="btn-group btn-group-mini btn-corner">
                                <a href="{{ route('seller.order.delivered.show', $detail->id) }}"
                                   class="btn btn-xs btn-success"
                                   title="Show">
                                    <i class="ace-icon fa fa-eye"></i>
                                </a>
                            </div>
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
    </div>

    {{ $details->links() }}
    {{--  @include('seller.partials._paginate', ['data' => $details])  --}}
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.chosen-select').chosen({
                width: '100%',
                allow_single_deselect: true,
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
            });
        });
    </script>
@endpush
