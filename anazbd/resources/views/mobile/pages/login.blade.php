@extends('mobile.layouts.master')
@push('css')
    <style>
        .register-form span {
            color: black !important;
        }
        .register-form .form-control::placeholder {
            color: black !important;
        }
        .login-meta-data a{
            color: black !important;
        }
        .login-meta-data p{
            color: black !important;
        }
        input{
            color: black !important;
        }
    </style>
@endpush
@section('mobile')
    <div class="login-wrapper bg-white d-flex align-items-center justify-content-center text-center">
        <!-- Background Shape-->
        {{--  <div class="background-shape"></div>  --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img class="big-logo"
                                                                             src="{{ asset('frontend/assets/anazlogo.png') }}" alt="" style="width: 217px;height: auto;">
                    <!-- login Form-->
                    <div class="register-form mt-5 px-4">
                        <form action="{{ url('login') }}" style="border:0px" method="Post">
                            @csrf
                            <div class="form-group text-left mb-4"><span>Mobile / Email *</span>
                                <label><i class="lni lni-user"></i></label>
                                <input class="form-control" id="username" type="text" name="username"
                                       placeholder="Please enter your mobile number / email address" id="username"
                                       required>
                                <span class="form-validation-error">{{$errors->first('username')}} </span>
                            </div>
                            <div class="form-group text-left mb-4"><span>Password</span>
                                <label><i class="lni lni-lock"></i></label>
                                <input class="form-control" type="password" placeholder="********************"
                                       name="password" id="password" required>
                                <span class="form-validation-error">{{$errors->first('password')}}</span>
                            </div>
                            <button class="btn btn-success btn-lg w-100" type="submit" id="submit-login" disabled="">Log
                                In
                            </button>
                        </form>
                    </div>
                    <!-- Login Meta-->
                    <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="{{ route('user.forget.password') }}">Forgot
                            Password?</a>
                        <p class="mb-0">Didn't have an account?<a class="ml-1" href="{{ url('/register') }}">Register
                                Now</a></p>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 p-2">
                            <p>Or You can login using social apps...</p>
                        </div>
                        {{--  <div class="col-6">  --}}
{{--                            <a href="{{ route('sign-in.facebook.redirect') }}"--}}
{{--                                               class="btn btn-block btn-social btn-facebook social-width fb" type="button" style="background-color: royalblue;color: white;">--}}
{{--                                <i class="fab fa-facebook-f"></i>--}}
{{--                            </a>--}}
                        {{--  </div>  --}}
                        <div class="col pl-5 pr-5">
                            <a href="{{ route('sign-in.google.redirect') }}"
                                               class="btn btn-block btn-danger btn-social btn-google-plus social-width go" type="button" style="background-image: url('mobile/images/googlebutton.png');background-size: cover;">
                                <i class="fab fa-google">&nbsp; Google</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
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

               // if (!passwordPattern.test(val)) {
                    //if (!$(this).hasClass('form-input-error')) {
                        //$(this).addClass('form-input-error');
                      //  $(this).parent().find('.form-validation-error').text('Requires 8 characters of numbers and letters');
                    //    validPass = false;
                  //  }
                //} else {
                    //$(this).removeClass('form-input-error');
                    //$(this).parent().find('.form-validation-error').text('');
                  //  validPass = true;
                //}
                //submitBtn.attr('disabled', !validUsername || !validPass);
            });

        });
    </script>
@endpush
