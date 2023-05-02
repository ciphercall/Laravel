@extends('backend.layouts.master')
@section('title','Cart List')
@section('page-header')
    <i class="fa fa-list"></i> Chalan List
@stop
@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <table class="table table-bordered table-hover">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 4%">SL</th>
            <th class="bg-dark" style="width: 10%">User</th>
            <th class="bg-dark" style="width: 10%">Mobile</th>
            <th class="bg-dark" style="width: 10%">Email</th>
            <th class="bg-dark" style="width: 36%">Item</th>
            <th class="bg-dark" style="width: 12%">Created At</th>
        </tr>
        @forelse($cart as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user->name ?? '' }}</td>
                <td>{{ $item->user->mobile ?? 'N/A' }}</td>
                <td>{{ $item->user->email ?? 'N/A' }}</td>
                <td>
                    <table class="table table-bordered" style="margin-bottom: 0px !important;">
                        @php
                            $price = 0;
                        @endphp
                        @forelse($item->cart_items as $c_item)
                            @php
                                $price += $c_item->product->price ?? 0;
                            @endphp
                            <tr class="text-center {{ ($c_item->product->status == false || $c_item->product->deleted_at != null) ? 'bg-danger' : '' }}">
                                <td style="width:90%; text-align: center !important;"><a href="{{ route('frontend.product',$c_item->product->slug) }}">{{ $c_item->product->name }}</a></td>
                                <td style="width:90%; text-align: center !important;">{{ $c_item->product->price }}</td>
                            </tr>
                        @empty
                            NO Product Available.
                        @endforelse
                        @if(count($item->cart_items) > 0)
                            <tr>
                                <td>Total</td>
                                <td>{{$price}}</td>
                            </tr>
                        @endif
                    </table>

                </td>
                <td>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No data available in table</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('backend.partials._paginate', ['data' => $cart])
@endsection

{{--  @push('js')
    <script type="text/javascript">
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
@endpush  --}}
