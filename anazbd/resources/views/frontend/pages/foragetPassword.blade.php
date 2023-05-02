@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    register
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
                            <li><a href="{{ url('/login') }}">home</a></li>
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
                                <h3 style="font-size: 22px;color: #424242;font-weight: 400;">Forget your Password </h3>
                            </div>
                            <div class="col-md-6">
                                <div class="login-other">
                                    <span>Already member? <a href="{{url('/login')}}">Login</a> here.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-2 col-md-5"></div>
                    <div class="col-lg-8 col-md-8 " style="background: white;padding: 20px">
                        <form action="{{ route('user.forget.password.save') }}" method="Post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="account_form login">

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

                                        <!-- Verification -->
                                        <p>
                                        <div class="mod-login-sms">
                                            <div class="mod-input">
                                                <label for="otp">Verification Code <span>*</span></label>
                                                <input type="text"
                                                       placeholder="Verification Code"
                                                       data-meta="Field"
                                                       id="otp"
                                                       name="otp"
                                                       inputmode="numeric"
                                                       pattern="[0-9]*"
                                                       required>
                                                <b></b>
                                                <span></span>
                                            </div>
                                            <div class="mod-sendcode">
                                                <button id="otp_send" class="mod-sendcode-btn" type="button" disabled>
                                                    SEND
                                                </button>
                                            </div>
                                            <span class="form-validation-error">{{$errors->first('otp')}}</span>
                                        </div>
                                        </p>

                                        <!-- Password -->
                                        <p>
                                        <div class="mod-input mod-input-password mod-login-input-password">
                                            <label class="register-password" for="password">Password
                                                <span>*</span></label>
                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   placeholder="Minimum 8 characters with a number and a letter"
                                                   required>
                                            <span class="form-validation-error">{{$errors->first('password')}}</span>
                                        </div>
                                        </p>
                                        <p>
                                            <div class="mod-input mod-input-password mod-login-input-password">
                                                <label class="register-password" for="password_confirmation">Confirm Password
                                                    <span>*</span></label>
                                                <input type="password"
                                                       id="password_confirmation"
                                                       name="password_confirmation"
                                                       placeholder="Minimum 8 characters with a number and a letter"
                                                       required>
                                                <span class="form-validation-error">{{$errors->first('password_confirmation')}}</span>
                                            </div>

                                            </p>

                                        <div class="register-style">
                                            <button type="submit">SIGN UP</button>
                                            <br>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="account_form login">


                                        <!-- Subscription -->
                                        <div class="offer-checkbox">
                                            <input type="checkbox"
                                                   id="subscription"
                                                   name="subscription"
                                                   value="on"
                                                   style="height: auto; width: auto"
                                                   checked>
                                            <label style="color: gray; user-select: none" for="subscription">
                                                I want to receive exclusive offers and promotions.
                                            </label>
                                        </div>

                                        <!-- Sign Up -->
                                        <div class="register-style">
                                            <button type="submit">SIGN UP</button>
                                            <br>
                                        </div>

                                        <!-- Notice -->
                                        <div class="offer-checkbox" style="padding-left:20px;padding-top: 10px">
                                            <small style="color: gray">By clicking "SIGN UP" I agree to
                                                <a href="{{url('/')}}" target="_blank" style="color:red">ANAZ </a>
                                                <span style="color:#049cb9">Privacy Policy</span>
                                            </small>
                                            <p><small style="color: gray">Or, sign up with</small></p>
                                        </div>

                                        <!-- Social -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button class="btn register-width  fb" style="background-color: ">
                                                    <i class="fa fa-facebook"></i> Facebook
                                                </button>
                                            </div>

                                            <div class="col-md-4">
                                                <button class="btn  register-width go" style="background-color: ">
                                                    <i class="fa fa-google-plus"></i> Google
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </form>

                    </div>
                    <!--login area start-->

                </div>
            </div>
        </div>
    </div>

    <!-- customer login end -->
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            const emailPattern = /^\S+@\S+\.\S+$/;
            const mobilePattern = /^01[0-9]{9}$/;
            const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            const otpPattern = /^[0-9]{6}$/;

            // username
            $('#username').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!emailPattern.test(val) && !mobilePattern.test(val)) {
                    if (!$(this).hasClass('form-input-error')) {
                        $(this).addClass('form-input-error');
                        $(this).parent().find('.form-validation-error').text('Must be a valid mobile no / email address');
                        $('#otp_send').attr('disabled', true);
                    }
                } else {
                    $(this).removeClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('');
                    $('#otp_send').attr('disabled', false);
                }
            });

            // password
            $('#password').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!passwordPattern.test(val)) {
                    if (!$(this).hasClass('form-input-error')) {
                        $(this).addClass('form-input-error');
                        $(this).parent().find('.form-validation-error').text('Requires 8 characters of numbers and letters');
                    }
                } else {
                    $(this).removeClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('');
                }
            });

            $('#password_confirmation').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!passwordPattern.test(val)) {
                    if (!$(this).hasClass('form-input-error')) {
                        $(this).addClass('form-input-error');
                        $(this).parent().find('.form-validation-error').text('Requires 8 characters of numbers and letters');
                    }
                } else {
                    $(this).removeClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('');
                }
            });

            // otp
            $('#otp').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!otpPattern.test(val)) {
                    if (!$(this).hasClass('form-input-error')) {
                        $(this).addClass('form-input-error');
                        $(this).parent().parent().find('.form-validation-error').text('Requires a 6 digit code');
                    }
                } else {
                    $(this).removeClass('form-input-error');
                    $(this).parent().parent().find('.form-validation-error').text('');
                }
            });

            // otp send
            $('#otp_send').click(function () {
                const val = $('#username').val().toString().trim();

                $.post('{{route('frontend.otp.send')}}',
                    {
                        username: val,
                    },
                    function (res) {
                        console.log(res);
                    });
            });
        });
    </script>
@endpush

