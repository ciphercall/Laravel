@extends('admin.layout.master')

@section('title','blog List')
@section('page-header')
    <i class="fa fa-list"></i> Blog List
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
    <div class="row">
        <div class="col-12">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Blog</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.blog.create') }}" class="btn btn-sm btn-primary">New Blog</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="bg-dark text-white" >SL</th>
                            <th class="bg-dark text-white">Title</th>
                            <th class="bg-dark text-white" >Image</th>
                            <th class="bg-dark text-white" >Top</th>
                            <th class="bg-dark text-white" >Admin</th>
                            <th class="bg-dark text-white" >Action</th>
                        </tr>
                        @forelse($blogs as $key => $blog)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $blog->title }}</td>
                                <td>
                                    <img src="{{ asset($blog->short_image) }}"
                                         height="30"
                                         width="120"
                                         alt="{{ ($blog->short_image) }}">
                                </td>
                                <td>{{ $blog->top == 1 ?"Yes":"NO" }}</td>
                                <td>{{ $blog->admin_id }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <a href="{{ route('backend.blog.edit', $blog->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-edit"></i>
                                        </a>
                
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$blog->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.blog.destroy', $blog->id)}}"
                                          id="deleteCheck_{{ $blog->id }}" method="GET">
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
                    {{$blogs->links()}}
                </div>
            </div>
        </div>
    </div>


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
