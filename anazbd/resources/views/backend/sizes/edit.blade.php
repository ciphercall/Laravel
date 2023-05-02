@extends('backend.layouts.master')

@section('title','Edit Size')
@section('page-header')
    <i class="fa fa-pencil"></i> Edit Size
@stop
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
       'name' => 'Size list',
       'route' => route('backend.product.sizes.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.product.sizes.update', $size->id)}}">
        @csrf

        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Color Name <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="Size name"
                           class="form-control"
                           value="{{ $size->name }}">
                    <strong class=" red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

         

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit">
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{ route('backend.product.sizes.index') }}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

   
@endsection
