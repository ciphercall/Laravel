@extends('backend.layouts.master')
@section('title','Chalan List')
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
    @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Create Chalan',
       'route' => route('backend.chalan.create')
    ])

    <table class="table table-bordered table-hover">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 4%">SL</th>
            <th class="bg-dark" style="width: 15%">Chalan NO</th>
            <th class="bg-dark" style="width: 15%">Order No</th>
            <th class="bg-dark" style="width: 15%">Subtotal</th>
            <th class="bg-dark" style="width: 16%">Delivery Charge</th>
            <th class="bg-dark" style="width: 7%">Action</th>
        </tr>
        @forelse($chalans as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->chalan_no }}</td>
                <td>{{ $item->order_no }}</td>
                <td>{{ $item->subtotal }}</td>
                <td>{{ $item->shipping_charge }}</td>
                <td>
                    <a href="{{ route('backend.chalan.view',$item->chalan_no) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('backend.chalan.edit',$item->chalan_no) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No data available in table</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @include('backend.partials._paginate', ['data' => $chalans])
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
