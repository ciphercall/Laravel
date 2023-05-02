@extends('backend.layouts.master')
@section('title', 'Add TAG')
@section('page-header')
    <i class="fa fa-plus"></i> Add Tag
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
       'name' => 'Tag List',
       'route' =>route('backend.product.tags.index'),
    ])

    <div class="col-sm-9">
        <form class="form-horizontal" method="post" action="{{route('backend.product.tags.store')}}"
              role="form"
              enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="image">Name
                </label>
                <div class="col-sm-5">
                    <input name="name"
                           type="text"
                           id="position"
                           class="form-control"
                           required=""
                           value="{{old('name')}}"
                           >
                    <strong class="red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

            <!-- status -->
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="Status">Status
                    <sup class="red">*</sup></label>

                <div class="col-sm-5">
                    <div class="text-center">
                        <select
                            class="chosen-select form-control"
                            data-placeholder="- status - "
                            name="status"
                            id="Status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>
                    </div>
                    <strong class="red">{{$errors->first('status')}}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">
                    <button class="btn btn-sm btn-success submit create-button">
                        <i class="fa fa-save"></i> Add
                    </button>
                    <a href="{{route('backend.product.tags.index')}}" class="btn btn-sm btn-gray"> <i
                            class="fa fa-refresh"></i>
                        Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection



