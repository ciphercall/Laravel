@extends('admin.layout.master')
@section('title', 'Add city')
@section('page-header')
    <i class="fa fa-plus"></i> Add City
@endsection

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'City&Division List',
       'route' => route('backend.area.city.index')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Cities</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.area.city.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list"> Cities</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{ route('backend.area.city.store') }}"
        >
        @csrf

            {{-- City Name--}}
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">City Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="City Name"
                           class="form-control input-sm"
                           value="{{old('name')}}">
                    {{--                    <strong class="red">{{ $errors->first('name') }}</strong>--}}
                </div>
            </div>


        <!-- Division Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Division Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <select class="form-control input-sm" name="division_id" id="name">
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                        @endforeach
                    </select>
                    {{--                    <strong class="red">{{ $errors->first('name') }}</strong>--}}
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit create-button">
                        <i class="fa fa-save"></i> Add
                    </button>
                    <a href="{{route('backend.area.city.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

