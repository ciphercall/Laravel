@extends('admin.layout.master')
@section('title','Tag List')
@section('page-header')
    <i class="fa fa-list"></i> Tag List
@stop
@section('content')
    <div class="row">
        <div class="card rounded col-6">
            <div class="card-header-primary">
                All Tags
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <tbody>
                    <tr>
                        <th>SL</th>
                        <th >Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @forelse($tags as $key => $tag)
                        <tr>
                            <td>{{  ($tags->total()-$loop->index)-(($tags->currentpage()-1) * $tags->perpage() ) }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->status == '1'? 'Active' : 'Inactive' }}</td>
            
                            <td>
                                <div class="btn-group btn-group-mini btn-corner">
                                    <button class="btn btn-xs btn-warning" id="editBtn" data-id="{{ $tag->id }}" data-name="{{ $tag->name }}" data-status="{{ $tag->status }}" ><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-xs btn-danger"
                                            onclick="delete_check({{$tag->id}})"
                                            title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <form action="{{ route('backend.product.tags.destroy', $tag->id)}}"
                                      id="deleteCheck_{{ $tag->id }}" method="GET">
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
                {{$tags->links()}}
            </div>
        </div>
        <div class="col-1"></div>
        <div class="col-5">
            <div class="card rounded">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Tag
                </div>
                <div class="card-body">
                    <form id="form" class="form-horizontal" method="post" action="{{route('backend.product.tags.store')}}" role="form" enctype="multipart/form-data">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="form-group">
                            <label class="col-sm-4 control-label no-padding-right" for="image">Name
                            </label>
                            <input name="name"
                                type="text"
                                id="name"
                                class="form-control"
                                required=""
                                value="{{old('name')}}"
                                >
                                @error('name') <small class="text-danger">{{$message}}</small> @enderror
                        </div>
    
                            <!-- status -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="Status">Status<sup class="red">*</sup></label>
                                <select class="chosen-select form-control" data-placeholder="- status - " name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
    
                            <!-- Buttons -->
                            <div class="form-group">
                                <button class="btn btn-sm btn-success submit create-button">
                                <i class="fa fa-save"></i> Add
                            </button>
                            <button type="reset" id="resetBtn" class="btn btn-sm"><i class="fa fa-times"></i> Cancel</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">

        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let status = $(this).data('status');
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#name').val(name);
            $('#status').val(status).trigger("chosen:updated");
            $('#form-title').html('Edit');
        });
        $(document).on('click','#resetBtn',function(){
            $('#form-title').html('New');
            $('#model_id').remove();
        });

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
