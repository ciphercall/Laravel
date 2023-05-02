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
        <div class="col-8">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Sliders
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Slug</th>
                            <th>Position</th>
                            <th>Live</th>
                            <th>Action</th>
                        </tr>
                        @forelse($sliders as $key => $slider)
                            <tr>
                                <td>{{($sliders->total()-$loop->index)-(($sliders->currentpage()-1) * $sliders->perpage())}}</td>
                
                                <td>
                                    <img src="{{ asset($slider->image) }}"
                                         height="30"
                                         width="120"
                                         alt="{{$slider->image}}">
                                </td>
                                <td>{{ $slider->slug }}</td>
                                <td>{{ $slider->position }}</td>
                                <td>{{ $slider->status ? 'Yes' : 'No' }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        {{-- <a href="{{ route('backend.site_config.banner.edit', $banner->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a> --}}
                                        <button class="btn btn-xs btn-warning"
                                         data-id="{{ $slider->id }}"
                                         data-slug="{{ $slider->slug }}"
                                         data-status="{{ $slider->status }}"
                                         data-position="{{ $slider->position }}"
                                         id="editBtn"
                                         ><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$slider->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.site_config.slider.destroy', $slider->id)}}"
                                          id="deleteCheck_{{ $slider->id }}" method="GET">
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
                    {{$sliders->links()}}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Slider
                </div>
                <div class="card-body">
                    <form id="form" enctype="multipart/form-data" action="{{ route('backend.site_config.slider.store') }}" method="POST">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="form-group">
                            <label for="">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Position</label>
                            <input type="text" class="form-control" name="position" id="position" value="{{ old('position') }}">
                            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="my-2">
                            <input type="file" name="image" id="image" value="{{ old('image') }}"><br>
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="my-3">
                            <input type="checkbox" name="status" id="status" @if(old('status') != null) checked="checked" @endif>
                            <label for="">Make Live</label>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button id="resetBtn" type="reset" class="btn btn-sm"><i class="fa fa-times"></i> Reset</button>
                        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
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
            let slug = $(this).data('slug');
            let status = $(this).data('status');
            let position = $(this).data('position');
            $('#model_id').remove();
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#slug').val(slug);
            $('#position').val(position);
            $('#status').prop("checked",false);
            if(status == '1'){
                $('#status').prop("checked",true);
            }
            $('#form-title').html('Edit');
        });
        $(document).on('click','#resetBtn',function(){
            $('#form-title').html('New');
            $('#model_id').remove();
            $('#status').prop("checked",false);
            $('#slug').val('');
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
