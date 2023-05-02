@extends('backend.layouts.master')
@section('title', 'About-Us')
@section('page-header')
    <i class="fa fa-eye"></i> About-Us
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
    @include('backend.components.page_header')

    {{--  Start here  --}}
    <div class="row">
        <div class="col-sm-9">
            <form action="{{ route('backend.site_config.about-us.update') }}" method="post" class="form-horizontal"
                  role="form" enctype="multipart/form-data">
                @csrf

                
                <div class="form-group">
                    <label class="col-sm-2 no-padding-right bolder" for="description">Description </label>
                    <div class="col-sm-10">
                        @include('backend.components.summer_note',[
                        'name'=>'description',
                        'content'=>$aboutus->description,
                        ])
                        <div class="col-sm-9 col-sm-offset-2">
                            <strong class=" red">{{ $errors->first('description') }}</strong>
                        </div>
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
@endsection