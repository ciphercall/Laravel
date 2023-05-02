@extends('admin.layout.master')
@section('title', 'SMS Config')
@section('page-header')
    <i class="fa fa-envelope-o"></i> SMS Config
@endsection

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'SMS Config',
       'route' => route('backend.sms_config.get')
    ])  --}}
    <div class="row">
        
    <div class="col-6">
        <div class="card">
            <div class="card-header-primary">
                SMS Config
            </div>
            <div class="card-body">
                <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.sms_config.post',$config->id)}}">
        @csrf

        <!-- Username -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="username">Username <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="text"
                           id="username"
                           name="username"
                           placeholder="Username"
                           class="form-control"
                           value="{{$config->username ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('username') }}</strong>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="password">Password <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Password"
                           class="form-control"
                           value="{{$config->password ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                </div>
            </div>

            <!-- Sender ID -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="sender_id">Sender ID <sup
                        class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="text"
                           id="sender_id"
                           name="sender_id"
                           placeholder="Sender ID"
                           class="form-control"
                           value="{{$config->sender_id ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('sender_id') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-12">
                    <button class="btn btn-sm btn-success submit">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header-primary">
                Email Config
            </div>
            <div class="card-body">
                <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.email_config.post')}}">
        @csrf

        <!-- Username -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="username">Username <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="text"
                           id="username"
                           name="username"
                           placeholder="Username"
                           class="form-control"
                           value="{{$config->username ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('username') }}</strong>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="password">Password <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Password"
                           class="form-control"
                           value="{{$config->password ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                </div>
            </div>

            <!-- Host -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="host">Host <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="text"
                           id="host"
                           name="host"
                           placeholder="Host"
                           class="form-control"
                           value="{{$config->host ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('host') }}</strong>
                </div>
            </div>

            <!-- Port -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="port">Port <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="text"
                           id="port"
                           name="port"
                           placeholder="Port"
                           class="form-control"
                           value="{{$config->port ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('port') }}</strong>
                </div>
            </div>

            <!-- Display Name -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="display_name">Display Name <sup class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="text"
                           id="display_name"
                           name="display_name"
                           placeholder="Display Name"
                           class="form-control"
                           value="{{$config->display_name ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('display_name') }}</strong>
                </div>
            </div>

            <!-- Display Email -->
            <div class="form-group">
                <label class="col-12 control-label no-padding-right" for="display_email">Display Email <sup
                        class="text-danger">*</sup></label>
                <div class="col-12">
                    <input type="email"
                           id="display_email"
                           name="display_email"
                           placeholder="Display Email"
                           class="form-control"
                           value="{{$config->display_email ?? ''}}"
                           required>
                    <strong class="text-danger">{{ $errors->first('display_email') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-12">
                    <button class="btn btn-sm btn-success submit">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
            </div>
        </div>
    </div>
    </div>
@endsection
