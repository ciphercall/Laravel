@extends('backend.layouts.master')
@section('title','Coupon List')
@section('page-header')
    <i class="fa fa-list"></i> Coupon List
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
    @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Create Coupon',
       'route' => route('backend.campaign.coupons.create')
    ])

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 10px">SL</th>
                <th class="bg-dark" style="width: 200px;">Name</th>
                <th class="bg-dark" style="width: 200px;">Type</th>
                <th class="bg-dark" style="width: 200px;">Coupon ON</th>
                <th class="bg-dark" style="width: 200px;">Value</th>
                <th class="bg-dark" style="width: 200px;">From</th>
                <th class="bg-dark" style="width: 200px;">To</th>
                <th class="bg-dark" style="width: 200px;">Max Use</th>
                <th class="bg-dark" style="width: 200px;">Active</th>
                <th class="bg-dark" style="width: 80px">Action</th>
            </tr>
            @forelse($coupons as $key => $coupon)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $coupon->name }}</td>
                    <td>{{ $coupon->type == 'percent' ? 'Percentage' : 'Amount' }}</td>
                    <td>{{ ucfirst($coupon->coupon_on) }}</td>
                    <td>{{ $coupon->value }}</td>
                    <td>{{ $coupon->from->format('Y-m-d') }}</td>
                    <td>{{ $coupon->to->format('Y-m-d') }}</td>
                    <td>{{ $coupon->max_use }}</td>
                    <td>{{ $coupon->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <div class="btn-group btn-group-minier btn-corner">
                            <a href="{{ route('backend.campaign.coupons.edit', $coupon->id) }}"
                               class="btn btn-xs btn-info"
                               title="Edit">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-xs btn-danger"
                                    onclick="delete_check({{$coupon->id}})"
                                    title="Delete">
                                <i class="ace-icon fa fa-trash-o"></i>
                            </button>
                        </div>
                        <form action="{{ route('backend.campaign.coupons.destroy', $coupon->id)}}"
                              id="deleteCheck_{{ $coupon->id }}" method="GET">
                            @csrf
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No data available in table</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('backend.partials._paginate', ['data' => $coupons])
@endsection

@push('js')
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
@endpush
