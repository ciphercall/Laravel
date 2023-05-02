@extends('admin.layout.master')

@section('title','Banner List')
@section('page-header')
    <i class="fa fa-list"></i> Banner List
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
                    All Banners
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Slug</th>
                            <th>display Show</th>
                            <th>Action</th>
                        </tr>
                        @forelse($banners as $key => $banner)
                            <tr>
                                <td>{{($banners->total()-$loop->index)-(($banners->currentpage()-1) * $banners->perpage())}}</td>
                
                                <td>
                                    <img src="{{ asset($banner->image) }}"
                                         height="30"
                                         width="120"
                                         alt="{{$banner->image}}">
                                </td>
                                <td>{{ $banner->slug }}</td>
                                <td>
                                    <label class=" inline">
                                        {{-- <small class="muted smaller-90">Border:</small> --}}
                
                                        {{-- <input id="id-button-borders" checked="checked"  type="checkbox" class="ace ace-switch ace-switch-5 toggle-class"> --}}
                                        <input data-id="{{$banner->id}}" class="ace ace-switch ace-switch-5 toggle-class" type="checkbox" data-onstyle="success"
                                        data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $banner->status == true? 'checked' : '' }}>
                                        <span class="lbl middle"></span>
                                    </label>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        {{-- <a href="{{ route('backend.site_config.banner.edit', $banner->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a> --}}
                                        <button class="btn btn-sm btn-warning"
                                         data-id="{{ $banner->id }}"
                                         data-slug="{{ $banner->slug }}"
                                         data-status="{{ $banner->status }}"
                                         id="editBtn"
                                         ><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$banner->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.site_config.banner.destroy', $banner->id)}}"
                                          id="deleteCheck_{{ $banner->id }}" method="GET">
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
                    {{$banners->links()}}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Banner
                </div>
                <div class="card-body">
                    <form id="form" enctype="multipart/form-data" action="{{ route('backend.site_config.banner.store') }}" method="POST">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="form-group">
                            <label for="">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="my-2">
                            <input type="file" name="image" id="image" value="{{ old('image') }}"><br>
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="my-3">
                            <input type="checkbox" name="status" id="status" @if(old('status') != null) checked="checked" @endif>
                            <label for="">Show On Home Page</label>
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

    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var banner_id = $(this).data('id');
                var url = "{{ route('backend.site_config.banner.status', ":banner_id") }}";
                url = url.replace(':banner_id', banner_id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    data: {'status': status},
                    success: function(data){
                        {{-- let ele = $(`#editBtn[data-id='${banner_id}']`);
                        let status = '0';
                        if(ele.data('status') == 0){
                            status = '1';
                        }
                        ele.attr('data-status',status); --}}
                        location.reload();
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let slug = $(this).data('slug');
            let status = $(this).data('status');
            $('#model_id').remove();
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#slug').val(slug);
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
