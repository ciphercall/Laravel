@extends('backend.layouts.master')
@section('title','Child Category List')
@section('page-header')
    <i class="fa fa-list"></i> Child Category List
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
       'name' => 'Create Child Category',
       'route' => route('backend.product.child_categories.create')
    ])

    <table class="table table-bordered table-hover">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 4%">SL</th>
            <th class="bg-dark" style="width: 18%">Name</th>
            <th class="bg-dark" style="width: 15%">Category</th>
            <th class="bg-dark" style="width: 15%">Sub Category</th>
            <th class="bg-dark" style="width: 16%">Slug</th>
            <th class="bg-dark" style="width: 16%">Image</th>
            <th class="bg-dark" style="width: 7%">Action</th>
        </tr>
        @forelse($childCategories as $key => $childCategory)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $childCategory->name }}</td>
                <td>{{ $childCategory->category->name }}</td>
                <td>{{ $childCategory->sub_category->name }}</td>
                <td>{{ $childCategory->slug }}</td>
                <td><img src="{{ asset($childCategory->image) }}" alt="{{ asset($childCategory->image) }}" style="width: 100px;height: 50px"></td>
                <td>
                    <div class="hidden-sm hidden-xs btn-group">
                    </div>

                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.product.child_categories.edit', $childCategory->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button"
                                onclick="delete_check({{$childCategory->id}})"
                                class="btn btn-xs btn-danger"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.product.child_categories.destroy', $childCategory->id)}}"
                          id="deleteCheck_{{ $childCategory->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $childCategories])
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
