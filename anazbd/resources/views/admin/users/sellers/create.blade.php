@extends('admin.layout.master')
@section('title', 'Add Seller')
@section('page-header')
    <i class="fa fa-info"></i> Add Seller
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

    <div class="col-6 card rounded shadow">
        <div class="card-header-primary">
            Seller Form
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="{{route('backend.seller.store')}}" role="form" enctype="multipart/form-data">
                @csrf
    
                {{-- Business Type --}}
                <div class="form-group">
                    <label class="col control-label no-padding-right" for="form-field-1">
                        Account Type <span class="text-danger">*</span>
                    </label>
    
                    <div class="col">
                        <div class="control-group">
                            <div class="row">
    
                                <div class="col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio"
                                                   required
                                                   class="ace"
                                                   name="type"
                                                   value="0">
                                            <span class="lbl">Personal</span>
                                        </label>
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio"
                                                   required
                                                   name="type"
                                                   class="ace"
                                                   value="1">
                                            <span class="lbl">Business</span>
                                        </label>
                                    </div>
                                </div>
    
                                <span class="text-danger">{{ $errors->first('type')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Name --}}
                <div class="form-group">
                    <label class=" control-label no-padding-right " for="name">
                        Full Name <span class="text-danger">*</span>
                    </label>
    
                    <div class="">
                        <input type="text"
                               required
                               id="name"
                               name="name"
                               placeholder="Your full name"
                               class="form-control">
                        <span class="text-danger">{{ $errors->first('name')}}</span>
                    </div>
                </div>
    
                {{-- Shop name--}}
                <div class="form-group">
                    <label class="control-label no-padding-right " for="shop_name">
                        Shop Name <span class="text-danger">*</span>
                    </label>
    
                    <div class="">
                        <input type="text"
                               required
                               id="shop_name"
                               name="shop_name"
                               placeholder="Your shop's name"
                               class="form-control">
                        <span class="text-danger">{{ $errors->first('shop_name')}}</span>
                    </div>
                </div>
    
                {{-- Mobiile --}}
                <div class="form-group">
                    <label class="control-label no-padding-right " for="mobile">
                        Mobile <span class="text-danger">*</span>
                    </label>
    
                    <div class="">
                        <div class="input-group" >
                            <span class="form-control" style="max-width: 60px !important;">+88 </span>
                            <input id="mobile"
                                   required
                                   type="text"
                                   class="form-control"
                                   name="mobile"
                                   placeholder="Your mobile no">
                        </div>
                        <span class="text-danger">{{ $errors->first('mobile')}}</span>
                    </div>
                </div>
    
    
                {{-- Password --}}
                <div class="form-group">
                    <label class="control-label no-padding-right " for="password">
                        Password <span class="text-danger">*</span>
                    </label>
                    <div class="">
                        <input type="password"
                               required
                               id="password"
                               name="password"
                               placeholder="Minimum 8 characters of letters and numbers"
                               class="form-control">
                        <span class="text-danger">{{ $errors->first('password')}}</span>
                    </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                    <div class="text-center">
                        <button class="btn btn-sm btn-success submit create-button"><i class="fa fa-save"></i> Add</button>
                        <a href="{{route('backend.site_config.slider.index')}}" class="btn btn-sm btn-gray"> <i class="fa fa-refresh"></i>Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="col-sm-2 control-label no-padding-right">
        <div class="widget-box first">
            <div class="widget-header">
                <h4 class="widget-title">Current Image</h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="widget-body"
                 style="display:flex; align-items: center; justify-content: center; height:100px;">
                <div class="widget-main">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <img id="current" src="" width="100" height="100" class="img-responsive center-block"
                                 alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#current')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
