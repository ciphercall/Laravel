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
        <div class="col-sm-12">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    SEO Keywords
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.site_config.keywordupdate') }}" method="post" class="form-horizontal"
                    role="form" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <label class="col-sm-2 no-padding-right control-label no-padding-right" for="mobile">Meta Key</label>
                      <div class="col-sm-10 ">
                          <input name="meta_key"
                                 type="text"
                                 id="Meta Key"
                                 placeholder="Meta Key."
                                 class="form-control"
                                 value="{{ $info->meta_key ?? old('meta_key') }}">
                      </div>
                      <div class="col-sm-9 col-sm-offset-2">
                          <strong class=" red">{{ $errors->first('meta_key') }}</strong>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-2 no-padding-right control-label no-padding-right" for="meta_desc">meta_desc</label>
                      <div class="col-sm-10">
                          <textarea name="meta_desc" id="meta_desc" cols="100" rows="5" placeholder="mata key description">{{ $info->meta_desc ?? old('meta_desc') }}</textarea>
                      </div>
                      <div class="col-sm-9 col-sm-offset-2">
                          <strong class=" red">{{ $errors->first('meta_desc') }}</strong>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="pull-right">
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
