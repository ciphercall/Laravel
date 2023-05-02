@extends('backend.layouts.master')
@section('title', 'Add Admin')
@section('page-header')
    <i class="fa fa-info"></i> Add Admin
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
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'admin List',
       'route' =>route('backend.admin.index'),
    ])
    {{-- @dd($admin); --}}

    <div class="col-sm-9">
        <form class="form-horizontal" method="post" action="{{route('backend.admin.update', $admin->id)}}"
              role="form"
              enctype="multipart/form-data">
        @csrf


            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="password">Name
                </label>
                <div class="col-sm-5">
                    <input name="name"
                           type="text"
                           id="name"
                           class="form-control"
                           value="{{ old('name')??$admin->name }}"
                           >
                    <strong class="red">{{ $errors->first('name') }}</strong>
                    @if($errors->first('name'))
                        <br>
                    @endif
                </div>
                <div class="col-sm-3">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="password">Email
                </label>
                <div class="col-sm-5">
                    <input name="email"
                           type="text"
                           id="email"
                           class="form-control"
                           value="{{ old('email')?:$admin->email }}"
                           >
                    <strong class="red">{{ $errors->first('email') }}</strong>
                    @if($errors->first('email'))
                        <br>
                    @endif
                </div>
                <div class="col-sm-3">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="password">Old PassWord
                </label>
                <div class="col-sm-5">
                    <input name="oldpassword"
                           type="password"
                           id="password"
                           class="form-control"
                           value="{{ old('oldpassword') }}"
                           >
                    <strong class="red">{{ $errors->first('oldpassword') }}</strong>
                    @if($errors->first('oldpassword'))
                        <br>
                    @endif
                </div>
                <div class="col-sm-3">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="password">PassWord
                </label>
                <div class="col-sm-5">
                    <input name="password"
                           type="password"
                           id="password"
                           class="form-control"
                           value="{{ old('password') }}"
                           >
                    <strong class="red">{{ $errors->first('password') }}</strong>
                    @if($errors->first('password'))
                        <br>
                    @endif
                </div>
                <div class="col-sm-3">
                    <strong class="red">Password Must Be minmum 8 character</strong>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="password_confirmation">Confirmation PassWord
                </label>
                <div class="col-sm-5">
                    <input name="password_confirmation"
                           type="password"
                           id="password_confirmation"
                           class="form-control"
                           value="{{old('password_confirmation')}}"
                           >
                    <strong class="red">{{ $errors->first('password_confirmation') }}</strong>
                    @if($errors->first('password_confirmation'))
                        <br>
                    @endif
                </div>

            </div>


             <!-- position -->
            {{-- <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="Position">Position <sup class="red">*</sup></label>

                <div class="col-sm-5">
                        <select class="chosen-select" id="Position" name="is_super" required="">
                                <option value="{{ old('is_supper')??$admin->is_supper }}">--Select Position--</option>
                        </select>
                    <strong class=" red">{{ $errors->first('is_super') }}</strong>
                </div>
            </div> --}}

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-5">

                    <button class="btn btn-sm btn-success submit create-button"><i class="fa fa-save"></i> Add
                    </button>
                    <a href="{{route('backend.admin.index')}}" class="btn btn-sm btn-gray"> <i
                            class="fa fa-refresh"></i>
                        Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
