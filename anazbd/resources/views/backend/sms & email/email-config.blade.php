@extends('backend.layouts.master')
@section('title', 'Email Config')
@section('page-header')
    <i class="fa fa-envelope"></i> Email Config
@endsection

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Email Config',
       'route' => route('backend.email_config.get')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.email_config.post')}}">
        @csrf

        <!-- Username -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="username">Username <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="username"
                           name="username"
                           placeholder="Username"
                           class="form-control"
                           value="{{$config->username ?? ''}}"
                           required>
                    <strong class="red">{{ $errors->first('username') }}</strong>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="password">Password <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Password"
                           class="form-control"
                           value="{{$config->password ?? ''}}"
                           required>
                    <strong class="red">{{ $errors->first('password') }}</strong>
                </div>
            </div>

            <!-- Host -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="host">Host <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="host"
                           name="host"
                           placeholder="Host"
                           class="form-control"
                           value="{{$config->host ?? ''}}"
                           required>
                    <strong class="red">{{ $errors->first('host') }}</strong>
                </div>
            </div>

            <!-- Port -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="port">Port <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="port"
                           name="port"
                           placeholder="Port"
                           class="form-control"
                           value="{{$config->port ?? ''}}"
                           required>
                    <strong class="red">{{ $errors->first('port') }}</strong>
                </div>
            </div>

            <!-- Display Name -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="display_name">Display Name <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           id="display_name"
                           name="display_name"
                           placeholder="Display Name"
                           class="form-control"
                           value="{{$config->display_name ?? ''}}"
                           required>
                    <strong class="red">{{ $errors->first('display_name') }}</strong>
                </div>
            </div>

            <!-- Display Email -->
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="display_email">Display Email <sup
                        class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="email"
                           id="display_email"
                           name="display_email"
                           placeholder="Display Email"
                           class="form-control"
                           value="{{$config->display_email ?? ''}}"
                           required>
                    <strong class="red">{{ $errors->first('display_email') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success submit">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
