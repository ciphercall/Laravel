@extends('material.layouts.slim')

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6 card">
            <div class="card-header-primary">
                Welcome! You are just one step away to sell on Anaz. Sign in now
            </div>
            <div class="">
                <div class="col ">
                    <div class="login-container login-width-new">
                        <div class="position-relative">
                            <div id="login-box" class="card visible widget-box no-border">
                                <div class="card-body">
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

                                        <form class="form-horizontal" role="form" action="{{ route('seller.login.post') }}"
                                              method="Post">
                                            @csrf
                                            {{-- Mobile --}}
                                            <div class="col form-group">
                                                <label for="mobile">
                                                    Mobile <span class="text-danger">*</span>
                                                </label>
                                                <div>
                                                    <input type="text"
                                                           id="mobile"
                                                           name="mobile"
                                                           placeholder="Your mobile"
                                                           class="form-control"
                                                           required>
                                                </div>
                                                <div class="col-md-offset-3 col-md-9">
                                                    <span class="text-danger">{{$errors->first('mobile')}}</span>
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
                            <div class="col text-center">
                                <span class="text-muted"><a
                                    href="{{ route('seller.register.form') }}">Become a Seller </a></span>
                            </div>
                        </div>


                    </div>
                </div><!-- /.col -->
            </div>
        </div>

    </div><!-- /.row -->
</div><!-- /.main-content -->
@endsection
