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
       'name' => 'Unpublished Comment',
       'route' => route('backend.comment.unpublished')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Comment</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.comment.unpublished') }}" class="btn btn-sm btn-primary"><i class="fa fa-eye">Unpublished Comment</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Item Name </div>
                            <div class="profile-info-value">
                                <i class="fa fa-product-hunt light-orange bigger-110"></i>
                            <span class="editable editable-click" id="username">{{ $comment->item->name ?? '' }}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                           <div class="profile-info-name"> Username </div>
                           <div class="profile-info-value">
                            <i class="fa fa-user light-orange bigger-110"></i>
                           <span class="editable editable-click" id="username">{{ $comment->user->name }}</span>
                           </div>
                        </div>
                        <div class="profile-info-row">
                           <div class="profile-info-name"> Review </div>
                           <div class="profile-info-value">
                              <i class="fa fa-pencil light-orange bigger-110"></i>
                              <span class="editable editable-click" id="country">{{ $comment->review }}</span>
                           </div>
                        </div>
                        <div class="profile-info-row">
                           <div class="profile-info-name"> Rating </div>
                           <div class="profile-info-value">
                              <i class="fa fa-star light-orange bigger-110"></i>
                              <span class="editable editable-click" id="country">{{ $comment->rating }}</span>
                           </div>
                        </div>
                     </div>
                
                     <div class="col text-center">
                        @if(str_contains(url()->previous(),"unpublished"))
                        <a href="{{ route('backend.comment.approve', $comment->id) }}">
                            <button class="btn btn-success">Approve </button>
                        </a>
                        @endif
                
                        <button class="btn btn-danger" onclick="delete_check({{$comment->id}})" title="Delete">Delete </button>
                        <form action="{{ route('backend.comment.destroy', $comment->id)}}" style="display: none"
                            id="deleteCheck_{{ $comment->id }}" method="GET">
                          @csrf
                        </form>
                        <a href="{{ url()->previous() }}"><button class="btn btn-default"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back </button></a>
                      </div>
                </div>
            </div>
        </div>
    </div>
<div class="col-sm-9">

    
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
