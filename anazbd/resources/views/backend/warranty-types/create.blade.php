@extends('backend.layouts.master')
@section('title', 'Add Warranty Type')
@section('page-header')
    <i class="fa fa-plus"></i> Add Warranty Type
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Warranty Type List',
       'route' => route('backend.product.warranty-types.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.product.warranty-types.store')}}">
        @csrf

        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="Name"
                           class="form-control"
                           value="{{old('name')}}">
                    <strong class="red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-4">
                    <button class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i> Add
                    </button>

                    <a href="{{route('backend.product.warranty-types.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
