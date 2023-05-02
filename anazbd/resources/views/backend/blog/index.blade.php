@extends('backend.layouts.master')

@section('title','blog List')
@section('page-header')
    <i class="fa fa-list"></i> blog List
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
       'name' => 'Create blog',
       'route' => route('backend.blog.create')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" >SL</th>
            <th class="bg-dark">Title</th>
            <th class="bg-dark" width="40%" >Description</th>
            <th class="bg-dark" >Image</th>
            <th class="bg-dark" >Top</th>
            <th class="bg-dark" >Admin</th>
            <th class="bg-dark" >Action</th>
        </tr>
        @forelse($blogs as $key => $blog)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $blog->title }}</td>
                <td>{!! \Illuminate\Support\Str::limit($blog->description , 100 ,'<span></span>') !!}</td>
                
                <td>
                    <img src="{{ asset($blog->short_image) }}"
                         height="30"
                         width="120"
                         alt="{{ ($blog->short_image) }}">
                </td>
                <td>
                    
                    {{ $blog->top == 1 ?"Yes":"NO" }}
                </td>
                 <td>
                    {{ $blog->admin_id }}
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.blog.edit', $blog->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$blog->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
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

    @include('backend.partials._paginate', ['data' => $blogs])
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
