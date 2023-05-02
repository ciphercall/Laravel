@extends('admin.layout.master')
@section('title','Origin List')
@section('page-header')
    <i class="fa fa-list"></i> Origin List
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
        <div class="col-7">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Origins
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @forelse($origins as $key => $origin)
                            <tr>
                                <td>{{ ($origins->total()-$loop->index)-(($origins->currentpage()-1) * $origins->perpage()) }}</td>
                                <td>{{ $origin->name }}</td>
                                <td>{{ $origin->slug }}</td>
                                <td>
                                    <img src="{{ asset($origin->image) }}"
                                        class="img img-thumbnail"
                                        height="30"
                                        width="120"
                                        alt="No Image">
                                </td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <!-- <a href="{{ route('backend.product.origins.edit', $origin->id) }}"
                                        class="btn btn-xs btn-info"
                                        title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a> -->
                                        <button data-id="{{ $origin->id }}" data-name="{{ $origin->name }}" class="btn btn-xs btn-warning" id="editBtn"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$origin->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.product.origins.destroy', $origin->id)}}"
                                        id="deleteCheck_{{ $origin->id }}" method="GET">
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
                    {{$origins->links()}}
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <span id="form_title">@if(old('id') > 0) Edit @else New @endif</span> Origin
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.product.origins.store') }}" enctype="multipart/form-data" id="form" method="POST">
                        @csrf
                        @if(old('id') > 0) <input type="hidden" name="id" id="role_id" value="{{ old('id') }}"> @endif
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <div class="custom-file">
                                <input name="image" accept="image/*" type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose Image</label>
                            </div>
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <hr>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-warning" type="button" id="reset_btn"><i class="fa fa-times"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#form').append(
                `<input type="hidden" name="id" id="role_id" value='`+id+`'>`
            );
            $("#form_title").html("Edit");

            $('#name').val(name);
            $('#description').val(desc);
        });

        $(document).on('click','#reset_btn',function(){
            $('#role_id').remove();
            $('#name').val('');
            $('.custom-file-label').html('Choose Image');
            $("#form_title").html("New");
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
