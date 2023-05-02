@extends('admin.layout.master')
@section('title', 'New Quick Page')
@section('page-header')
    <i class="fa fa-info"></i> Quick Page
@endsection
@push('css')
    <style>
        @media only screen and (min-width: 768px) {
            .widget-box.first {
                margin-top: 0 !important;
            }
        }
    </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" integrity="sha256-yebzx8LjuetQ3l4hhQ5eNaOxVLgqaY1y8JcrXuJrAOg=" crossorigin="anonymous" />
@endpush

@section('content')
    {{-- @include('backend.components.page_header') --}}

    {{--  Start here  --}}
    <div class="row">
        <div class="col-12">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h5>@if($page == null) New @else Edit @endif Page</h5>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.site_config.quick.page.index') }}" class="btn btn-sm btn-primary">All Page</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($page == null) 
                        <form action="{{ route('backend.site_config.quick.page.store') }}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('backend.site_config.quick.page.update',$page->id) }}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 no-padding-right control-label no-padding-right" for="name">
                                Page Name</label>

                            <div class="col-sm-10">
                                <input name="name"
                                    type="text"
                                    id="name"
                                    placeholder="Page Name"
                                    class="form-control"
                                    value="{{$page == null ? old('name') : $page->name}}">
                            </div>
                            <div class="col-sm-9 col-sm-offset-2">
                                <strong class=" red">{{ $errors->first('name') }}</strong>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 no-padding-right control-label no-padding-right" for="short_desc">Description </label>
                            <div class="col-sm-10">
                                @php
                                    $description = $page == null ? old('short_desc') : $page->short_desc;
                                    $section = $page == null ? old('section') : $page->section;
                                @endphp
                                @include('backend.components.ck_editor',[
                                        'name'  =>'short_desc',
                                        'ckimage' =>'image',
                                        'value' => "{{ $description }}"

                                    ])
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 no-padding-right control-label no-padding-right" for="section">Section </label>
                            <div class="col-10">
                            <select class="form-control" id="form-field-select-1" name="section" required="" value="{{$page == null ? old('section') : $page->section}}">
                                    <option value=" ">- Select Section -</option>
                                    <option value="1" @if($section == 1) selected="selected" @endif>First Section</option>
                                    <option value="2" @if($section == 2) selected="selected" @endif>Second Section</option>
                                    <option value="3" @if($section == 3) selected="selected" @endif>Third Section</option>
                                </select>
                                <div class="col-sm-9 col-sm-offset-2">
                                    <strong class=" red">{{ $errors->first('section') }}</strong>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="ace-icon fa fa-floppy-o"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#current')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix-core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js" integrity="sha256-2D+ZJyeHHlEMmtuQTVtXt1gl0zRLKr51OCxyFfmFIBM=" crossorigin="anonymous"></script>
@endpush
