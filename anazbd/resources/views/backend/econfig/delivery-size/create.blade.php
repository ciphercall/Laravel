@extends('backend.layouts.master')
@section('title', 'Add Delivery Size')
@section('page-header')
    <i class="fa fa-plus"></i> Add Delivery Size
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Delivery Size List',
       'route' => route('backend.econfig.delivery-size.index')
    ])

    <div class="col-md-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.econfig.delivery-size.store')}}">
        @csrf

        <!-- Size Name -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label no-padding-right" for="name">
                            Name <sup class="red">*</sup>
                        </label>
                        <div class="col-md-7">
                            <input type="text"
                                   id="name"
                                   name="name"
                                   placeholder="Name"
                                   class="form-control text-center"
                                   value="{{old('name')}}">
                            <strong class="red">{{ $errors->first('name') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inside Dhaka -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-5 control-label no-padding-right" for="customer_dhaka">
                            Customer (Chittagong) <sup class="red">*</sup>
                        </label>
                        <div class="col-md-7">
                            <input type="text"
                                   id="customer_dhaka"
                                   name="customer_dhaka"
                                   placeholder="0"
                                   class="form-control text-center"
                                   value="{{old('customer_dhaka')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-5 control-label no-padding-right" for="customer_other">
                            Customer (Outside) <sup class="red">*</sup>
                        </label>
                        <div class="col-md-7">
                            <input type="text"
                                   id="customer_other"
                                   name="customer_other"
                                   placeholder="0"
                                   class="form-control text-center"
                                   value="{{old('customer_other')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-5 control-label no-padding-right" for="agent_dhaka">
                            Agent (Chittagong) <sup class="red">*</sup>
                        </label>
                        <div class="col-md-7">
                            <input type="text"
                                   id="agent_dhaka"
                                   name="agent_dhaka"
                                   placeholder="0"
                                   class="form-control text-center"
                                   value="{{old('agent_dhaka')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-5 control-label no-padding-right" for="agent_other">
                            Agent (Outside) <sup class="red">*</sup>
                        </label>
                        <div class="col-md-7">
                            <input type="text"
                                   id="agent_other"
                                   name="agent_other"
                                   placeholder="0"
                                   class="form-control text-center"
                                   value="{{old('agent_other')}}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-7" style="text-align: right">
                            <button class="btn btn-sm btn-success">
                                <i class="fa fa-save"></i> Add
                            </button>

                            <a href="{{route('backend.econfig.delivery-size.index')}}" class="btn btn-sm btn-gray">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
