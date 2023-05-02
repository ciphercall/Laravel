@extends('backend.layouts.master')
@section('title', 'Add Collection')
@section('page-header')
    <i class="fa fa-plus"></i> Add Collection
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Collection List',
       'route' => route('backend.product.collections.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{ route('backend.product.collections.store') }}"
        >
        @csrf

         {{--title--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Title <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="title"
                           name="title"
                           placeholder="title Name"
                           class="form-control input-sm"
                           value="{{old('title')}}">
                 <strong class="red">{{ $errors->first('title') }}</strong>
                </div>
            </div>
         {{--Cover-Photo--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Cover Photo <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="file"
                           id="coverPhoto"
                           name="cover_photo"
                           placeholder="slug"
                           accept="image/*"
                           value=" ">
                    <strong class="red">{{ $errors->first('cover_photo') }}</strong>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="cover_photo_2">Cover Photo 2<sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="file"
                           id="cover_photo_2"
                           name="cover_photo_2"
                           placeholder="slug"
                           accept="image/*"
                           value=" ">
                    <strong class="red">{{ $errors->first('cover_photo_2') }}</strong>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="cover_photo_3">Cover Photo 3<sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="file"
                           id="cover_photo_3"
                           name="cover_photo_3"
                           placeholder="slug"
                           accept="image/*"
                           value=" ">
                    <strong class="red">{{ $errors->first('cover_photo_3') }}</strong>
                </div>
            </div>




         {{--Status--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Status <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="radio" id="status" name="status" value="1">Active
                    <input type="radio" id="status" name="status" value="0">In-Active
                <strong class="red">{{ $errors->first('status') }}</strong>
                </div>
            </div>
            {{--Show-in-home--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Show-In-Home <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="show_in_home" class="custom-control-input" id="defaultUnchecked" value="1"
                            @if(App\Models\Collection::where('show_in_home',true)->count() == 8) disabled="" @endif>
                        <strong>Only 8 collections are shown in Home page</strong>
                    </div>
                    <strong class="red">{{ $errors->first('show_in_home') }}</strong>
                </div>
            </div>

            <!-- Conversion -->

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit create-button">
                        <i class="fa fa-save"></i> Add
                    </button>

                    <a href="{{route('backend.product.collections.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
