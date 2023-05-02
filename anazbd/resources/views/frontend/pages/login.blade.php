@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    login
@endsection
@push('css')
    <style>
        input::placeholder {
            color: gray;
            font-weight: 100;
        }

        #otp_send:disabled {
            color: gray;
            cursor: default;
        }

        #submit-login:disabled{
            cursor: default;
        }

        button[type=submit]:disabled {
            cursor: default;
            background-color: gray !important;
        }
    </style>
@endpush

@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>My account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!-- customer login start -->
    <div class="login_page_bg">
        <div class="container">
            <div class="customer_login">
                <div class="row">
                    <div class="col-lg-2 col-md-2"></div>
                    <div class="col-lg-8 col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 style="font-size: 22px;color: #424242;font-weight: 400;">Welcome to <a
                                        href="{{url('/')}}" style="color:red">Anaz!</a> Please login.</h3>
                            </div>
                            <div class="col-md-6">
                                <div class="login-other">
                                    <span>New member? <a href="{{ url('register') }}">Register</a> here.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 col-md-2"></div>
                    <div class="col-lg-8 col-md-8 " style="background: white;padding: 20px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="account_form login">

                                    <form action="{{ url('login') }}" style="border:0px" method="Post">
                                    @csrf
                                    <!-- Username -->
                                        <p>
                                            <label class="register-phone" for="username">Mobile / Email
                                                <span>*</span></label>
                                            <span class="clearable">
                                                <input type="text"
                                                       id="username"
                                                       name="username"
                                                       placeholder="Please enter your mobile number / email address"
                                                       required>
                                                <i class="clearable__clear" aria-hidden="true">&times;</i>
                                                    <span class="form-validation-error">
                                                        {{$errors->first('username')}}
                                                    </span>
                                            </span>
                                        </p>


                                        <!-- Password -->
                                        <p class="mod-input mod-input-password mod-login-input-password">
                                            <label class="register-password" for="password">Password
                                                <span>*</span></label>
                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   placeholder="Minimum 8 characters with a number and a letter"
                                                   required>
                                            <span class="form-validation-error">{{$errors->first('password')}}</span>
                                        </p>

                                        <p style="text-align: right; font-size: 12px; color: #0388a2">
                                        <a href="{{ route('user.forget.password') }}">Lost your password?</a>
                                        </p>

                                        <div class="login_submit">
                                            <label for="remember">
                                                <input id="remember" name="remember" type="checkbox">
                                                Remember me
                                            </label>
                                            <button type="submit" id="submit-login" disabled>Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="account_form register">

                                    <form action="" style="border: 0">
                                        <section>
                                            <p class="or-login text-left" style="color: gray; font-size: 13px; margin-left: 20px;">
                                                Or, Login With
                                            </p>

{{--                                            <a href="{{ route('sign-in.facebook.redirect') }}" class="btn btn-block btn-social btn-facebook social-width fb"--}}
{{--                                                    type="button">--}}
{{--                                                <i class="fas fa-facebook"></i> Facebook--}}
{{--                                            </a>--}}

                                            <a href="{{ route('sign-in.google.redirect') }}" class="btn btn-block btn-social btn-google-plus social-width go"
                                                    type="button">
                                                <i class="fa fa-google-plus"></i> Google
                                            </a>
                                        </section>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--login area start-->

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        $(document).ready(function () {
            const emailPattern = /^\S+@\S+\.\S+$/;
            const mobilePattern = /^01[0-9]{9}$/;
            // const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            const submitBtn = $('#submit-login');
            let validPass = true;
            let validUsername = true;

            // username
            $('#username').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!emailPattern.test(val) && !mobilePattern.test(val)) {
                    if (!$(this).hasClass('form-input-error')) {
                        $(this).addClass('form-input-error');
                        $(this).parent().find('.form-validation-error').text('Must be a valid mobile no / email address');
                        validUsername = false;
                    }
                } else {
                    $(this).removeClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('');
                    validUsername = true;
                }
                submitBtn.attr('disabled', !validUsername || !validPass);
            });

            $('#password').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!passwordPattern.test(val)) {
                    if (!$(this).hasClass('form-input-error')) {
                        $(this).addClass('form-input-error');
                        $(this).parent().find('.form-validation-error').text('Requires 8 characters of numbers and letters');
                        validPass = false;
                    }
                } else {
                    $(this).removeClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('');
                    validPass = true;
                }
                submitBtn.attr('disabled', !validUsername || !validPass);
            });

        });
    </script>
@endpush
