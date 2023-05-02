@extends('backend.layouts.master')
@section('name', 'Add Category')
@section('page-header')
    <i class="fa fa-plus"></i> Add Category
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Category List',
       'route' => route('backend.product.categories.index')
    ])
@php
    $categories = App\Models\Category::count();
@endphp
    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.product.categories.store')}}">
        @csrf

        <!-- name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           placeholder="Category"
                           class="form-control"
                           name="name"
                           value="{{old('name')}}">
                    <strong class="red">{{ $errors->first('name') }}</strong>
                </div>
            </div>
            {{-- //position --}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="Position">Position <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="number"
                           id="Position"
                           placeholder="position"
                           class="form-control"
                           name="position"
                           {{-- max="13" --}}
                           min="1"
                           onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                           value="{{old('position')}}">
                    <strong class="red">{{ $errors->first('position') }}</strong>
                </div>
            </div>


            <!-- Display On Home -->
            @if ($categories >= 13)
                <div class="form-group" style="vertical-align: middle;">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 ">
                        <Strong>Sorry! only 13 Categories you can show on Top.</Strong>
                    </div>
                </div>
            @else()
                <div class="form-group" style="vertical-align: middle;">
                    <label class="col-sm-2 control-label no-padding-right" for="show_on_top" style="padding-top: 7px">Show On Top </label>

                    <div class="col-sm-4">
                        <input type="checkbox" id="show_on_top" class="form-control" name="show_on_top"
                            style="width: 20px">
                        <strong class="red">{{ $errors->first('show_on_top') }}</strong>
                    </div>
                </div>
            @endif


            <!-- Image -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Image </label>
                <div class="col-sm-4">
                    <input name="image"
                           type="file"
                           id="image"
                           class="form-control single-file">
                    @error('image')
                    <strong class="red">{{ $message }}</strong>
                    <br>
                    @enderror
                    <strong class="text-primary">Minimum 100x100 pixels</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit create-button">
                        <i class="fa fa-save"></i> Add
                    </button>

                    <a href="{{route('backend.product.categories.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
