@extends('backend.layouts.master')
@section('title','Brand List')
@section('page-header')
    <i class="fa fa-list"></i> Brand List
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
       'name' => 'Create Brand',
       'route' => route('backend.product.brands.create')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 5%">SL</th>
            <th class="bg-dark" style="width: 30%">Name</th>
            <th class="bg-dark" style="width: 30%">Slug</th>
            {{-- <th class="bg-dark" style="width: 30%">model</th> --}}
            <th class="bg-dark" style="width: 25%">Image</th>
            <th class="bg-dark" style="width: 10%">Action</th>
        </tr>
        @forelse($brands as $key => $brand)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->slug }}</td>
                <td>
                    <img src="{{ asset($brand->image) }}"
                         height="30"
                         width="120"
                         alt="No Image">
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.product.brands.edit', $brand->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$brand->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.product.brands.destroy', $brand->id)}}"
                          id="deleteCheck_{{ $brand->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $brands])
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
