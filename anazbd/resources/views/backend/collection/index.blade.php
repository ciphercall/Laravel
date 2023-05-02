@extends('backend.layouts.master')
@section('title','Collection List')
@section('page-header')
    <i class="fa fa-list"></i> Collection
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
       'name' => 'Create Collection',
       'route' => route('backend.product.collections.create')
    ])

    <form class="form-horizontal" method="post" action="{{ route('admin.product.collections.search') }}" role="form" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th  class="bg-dark" style="width: 22%"><label for="name">Title </label></th>
                    <th class="bg-dark" style="width: 12%;">Actions</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="myInput" name="search" placeholder=" search here.." value="" class="input-sm form-control text-center" required>
                    </td>
                    <td>
                        <div class="btn-group btn-group-mini btn-corner">
                            <button type="submit" class="btn btn-xs btn-primary" title="Search">
                                <i class="ace-icon fa fa-search"></i>
                            </button>

                            <a href="{{ route('backend.product.collections.index') }}" class="btn btn-xs btn-info" title="Show All">
                                <i class="ace-icon fa fa-list"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="bg-dark" style="width: 10px">SL</th>
                <th class="bg-dark" style="width: 200px;">Title</th>
                <th class="bg-dark" style="width: 200px;">Slug</th>
                <th class="bg-dark" style="width: 200px;">Cover Photo</th>
                <th class="bg-dark" style="width: 200px;">Show-In-Home</th>
                <th class="bg-dark" style="width: 200px;">Status</th>
                <th class="bg-dark" style="width: 80px">Action</th>
            </tr>

            @forelse($collections as $key => $collection)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$collection->title}}</td>
                <td>{{$collection->slug}}</td>
                <td><img src="{{ asset($collection->cover_photo) }}" width="150px" height="100px"></td>
                <td>{{$collection->show_in_home == 1 ? 'IN' : 'OUT'}}</td>
                <td>{{$collection->status == 1 ? 'Active' : 'In-Active'}}</td>

                <td>
                    <div class="btn-group btn-group-minier btn-corner">
                        <a href="{{route('backend.product.collections.edit', ['id' => $collection->id])}}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$collection->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.product.collections.destroy', ['id' => $collection->id])}}"
                          id="deleteCheck_{{ $collection->id }}" method="GET">
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

       @include('backend.partials._paginate', ['data' => $collections])
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

