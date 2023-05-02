@extends('material.layouts.slim')

@section('content')
<div class="main-content"  style="height: 900px;">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6 card">
            <div class="card-header-primary text-center">
                Admin Panel
            </div>
            <!-- <div class=""> -->
                <!-- <div class="col "> -->
                    <div class="login-container login-width-new">
                        <div class="position-relative">
                            <div id="login-box" class=" visible widget-box no-border">
                            <hr>
                                <div class="p-2">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger text-center">
                                            <i class="ace-icon glyphicon glyphicon-user"></i>
                                            Sign In
                                        </h4>


                                        <div class="space-6"></div>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        @if (session('warning'))
                                            <div class="alert alert-warning" role="alert">
                                                {{ session('warning') }}
                                            </div>
                                        @endif

                                        <form class="form-horizontal" role="form" action="{{ route('admin.login') }}"
                                              method="Post">
                                            @csrf
                                            {{-- Mobile --}}
                                            <div class="col form-group">
                                                <label for="mobile">
                                                    Email <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <input type="email"
                                                           id="mobile"
                                                           name="email"
                                                           placeholder="Your Email"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-md-offset-3 col-md-9">
                                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                                </div>
                                            </div>

                                            {{-- Password --}}
                                            <div class="col form-group">
                                                <label for="password">
                                                    Password <span class="text-danger">*</span>
                                                </label>

                                                <div>
                                                    <input type="password"
                                                           id="password"
                                                           name="password"
                                                           placeholder="password"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-md-offset-3 col-md-9">
                                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                                </div>
                                            </div>

                                            <div class="space-4"></div>
                                            <input type="hidden" name="remember" value="true">

                                            <div class="clearfix form-actions ">
                                                <div class="text-center">
                                                    <button class="btn btn-info" id="submit-login" type="submit">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Log In
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                <!-- </div>/.col -->
            <!-- </div> -->
        </div>

    </div><!-- /.row -->
</div><!-- /.main-content -->
@endsection
