@extends('backend.layouts.master')
@section('title','Colors List')
@section('page-header')
    <i class="fa fa-list"></i> Color List
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
       'name' => 'Create Color',
       'route' => route('backend.product.colors.create')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 10%">SL</th>
            <th class="bg-dark" style="width: 30%">Name</th>
            <th class="bg-dark" style="width: 30%">Color Value</th>
            {{-- <th class="bg-dark" style="width: 25%">Image</th> --}}
            <th class="bg-dark" style="width: 10%">Action</th>
        </tr>
        @forelse($colors as $key => $color)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $color->name }}</td>
                <td>{{ $color->value }}</td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.product.colors.edit', $color->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$color->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.product.colors.destroy', $color->id)}}"
                          id="deleteCheck_{{ $color->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $colors])
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
