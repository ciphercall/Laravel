@extends('admin.layout.master')
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
    <div class="row">
        <div class="col-9">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    Edit Blog
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="post" action="{{route('backend.blog.update', $blog->id)}}"
                          role="form"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col ontrol-label no-padding-right" for="image">Title
                            </label>
                            <div class="col">
                                <input name="title"
                                       type="text"
                                       id="position"
                                       class="form-control"
                                       required=""
                                       value="{{ $blog->title??old('title')}}" 
                                       >
                                <strong class="red">{{ $errors->first('title') }}</strong>
                                @if($errors->first('title'))
                                    <br>
                                @endif
                            </div>
                        </div>
            
                        <!-- Image -->
                        <div class="">
                            <label class="col control-label no-padding-right" for="image">Image
                            </label>
                            <div class="col">
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
                            <label class="col control-label no-padding-right" for="image">Display Top </label>
                            <div class="col">
                                <input type="checkbox" id="" class="form-control" name="top" {{ $blog->top == 1?"checked" :" " }}>
                            </div>
                        </div>
            
                        <div class="form-group">
                           <label class="col control-label no-padding-right" for="image">Display </label>
                            <div class="col-sm-10">
                                @include('backend.components.summer_note',[
                                    'name' => 'description',
                                    'content'=> $blog->description ?? old('description')
                                ])
                                <div class="col-sm-9 col-sm-offset-2">
                                    <strong class=" red">{{ $errors->first('description') }}</strong>
                                </div>
                            </div>
                        </div>
            
                        <!-- Buttons -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col">
                                <button class="btn btn-sm btn-success submit create-button"><i class="fa fa-save"></i> Update
                                </button>
            
                                <a href="{{route('backend.blog.index')}}" class="btn btn-sm btn-gray"> <i
                                        class="fa fa-refresh"></i>
                                    Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header-info">
                    <h4 class="card-title">Uploaded Image</h4>
                </div>
                <div class="card-body"
                     style="display:flex; align-items: center; justify-content: center; height:100px;">
                    <div class="widget-main p-1">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <img src="{{asset($blog->short_image)}}" width="100" height="100" class="img-responsive center-block" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header-success">
                    <h4 class="card-title">Current Image</h4>
                </div>
                <div class="card-body"
                     style="display:flex; align-items: center; justify-content: center; height:100px;">
                    <div class="widget-main">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <img id="current"
                                     src=""
                                     width="100"
                                     height="100"
                                     class="img-responsive center-block"
                                     alt="image">
                            </div>
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
