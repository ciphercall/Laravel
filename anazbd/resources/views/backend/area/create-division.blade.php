@extends('admin.layout.master')
@section('title', 'Add Unit')
@section('page-header')
    <i class="fa fa-plus"></i> Add Division
@endsection

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Division List',
       'route' => route('backend.area.index')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Divisions</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.area.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list"> Divisions</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
{{--              action="{{route('backend.product.units.store')}}"--}}
              action="{{ route('backend.area.division.store') }}"
        >
        @csrf

        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="Division Name"
                           class="form-control input-sm"
                           value="{{old('name')}}">
{{--                    <strong class="red">{{ $errors->first('name') }}</strong>--}}
                </div>
            </div>

            <!-- Conversion -->

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit create-button">
                        <i class="fa fa-save"></i> Add
                    </button>
{{--                    href="{{route('backend.product.units.index')}}"--}}
{{--                    <a href="#" class="btn btn-sm btn-gray">--}}
{{--                        <i class="fa fa-refresh"></i> Cancel--}}
{{--                    </a>--}}
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
