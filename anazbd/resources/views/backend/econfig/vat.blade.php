@extends('backend.layouts.master')
@section('title','Vats List')
@section('page-header')
    <i class="fa fa-list"></i> Vats List
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
            <th class="bg-dark" >Vat%</th>
            <th class="bg-dark" >Action</th>
        </tr>
        @forelse($vats as $key => $vat)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $vat->name }}</td>
                <td>{{ ($vat->vat)?$vat->vat."%":"0" }}</td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.econfig.vats.edit', $vat->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$vat->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.econfig.vats.destroy', $vat->id)}}"
                          id="deleteCheck_{{ $vat->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $vats])
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
