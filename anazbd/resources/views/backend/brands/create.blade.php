@extends('backend.layouts.master')
@section('title', 'Add Brand')
@section('page-header')
    <i class="fa fa-plus"></i> Add Brand
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Brand List',
       'route' => route('backend.product.brands.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.product.brands.store')}}">
        @csrf

        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="Brand"
                           class="form-control"
                           value="{{old('name')}}">
                    <strong class="red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Image</label>
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

                    <a href="{{route('backend.product.brands.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
