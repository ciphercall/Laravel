@extends('admin.layout.master')
@section('title', 'Site Information')
@section('page-header')
    <i class="fa fa-info"></i> Information
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

    <div class="row">
            <div class="col-12">
                <div class="card rounded shadow">
                    <div class="card-header-primary">
                        Site Information
                    </div>
                    <div class="card-body">
                        
                <form action="{{ route('backend.site_config.info') }}" method="post" class="form-horizontal"
                role="form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="col-sm-2 no-padding-right control-label no-padding-right" for="name">Name</label>

                    <div class="col-sm-10">
                        <input name="name"
                            type="text"
                            id="name"
                            placeholder="Company Name"
                            class="form-control"
                            value="{{ $info->name ?? old('name') }}">
                    </div>
                    <div class="col-sm-9 col-sm-offset-2">
                        <strong class=" red">{{ $errors->first('name') }}</strong>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 no-padding-right control-label no-padding-right" for="email">Email</label>

                    <div class="col-sm-10">
                        <input name="email"
                            type="email"
                            id="email"
                            placeholder="Email"
                            class="form-control"
                            value="{{ $info->email ?? old('email') }}">
                    </div>
                    <div class="col-sm-9 col-sm-offset-2">
                        <strong class=" red">{{ $errors->first('email') }}</strong>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 no-padding-right control-label no-padding-right" for="mobile">Mobile</label>
                    <div class="col-sm-10 ">
                        <input name="mobile"
                            type="text"
                            id="mobile"
                            placeholder="Mobile No."
                            class="form-control"
                            value="{{ $info->mobile ?? old('mobile') }}">
                    </div>
                    <div class="col-sm-9 col-sm-offset-2">
                        <strong class=" red">{{ $errors->first('mobile') }}</strong>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 no-padding-right control-label no-padding-right" for="address">Address</label>
                    <div class="col-sm-10">
                                    <textarea name="address"
                                            id="address"
                                            rows="1"
                                            class="form-control"
                                            placeholder="Address"

                                            style="resize: none;padding: 5px 4px 6px !important;">{{ $info->address ?? old('address') }}</textarea>
                    </div>
                    <div class="col-sm-9 col-sm-offset-2">
                        <strong class=" red">{{ $errors->first('address') }}</strong>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-2 no-padding-right control-label no-padding-right" for="short_desc">Description </label>
                    <div class="col-sm-10">
                        @include('backend.components.summer_note',[
                        'name'=>'short_desc',
                        'content'=>$info->short_desc ?? old('short_desc'),
                        ])
                        <div class="col-sm-9 col-sm-offset-2">
                            <strong class=" red">{{ $errors->first('short_desc') }}</strong>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="ace-icon fa fa-floppy-o"></i>
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
                    </div>
                </div>
            </div>
    </div>


{{--     <div class="col-sm-3">
        <div class="widget-box first">
            <div class="widget-header">
                <h4 class="widget-title">Site Logo</h4>

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
                            <img src="{{asset($info->logo)}}" class="img-responsive center-block" alt="logo"
                                 width="100" height="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Current Logo</h4>

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
                                 alt="logo">
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
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
