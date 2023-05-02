@extends('backend.layouts.master')
@section('title','Delivery Size List')
@section('page-header')
    <i class="fa fa-list"></i> Delivery Size List
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
       'name' => 'Create Delivery Size',
       'route' => route('backend.econfig.delivery-size.create')
    ])

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 60px">SL</th>
                <th class="bg-dark" style="min-width: 100px">Name</th>
                <th class="bg-dark" style="">Customer (Chittagong)</th>
                <th class="bg-dark" style="">Customer (Other)</th>
                <th class="bg-dark" style="">Agent (Chittagong)</th>
                <th class="bg-dark" style="">Agent (Other)</th>
                <th class="bg-dark" style="width: 150px">Action</th>
            </tr>
            @forelse($sizes as $key => $size)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $size->name }}</td>
                    <td>{{ $size->customer_dhaka }}</td>
                    <td>{{ $size->customer_other }}</td>
                    <td>{{ $size->agent_dhaka }}</td>
                    <td>{{ $size->agent_other }}</td>
                    <td>
                        <div class="btn-group btn-group-minier btn-corner">
                            <a href="{{ route('backend.econfig.delivery-size.edit', $size->id) }}"
                               class="btn btn-xs btn-info"
                               title="Edit">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-xs btn-danger"
                                    onclick="delete_check({{$size->id}})"
                                    title="Delete">
                                <i class="ace-icon fa fa-trash-o"></i>
                            </button>
                        </div>

                        <form action="{{ route('backend.econfig.delivery-size.destroy', $size->id)}}"
                              id="deleteCheck_{{ $size->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $sizes])
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
