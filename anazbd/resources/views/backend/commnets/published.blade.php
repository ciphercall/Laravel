@extends('admin.layout.master')

@section('title','comment List')
@section('page-header')
    <i class="fa fa-list"></i> comment List
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
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-eye',
       'name' => 'published Comment',
       'route' => route('backend.comment.published')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Comments</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.comment.unpublished') }}" class="btn btn-sm btn-primary"><i class="fa fa-list">Unpublished</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="" style="width: 10%">SL</th>
                            <th class="" style="width: 20%">Item name</th>
                            <th class="" style="width: 20%">User name</th>
                            <th class="" style="width: 20%">Review</th>
                            <th class="" style="width: 20%">Rating</th>
                            <th class="" style="">Action</th>
                        </tr>
                        {{-- @dd($comments); --}}
                        @forelse($comments as $key => $comment)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $comment->Item->name }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ Str::limit($comment->review, 20, '...') }}</td>
                                <td>{{ $comment->rating }}</td>
                
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <a href="{{ route('backend.comment.show', $comment->id) }}"
                                            class="btn btn-xs btn-info"
                                            name="show">
                                             <i class="ace-icon fa fa-eye"></i>
                                         </a>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$comment->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.comment.destroy', $comment->id)}}"
                                          id="deleteCheck_{{ $comment->id }}" method="GET">
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
                    {{$comments->links()}}
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
