@extends('backend.layouts.master')

@section('title','Quick-page List')
@section('page-header')
    <i class="fa fa-list"></i> Page List
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
       'name' => 'Create page',
       'route' => route('backend.site_config.quick.page.create')
    ])

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 10%">SL</th>
            <th class="bg-dark" style="width: 20%">Name</th>
            <th class="bg-dark" style="width: 20%">Slug</th>
            <th class="bg-dark" style="width: 20%">section</th>
            <th class="bg-dark" style="width: 20%">Descripyion</th>
            <th class="bg-dark" style="width: 10%">Action</th>
        </tr>
        @forelse($pages as $key => $page)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $page->name }}</td>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->section }}</td>
                
                <td>
                    {!!  Str::limit($page->short_desc, 20) !!}
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.site_config.quick.page.edit', $page->id) }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$page->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.site_config.quick.page.destroy', $page->id)}}"
                          id="deleteCheck_{{ $page->id }}" method="GET">
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

    @include('backend.partials._paginate', ['data' => $pages])
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
