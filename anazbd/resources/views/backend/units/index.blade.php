@extends('backend.layouts.master')
@section('title','Unit List')
@section('page-header')
    <i class="fa fa-list"></i> Unit List
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
       'name' => 'Create Unit',
       'route' => route('backend.product.units.create')
    ])

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 10px">SL</th>
                <th class="bg-dark" style="width: 200px;">Name</th>
                <th class="bg-dark" style="width: 200px;">Conversion</th>
                <th class="bg-dark" style="width: 80px">Action</th>
            </tr>
            @forelse($units as $key => $unit)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->conversion }}</td>
                    <td>
                        <div class="btn-group btn-group-minier btn-corner">
                            <a href="{{ route('backend.product.units.edit', $unit->id) }}"
                               class="btn btn-xs btn-info"
                               title="Edit">
                                <i class="ace-icon fa fa-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-xs btn-danger"
                                    onclick="delete_check({{$unit->id}})"
                                    title="Delete">
                                <i class="ace-icon fa fa-trash-o"></i>
                            </button>
                        </div>
                        <form action="{{ route('backend.product.units.destroy', $unit->id)}}"
                              id="deleteCheck_{{ $unit->id }}" method="GET">
                            @csrf
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No data available in table</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @include('backend.partials._paginate', ['data' => $units])
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
