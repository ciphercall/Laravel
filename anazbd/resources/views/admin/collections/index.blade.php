@extends('admin.layout.master')
@section('title','Collection List')
@section('page-header')
    <i class="fa fa-list"></i> Collection List
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
        <div class="col-8">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Collections
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Shown In Home</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @forelse($collections as $key => $collection)
                            <tr>
                                <td>{{ ($collections->total()-$loop->index)-(($collections->currentpage()-1) * $collections->perpage()) }}</td>
                                <td>{{ $collection->title }}</td>
                                <td>{{ $collection->slug }}</td>
                                <td>
                                    <img src="{{ asset($collection->cover_photo) }}"
                                        class="img img-thumbnail"
                                        height="30"
                                        width="120"
                                        alt="No Image">
                                </td>
                                <td>{{ $collection->show_in_home ? 'YES' : 'NO' }}</td>
                                <td>{{ $collection->status ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <!-- <a href="{{ route('backend.product.origins.edit', $collection->id) }}"
                                        class="btn btn-xs btn-info"
                                        title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a> -->
                                        <button 
                                            data-id="{{ $collection->id }}"
                                            data-title="{{ $collection->title }}"
                                            data-show_in_home="{{$collection->show_in_home ? 'true' : 'false'}}"
                                            data-status="{{$collection->status ? 'true' : 'false'}}"
                                            class="btn btn-xs btn-warning" id="editBtn"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$collection->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.product.collections.destroy', $collection->id)}}"
                                        id="deleteCheck_{{ $collection->id }}" method="GET">
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
                    {{$collections->links()}}
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <span id="form_title">@if(old('id') > 0) Edit @else New @endif</span> Collection
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.product.collections.store') }}" enctype="multipart/form-data" id="form" method="POST">
                        @csrf
                        @if(old('id') > 0) <input type="hidden" name="id" id="role_id" value="{{ old('id') }}"> @endif
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="title">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="show_in_home" name="show_in_home" value="true">
                            <label for="vehicle1">Show in Home</label><br>
                            @error('show_in_home') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="text-dark">Status</label><br>
                            <input type="radio" id="active" name="status" value="1">
                            <label for="male">Active</label><br>
                            <input type="radio" id="inactive" name="status" value="0">
                            <label for="female">Inactive</label><br>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror

                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col">
                                    <label for="">Cover Photo</label>
                                    <div class="custom-file">
                                        <input name="cover_photo" accept="image/*" type="file" data-type="1" id="customFile">
                                    </div>
                                    @error('cover_photo') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col">
                                    <label for="">Cover Photo 2</label>
                                    <div class="custom-file">
                                        <input name="cover_photo_2"  accept="image/*" type="file" data-type="2" id="customFile">
                                    </div>
                                    @error('cover_photo_2') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col">
                                    <label for="">Cover Photo 3</label>
                                    <div class="">
                                        <input name="cover_photo_3" style="position: block !important;" accept="image/*" type="file" data-type="3" id="customFile">
                                    </div>
                                    @error('cover_photo_3') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
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

        {{--  $(document).on("change",'#customFile', function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings("#custom-file-label-"+$(this).data('type')).addClass("selected").html(fileName);
        });  --}}

        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let title = $(this).data('title');
            let showInHome = $(this).data('show_in_home');
            let status = $(this).data('status');
            $('#show_in_home').prop("checked",false);
            $('#active').prop("selected",false);
            $('#inactive').prop("selected",false);

            if(showInHome == true){
                $('#show_in_home').prop("checked",true);
            }
            if(status == true){
                $('#active').prop("checked",true);
                $('#inactive').prop("checked",false);
            }else{
                $('#inactive').prop("checked",true);
                $('#active').prop("checked",false);
            }
            $('#form').append(
                `<input type="hidden" name="id" id="role_id" value='`+id+`'>`
            );
            $("#form_title").html("Edit");

            $('#title').val(title);
        });

        $(document).on('click','#reset_btn',function(){
            $('#role_id').remove();
            $('#title').val('');
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
