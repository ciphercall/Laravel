@extends('backend.layouts.master')
@section('title','Edit Unit')
@section('page-header')
    <i class="fa fa-pencil"></i> Edit Unit
@stop

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Unit List',
       'route' => route('backend.product.units.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.product.units.update', $unit->id)}}">
        @csrf

        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="Unit"
                           class="form-control input-sm"
                           value="{{$unit->name}}">
                    <strong class=" red">{{ $errors->first('name') }}</strong>
                </div>
            </div>

            <!-- Conversion -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="conversion">Conversion <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="conversion"
                           name="conversion"
                           placeholder="0"
                           class="form-control input-sm"
                           value="{{$unit->conversion}}">
                    <strong class="red">{{ $errors->first('conversion') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit">
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{ route('backend.product.units.index') }}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
