@extends('backend.layouts.master')
@section('title','Commissions List')
@section('page-header')
    <i class="fa fa-list"></i> Commissions List
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
       'name' => 'list',
       'route' => route('backend.econfig.vat')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" >SL</th>
            <th class="bg-dark" >SubCatgory Name</th>
            <th class="bg-dark" >Commissions %</th>
            <th class="bg-dark" >Action</th>
        </tr>
        @forelse($commissions as $key => $commission)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $commission->name }}</td>
                <td>{{ ($commission->commission)?$commission->commission."%":"0" }}</td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.econfig.commission.edit', $commission->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$commission->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.econfig.commissions.destroy', $commission->id)}}"
                          id="deleteCheck_{{ $commission->id }}" method="GET">
                        @csrf
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No data available in table</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @include('backend.partials._paginate', ['data' => $commissions])
@endsection

@push('js')
    <script type="text/javascript">
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonSize: '#3085d6',
                cancelButtonSize: '#d33',
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
