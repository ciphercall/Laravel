@extends('backend.layouts.master')
@section('title', 'Update Collection')
@section('page-header')
    <i class="fa fa-plus"></i> Update Collection
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Update List',
       'route' => route('backend.product.collections.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{ route('backend.product.collections.update', ['id'=>$collection->id]) }}"
        >
            @csrf

            {{--title--}}
            <div class="form-group">
                <input type="hidden" name="id" value="{{ $collection->id }}">
                <label class="col-sm-2 control-label no-padding-right" for="name">Title <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="title"
                           name="title"
                           placeholder="title Name"
                           class="form-control input-sm"
                           value="{{$collection->title}}"
                    >
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
                           placeholder=" "
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
                           placeholder=" "
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
                           placeholder=" "
                           accept="image/*"
                           value=" ">
                    <strong class="red">{{ $errors->first('cover_photo_3') }}</strong>
                </div>
            </div>


            {{--Status--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Status <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="radio" id="status" {{ $collection->status == 1 ? 'checked' : '' }}  name="status" value="1">Active
                    <input type="radio" id="status" {{ $collection->status == 0 ? 'checked' : '' }} name="status" value="0">In-Active
                  <strong class="red">{{ $errors->first('status') }}</strong>
                </div>
            </div>

            {{--Show-in-home--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="defaultUnchecked">Show-In-Home <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <div class="custom-control custom-checkbox">

                        <input type="checkbox" {{ $collection->show_in_home == 1 ? 'checked' : '' }} name="show_in_home" class="custom-control-input" id="defaultUnchecked" value="{{old('show_in_home')}}" \
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
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{route('backend.product.collections.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3">
        <div class="row">
            <span>Cover Image :1 </span><img src="{{ asset($collection->cover_photo) }}" width="100px" height="100px"> <br> <br>
            <span>Cover Image :2 </span><img src="{{ asset($collection->cover_photo_2) }}" width="100px" height="100px"> <br> <br>
            <span>Cover Image :3 </span><img src="{{ asset($collection->cover_photo_3) }}" width="100px" height="100px">
        </div>
    </div>
@endsection
