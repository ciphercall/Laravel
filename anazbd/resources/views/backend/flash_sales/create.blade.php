@extends('admin.layout.master')
@section('title', 'Add Flash Sale')
@section('page-header')
    <i class="fa fa-plus"></i> Add Flash Sale
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        .bootstrap-timepicker-widget table td input{
            width: 70px;
        }
    </style>
@endpush

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Flash Sale List',
       'route' => route('backend.campaign.flash_sale.index')
    ])  --}}
    <div class="row">
        <div class="col-9">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Flash Sales</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.campaign.flash_sale.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list">&nbsp; Flash Sales</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <form role="form"
                              method="post"
                              class="form-horizontal"
                              enctype="multipart/form-data"
                              action="{{route('backend.campaign.flash_sale.store')}}">
                        @csrf
                
                        <!-- Start Time -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="start_time">
                                    Start Time <sup class="red">*</sup>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text"
                                           id="start_time"
                                           placeholder="Start Time"
                                           class="form-control timepicker"
                                           name="start_time"
                                           value="{{old('start_time')}}">
                                    <strong class="red">{{ $errors->first('start_time') }}</strong>
                                </div>
                            </div>
                
                            <!-- End Time -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="end_time">
                                    End Time <sup class="red">*</sup>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text"
                                           id="end_time"
                                           placeholder="End Time"
                                           class="form-control timepicker"
                                           name="end_time"
                                           value="{{old('end_time')}}">
                                    <strong class="red">{{ $errors->first('end_time') }}</strong>
                                </div>
                            </div>
                
                            <!-- Min Percentage -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="min_percentage">
                                    Min Percentage To Join <sup class="red">*</sup>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text"
                                           id="min_percentage"
                                           placeholder="20"
                                           class="form-control"
                                           name="min_percentage"
                                           value="{{old('min_percentage')}}">
                                    <strong class="red">{{ $errors->first('min_percentage') }}</strong>
                                </div>
                            </div>
                
                            <!-- Max Items -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="max_items_per_seller">
                                    Max Items Per Seller <sup class="red">*</sup>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text"
                                           id="max_items_per_seller"
                                           placeholder="10"
                                           class="form-control"
                                           name="max_items_per_seller"
                                           value="{{old('max_items_per_seller')}}">
                                    <strong class="red">{{ $errors->first('max_items_per_seller') }}</strong>
                                </div>
                            </div>
                
                            <!-- Max Items -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="status">
                                    Status <sup class="red">*</sup>
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control chosen-select" name="status" id="status" data-placeholder="Status">
                                        <option value=""></option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <strong class="red">{{ $errors->first('status') }}</strong>
                                </div>
                            </div>
                
                            <!-- Buttons -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-4">
                                    <button class="btn btn-sm btn-success submit create-button">
                                        <i class="fa fa-save"></i> Add
                                    </button>
                
                                    <a href="{{route('backend.campaign.flash_sale.index')}}" class="btn btn-sm btn-gray">
                                        <i class="fa fa-refresh"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script src="{{asset('assets/js/bootstrap-timepicker.min.js')}}"></script>
    <script>
        $(document).ready(function (){
            $('.timepicker').timepicker({
                timeFormat: 'h:i a',
                defaultTime : '00:00 AM'
            });

            $('#status').chosen();
        });
    </script>
@endpush
