<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('frontend.include.header')
    <style>
        input::placeholder {
            color: gray;
            font-weight: 100;
            font-size: 14px;
        }

        select.form-control{
            font-size: 13px;
            padding: 0;
            color: gray;
        }

        #otp_send:disabled {
            color: gray;
            cursor: default;
        }

        button[type=submit]:disabled {
            cursor: default;
            background-color: gray !important;
        }

        .login_page_bg {
            padding: 30px 0;
            width: 810px;
            margin: auto;
            background: white;
        }

        .login_page_bg .container {
            padding: 0;
        }

        .account_form button {
            margin-left: 0;
        }

        .offer-checkbox {
            display: flex;
            align-items: start;
        }

        .offer-checkbox input[type=checkbox] {
            margin-right: 6px;
        }

        .login_submit {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lost-password {
            text-align: left;
            font-size: 12px;
            color: #0388a2;
            width: 100%;
            display: inline-block;
            margin: 5px 0;
        }

        .mod-input.mod-input-password.mod-login-input-password {
            margin-bottom: 0;
        }
    </style>
</head>

<body style="overflow: hidden; position: relative">
<div class="login_page_bg">
    <div class="container">
        <!-------------
        | LOGIN
        -------------->
        <div class="customer_login" id="login-div">
            <!-- r1 -->
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
                <div class="col-lg-10 col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 style="font-size: 22px;color: #424242;font-weight: 400;">
                                Welcome to
                                <a href="{{url('/')}}" style="color:red" target="_blank">Anaz</a>!
                                Please login.
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="login-other">
                                <span>New member? <a id="register-here" href="{{ url('register') }}">Register here</a>.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- r2 -->
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
                <div class="col-lg-10 col-md-10" style="background: white;padding: 20px">
                    <form action="#" style="border: 0" method="POST">
                        @csrf
                        <div class="row">
                            <!-- left -->
                            <div class="col-md-6">
                                <div class="account_form login">
                                    <!-- Username -->
                                    <p>
                                        <label class="register-phone" for="login_username">Mobile / Email
                                            <span>*</span></label>
                                        <span class="clearable">
                                                <input type="text"
                                                       id="login_username"
                                                       name="username"
                                                       placeholder="Enter your mobile no / email address"
                                                       required>
                                                <i class="clearable__clear" aria-hidden="true">&times;</i>
                                                    <span class="form-validation-error">
                                                        {{$errors->first('username')}}
                                                    </span>
                                            </span>
                                    </p>


                                    <!-- Password -->
                                    <p class="mod-input mod-input-password mod-login-input-password">
                                        <label class="register-password" for="login_password">Password
                                            <span>*</span></label>
                                        <input type="password"
                                               id="login_password"
                                               name="password"
                                               placeholder="Enter your password"
                                               required>
                                        <span class="form-validation-error">{{$errors->first('password')}}</span>
                                        <a href="#" class="lost-password">Lost your
                                            password?</a>
                                    </p>
                                    <div class="login_submit">
                                        <label for="remember" style="margin-bottom: 0">
                                            <input id="remember" name="remember" type="checkbox">
                                            Remember me
                                        </label>
                                        <button type="submit" id="if-login" disabled>Login</button>
                                    </div>
                                </div>
                            </div>

                            <!-- right -->
                            <div class="col-md-6">
                                <div class="account_form login">
                                    <!-- <h2>Register</h2> -->

                                    <form action="" style="border: 0; padding-right: 0">
                                        <section>
                                            <p class="or-login text-left" style="color: gray; font-size: 13px">Or, Login
                                                With</p>
                                            <button class="btn btn-block btn-social btn-facebook social-width fb"
                                                    type="button" disabled>
                                                <i class="fa fa-facebook"></i> Facebook
                                            </button>

                                            <a href="{{ route('sign-in.google.redirect') }}" class="btn btn-block btn-social btn-google-plus social-width go"
                                                    type="button">
                                                <i class="fa fa-google-plus"></i> Google
                                            </a>
                                        </section>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-------------
        | REGISTER
        -------------->
        <div class="customer_login" id="register-div" style="display: none">
            <!-- r1 -->
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
                <div class="col-lg-10 col-md-10">
                    <div class="row">
                        <div class="col-md-6">

                            <h3 style="font-size: 22px;color: #424242;font-weight: 400;">
                                Create your
                                <a href="{{url('/')}}" style="color:red" target="_blank">Anaz</a>
                                Account.
                            </h3>
                        </div>
                        <div class="col-md-6">
                            <div class="login-other">
                                <span>Already member? <a id="login-here" href="{{url('/login')}}">Login here</a>.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- r2 -->
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
                <div class="col-lg-10 col-md-10" style="background: white;padding: 20px">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="account_form login">
                                    <!-- Username -->
                                    <p>
                                        <label class="register-phone" for="register_username">Mobile / Email
                                            <span>*</span></label>
                                        <span class="clearable">
                                                <input type="text"
                                                       id="register_username"
                                                       name="username"
                                                       placeholder="Enter your mobile no / email address"
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
                                            <label for="register_otp">Verification Code <span>*</span></label>
                                            <input type="text"
                                                   placeholder="Enter verification Code"
                                                   data-meta="Field"
                                                   id="register_otp"
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
                                        <label class="register-password" for="register_password">Password
                                            <span>*</span></label>
                                        <input type="password"
                                               id="register_password"
                                               name="password"
                                               placeholder="At least 8 characters long digits and letters"
                                               required>
                                        <span class="form-validation-error">{{$errors->first('password')}}</span>
                                    </div>
                                    </p>

                                    <!-- Birthday -->
                                    <label class="register-phone" for=""><span>Birthday *</span></label>
                                    <div class="input-group" style="">
                                        <div class="form-group" style="width: 25%">
                                            <select class="form-control" name="month" id="register_month" required>
                                                <option value="">Month</option>
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{$i}}">{{date('F',mktime(0,0,0,$i,10))}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 25%" required>
                                            <select class="form-control" name="day" id="register_day" required>
                                                <option value=" ">Day</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 25%">
                                            <select class="form-control" name="year" id="register_year" required>
                                                <option>Year</option>
                                                @for ($i=(now()->year)-12; $i < (now()->year); $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @if ($i == (now()->year)-60)
                                                        @break
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 25%">
                                            <select class="form-control" name="gender" id="register_gender" required>
                                                <option value="">Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="account_form login">
                                    <!-- Full Name -->
                                    <p>
                                        <label class="register-password" for="register_full_name">Full name
                                            <span>*</span></label>
                                        <input type="text"
                                               id="register_full_name"
                                               name="full_name"
                                               placeholder="Enter your full name"
                                               required>
                                        <span class="form-validation-error">{{$errors->first('full_name')}}</span>
                                    </p>

                                    <!-- Subscription -->
                                    <div class="offer-checkbox">
                                        <input type="checkbox"
                                               id="register_subscription"
                                               name="subscription"
                                               value="on"
                                               style="height: auto; width: auto"
                                               checked>
                                        <label style="color: gray; user-select: none" for="register_subscription">
                                            I want to receive exclusive offers and promotions.
                                        </label>
                                    </div>

                                    <!-- Sign Up -->
                                    <div class="register-style">
                                        <button id="if-signup" type="submit" disabled>SIGN UP</button>
                                        <br>
                                    </div>

                                    <!-- Notice -->
                                    <div class="offer-checkbox" style="padding-top: 10px">
                                        <small style="color: gray">By signing up I agree to
                                            <a href="{{url('/')}}" target="_blank" style="color:red">ANAZ </a>
                                            <span style="color:#049cb9">Privacy Policy</span>
                                        </small>
                                    </div>

                                    <!-- Social -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p style="margin: 5px 0"><small style="color: gray">Or, sign up with</small>
                                            </p>
                                        </div>
                                        <div class="col-md-5">
                                            <button class="btn register-width fb">
                                                <i class="fa fa-facebook"></i> Facebook
                                            </button>
                                        </div>

                                        <div class="col-md-5">
                                            <button class="btn  register-width go">
                                                <i class="fa fa-google-plus"></i> Google
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/jquery-2.1.4.min.js')}}"></script>

<script>
    $(document).ready(function () {
        // setup
        $.ajaxSetup({
            headers:
                {'X-CSRF-TOKEN': '{{@csrf_token()}}'}
        });
        $('#login-here').on('click', function (e) {
            e.preventDefault();
            $('#login-div').css('display', 'block');
            $('#register-div').css('display', 'none');
        });
        $('#register-here').on('click', function (e) {
            e.preventDefault();
            $('#login-div').css('display', 'none');
            $('#register-div').css('display', 'block');
        });


        // pattern
        const emailPattern = /^\S+@\S+\.\S+$/;
        const mobilePattern = /^01[0-9]{9}$/;
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        const otpPattern = /^[0-9]{6}$/;
        const fullNamePattern = /^\S{2,}( \S{2,}){1,3}$/;
        const specialCharPattern = /[0-9`~!@#$%^&*()\-_=+\[\]{};:'"\\|/.,]/;

        // login
        const lgSubmit = $('#if-login');
        const lgUsername = $('#login_username');
        const lgPassword = $('#login_password');
        let lgValidUsername = false;
        let lgValidPassword = false;

        lgUsername.on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!emailPattern.test(val) && !mobilePattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('Must be a valid mobile no / email address');
                    lgValidUsername = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                $(this).parent().find('.form-validation-error').text('');
                lgValidUsername = true;
                lgPassword.val(lgPassword.val().toString()).trigger('input');
            }
            lgSubmit.attr('disabled', !lgValidUsername || !lgValidPassword);
        });

        lgPassword.on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!/^\S+$/.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    lgValidPassword = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                $(this).parent().find('.form-validation-error').text('');
                lgValidPassword = true;
            }
            lgSubmit.attr('disabled', !lgValidUsername || !lgValidPassword);
        });

        lgSubmit.on('click', function (e) {
            e.preventDefault();
            $.post('{{route('frontend.user.login.ajax')}}',
                {
                    username: lgUsername.val().toString().trim(),
                    password: lgPassword.val().toString().trim(),
                },
                function (res) {
                    if (res.status) {
                        parent.$('meta[name=token]').attr("content", res['token']);
                        $.ajaxSetup({
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', res['token']);
                            }
                        });
                        parent.iframeSuccess(window);
                    } else {
                        lgUsername.parent().find('.form-validation-error').text('These credentials do not match our records');
                    }
                });
        });

        // signup
        const spSubmit = $('#if-signup');
        const spUsername = $('#register_username');
        const spOTP = $('#register_otp');
        const spPassword = $('#register_password');
        const spFullName = $('#register_full_name');
        const spMonth = $('#register_month');
        const spDay = $('#register_day');
        const spYear = $('#register_year');
        const spGender = $('#register_gender');
        let spValidUsername = false;
        let spValidPassword = false;
        let spValidOTP = false;
        let spValidFullName = false;
        let spValidMonth = false;
        let spValidDay = false;
        let spValidYear = false;
        let spValidGender = false;

        function getSPDisabled() {
            return !spValidUsername || !spValidPassword || !spValidOTP || !spValidFullName || !spValidMonth
                || !spValidDay || !spValidYear || !spValidGender;
        }

        spUsername.on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!emailPattern.test(val) && !mobilePattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('Must be a valid mobile no / email address');
                    $('#otp_send').attr('disabled', true);
                    spValidUsername = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                $(this).parent().find('.form-validation-error').text('');
                $('#otp_send').attr('disabled', false);
                spValidUsername = true;
                spPassword.val(spPassword.val().toString()).trigger('input');
            }
            spSubmit.attr('disabled', getSPDisabled());
        });

        spOTP.on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!otpPattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    $(this).parent().parent().find('.form-validation-error').text('Requires a 6 digit code');
                    spValidOTP = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                $(this).parent().parent().find('.form-validation-error').text('');
                spValidOTP = true;
            }
            spSubmit.attr('disabled', getSPDisabled());
        });

        spPassword.on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!passwordPattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('Requires 8 characters of numbers and letters');
                    spValidPassword = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                $(this).parent().find('.form-validation-error').text('');
                spValidPassword = true;
            }
            spSubmit.attr('disabled', getSPDisabled());
        });

        spFullName.on('input', function (e) {
            const val = $(this).val().toString().replace(specialCharPattern, '');
            $(this).val(val);

            if (!fullNamePattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    $(this).parent().find('.form-validation-error').text('Requires first name, last name');
                    spValidFullName = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                $(this).parent().find('.form-validation-error').text('');
                spValidFullName = true;
            }
            spSubmit.attr('disabled', getSPDisabled());
        });

        spMonth.on('change', function (){
            spValidMonth = !isNaN($(this).val());
            spSubmit.attr('disabled', getSPDisabled());
        });

        spDay.on('change', function (){
            spValidDay = !isNaN($(this).val());
            spSubmit.attr('disabled', getSPDisabled());
        });

        spYear.on('change', function (){
            spValidYear = !isNaN($(this).val());
            spSubmit.attr('disabled', getSPDisabled());
        });

        spGender.on('change', function (){
            const val = $(this).val().toString().trim().toLowerCase();
            spValidGender = val === 'male' || val === 'female' || val === 'other';
            spSubmit.attr('disabled', getSPDisabled());
        });

        spSubmit.on('click', function (e) {
            e.preventDefault();
            $.post('{{route('frontend.user.register.ajax')}}',
                {
                    username: spUsername.val().toString().trim(),
                    otp: spOTP.val().toString().trim(),
                    password: spPassword.val().toString().trim(),
                    full_name: spFullName.val().toString().trim()
                },
                function (res) {
                    if (res.status) {
                        $('#login-here').click();
                    } else {
                        spUsername.parent().find('.form-validation-error').text('Invalid input. Please try again.');
                    }
                });
        });

        // otp send
        $('#otp_send').on('click', function () {
            const val = spUsername.val().toString().trim();

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
</body>
</html>
