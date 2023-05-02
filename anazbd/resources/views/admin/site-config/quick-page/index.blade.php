@extends('admin.layout.master')

@section('title','Banner List')
@section('page-header')
    <i class="fa fa-list"></i> Slider List
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
                            <h5>All Sliders</h5>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.site_config.quick.page.create') }}" class="btn btn-sm btn-primary">New Page</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Section</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{($pages->total()-$loop->index)-(($pages->currentpage()-1) * $pages->perpage())}}</td>
                                <td>{{ $page->name }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>{{ $page->section }}</td>
                                <td>{!! Str::limit($page->short_desc,100) !!}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <a href="{{ route('backend.site_config.quick.page.edit', $page->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-edit"></i>
                                        </a>
                                        
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$page->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
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
                                <td colspan="3">No data available in table</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{$pages->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection

