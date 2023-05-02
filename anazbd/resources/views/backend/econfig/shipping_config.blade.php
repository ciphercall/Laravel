@extends('backend.layouts.master')
@section('title','Delivery Charge')
@section('page-header')
    <i class="fa fa-pencil"></i> Delivery Charge
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
    @include('backend.components.page_header')

    <div class="col-md-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.econfig.shipping.update')}}"
        >
            @csrf
            <!-- Inside Dhaka -->
            <div class="form-group">
                <label class="col-md-2 control-label no-padding-right" for="inside_dhaka">Inside Dhaka <sup class="red">*</sup></label>

                <div class="col-md-4">
                    <input type="text"
                           id="inside_dhaka"
                           name="inside_dhaka"
                           placeholder="0"
                           class="form-control"
                           value="{{ round($config->inside_dhaka ?? 0,2) }}">
                </div>
            </div>

            <!-- Outside Dhaka -->
            <div class="form-group">
                <label class="col-md-2 control-label no-padding-right" for="outside_dhaka">Outside Dhaka <sup
                        class="red">*</sup></label>

                <div class="col-md-4">
                    <input type="text"
                           id="outside_dhaka"
                           name="outside_dhaka"
                           placeholder="0"
                           class="form-control"
                           value="{{ round($config->outside_dhaka ?? 0,2) }}">
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-md-offset-2 col-md-4">
                    <button class="btn btn-sm btn-success submit">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>


@endsection
