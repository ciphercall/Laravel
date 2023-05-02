@extends('backend.layouts.master')
@section('title', 'Add Socail Link')
@section('page-header')
    <i class="fa fa-info"></i> Add Socail Link
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
@php
    $social = App\Models\Sociallink::first();
@endphp
@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Socail List',
       'route' =>route('backend.social.createupdate'),
    ])

    <div class="col-sm-9">
        <form class="form-horizontal" method="post" action="{{route('backend.social.createupdate',isset($social->id))}}"
              role="form"
              enctype="multipart/form-data">
        @csrf


            <!-- facebook -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Facebook
                </label>
                <div class="col-sm-6">
                    <input name="facebook"
                           type="text"
                           id="facebook"
                           class="form-control"
                           placeholder="link here" 
                           value="{{ $social->facebook?? old('facebook') }}">
                    <strong class="red">{{ $errors->first('facebook') }}</strong>
                    @if($errors->first('facebook'))
                        <br>
                    @endif
                </div>
            </div>


            <!-- twetter -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Twitter
                </label>
                <div class="col-sm-6">
                    <input  name="twitter"
                            type="text"
                            id="twitter"
                           placeholder="link here"
                            class="form-control"
                            value="{{ $social->twitter?? old('twitter')}}" 
                           >
                    <strong class="red">{{ $errors->first('twitter') }}</strong>
                    @if($errors->first('twitter'))
                        <br>
                    @endif
                </div>
            </div>

            <!-- instagram -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Instagram
                </label>
                <div class="col-sm-6">
                    <input  name="instagram"
                            type="text"
                            id="instagram"
                           placeholder="link here"
                            class="form-control"
                            value="{{ $social->instagram ?? old('instagram') }}" 
                           >
                    <strong class="red">{{ $errors->first('instagram') }}</strong>
                    @if($errors->first('instagram'))
                        <br>
                    @endif
                </div>
            </div>


             <!-- youtube -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="image">Youtube
                </label>
                <div class="col-sm-6">
                    <input  name="youtube"
                            type="text"
                            id="youtube"
                           placeholder="link here"
                            class="form- control"
                            value="{{ $social->youtube??old('youtube')}}" 
                            style="width: 100%"
                           >
                    <strong class="red">{{ $errors->first('youtube') }}</strong>
                    @if($errors->first('youtube'))
                        <br>
                    @endif
                </div>
            </div>
            

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button class="btn btn-sm btn-success submit create-button"><i class="fa fa-save"></i> Add
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

