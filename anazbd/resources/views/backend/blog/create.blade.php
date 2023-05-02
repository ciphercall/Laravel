@extends('backend.layouts.master')
@section('title', 'Add Blog')
@section('page-header')
    <i class="fa fa-info"></i> Add blog
@endsection
@push('css')
    <style>
        @media only screen and (min-width: 768px) {
            .widget-box.first {
                margin-top: 0 !important;
            }
        }
    </style>
@endpush

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'blog List',
       'route' =>route('backend.blog.index'),
    ])
@php
    $top = App\Admin\Blog::where('top',1)->first();
@endphp
    <div class="col-sm-9">
        <form class="form-horizontal" method="post" action="{{route('backend.blog.store')}}"
              role="form"
              enctype="multipart/form-data">
        @csrf
            {{-- title --}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Title
                </label>
                <div class="col-sm-4">
                    <input name="title"
                           type="text"
                           id="position"
                           class="form-control"
                           required=""
                           value="{{old('title')}}" 
                           >
                    <strong class="red">{{ $errors->first('title') }}</strong>
                    @if($errors->first('title'))
                        <br>
                    @endif
                    {{-- <strong class="red">Minimum 150x33 pixels</strong> --}}
                </div>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Image
                </label>
                <div class="col-sm-4">
                    <input name="image"
                           type="file"
                           id="image"
                           class="form-control"
                           onchange="readURL(this);">
                    <strong class="red">{{ $errors->first('image') }}</strong>
                    @if($errors->first('image'))
                        <br>
                    @endif
                    <strong class="red">Minimum 150x33 pixels</strong>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Display Top </label>
                <div class="col-sm-4">
                    @if($top)
                        <input type="checkbox" id="" class="form-control" name="top" disabled=""><strong class="red">Already One Blog Show In display</strong>
                    @else
                        <input type="checkbox" id="" class="form-control" name="top">
                    @endif
                </div>
            </div>

            <div class="form-group">
               <label class="col-sm-2 control-label no-padding-right" for="image">Display </label>
                <div class="col-sm-10">
                    @include('backend.components.summer_note',[
                        'name'=>'description',
                        'content'=>$info->description ?? old('description')
                    ])
                    <div class="col-sm-9 col-sm-offset-2">
                        <strong class=" red">{{ $errors->first('description') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit create-button"><i class="fa fa-save"></i> Add
                    </button>

                    <a href="{{route('backend.blog.index')}}" class="btn btn-sm btn-gray"> <i
                            class="fa fa-refresh"></i>
                        Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <div class="col-sm-3">
        <div class="widget-box first">
            <div class="widget-header">
                <h4 class="widget-title">Current Image</h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body"
                 style="display:flex; align-items: center; justify-content: center; height:100px;">
                <div class="widget-main">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <img id="current" src="" width="100" height="100" class="img-responsive center-block"
                                 alt="image">
                        </div>
                    </div>
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
@endpush
