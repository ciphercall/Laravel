@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Login/Registration
@endsection
@push('css')
    <!-- Bootstrap CSS -->
    <link href="{{asset('login_registration_form/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{asset('login_registration_form/css/style.css')}}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('login_registration_form/css/all.min.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('login_registration_form/css/responsive.css')}}">
    <!-- Custom CSS -->
    {{--    <link rel="stylesheet" href="{{asset('login_registration_form/css/custom.css')}}">--}}
    <link rel="stylesheet" href="{{asset('SlideToUnlock/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/circlebars@1.0.3/dist/circle.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/circlebars@1.0.3/dist/skins/yellowcircle.css">
@endpush
@section('content')
    <!-- Account Login & register start  -->
    <div id="particles-js" class="main-form-box">
        <div class="md-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="panel panel-login" style="border: 0;">
                            <div class="logo-top"
                                 style="background-color: white;opacity: 0.7;border-radius: 0 0 83px 83px;">
                                <a href="#"><img style="height: 100%;width: auto;"
                                                 src="{{asset('frontend/assets/anazlogo.png')}}" alt=""/></a>
                            </div>
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-xl-6">
                                        <a href="#" class="active" id="login-form-link">Login</a>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xl-6">
                                        <a href="#" id="register-form-link">Register</a>
                                    </div>
                                    <div class="or">OR</div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form id="login-form" action="{{ url('login') }}?redirect={{url()->previous()}}" method="post" role="form"
                                              @if (session('resettingPassword') ?? false)
                                              style="display: none;"
                                              @else
                                              style="display: block;"
                                            @endif>
                                            @csrf
                                            <div class="form-group">
                                                <label class="icon-lp"><i class="fas fa-user-tie"></i></label>
                                                <input type="text" name="username" id="username" tabindex="1"
                                                       class="form-control" placeholder="Mobile" value="" required="">
                                                <span
                                                    class="form-validation-error">{{$errors->first('username')}} </span>
                                            </div>
                                            <div class="form-group">
                                                <label class="icon-lp"><i class="fas fa-key"></i></label>
                                                <input type="password" name="password" id="password" tabindex="2"
                                                       class="form-control" placeholder="Password" required="">
                                                <span
                                                    class="form-validation-error">{{$errors->first('password')}}</span>
                                            </div>
                                            <div class="che-box">
                                                <label class="checkbox-in">
                                                    <input name="remember" type="checkbox" tabindex="3" id="remember">
                                                    <span></span>
                                                    Remember Me
                                                </label>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 offset-sm-3">
                                                        <input type="submit" name="login-submit" id="submit-login"
                                                               tabindex="4" class="form-control btn btn-login"
                                                               value="Log In">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <a href="#" tabindex="5" class="forgot-password">Forgot
                                                                Password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <ul>
                                                <li>
                                                    <a href="{{ route('sign-in.facebook.redirect') }}"
                                                       style="background-color: #0355d2;" class="tw btn btn-block"><i
                                                            class="fab fa-facebook"></i> Connect with
                                                        Facebook
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('sign-in.google.redirect') }}"
                                                       style="background-color: crimson;" class="tw btn btn-block"><i
                                                            class="fab fa-google"></i> Connect with
                                                        Google
                                                    </a>
                                                </li>
                                            </ul>
                                        </form>
                                        <form href="#" id="register-form" action="{{ route('frontend.user.register') }}"
                                              method="post" role="form"
                                              @if (session('resettingPassword') ?? false)
                                              style="display: none;"
                                              @else
                                              style="display: none;"
                                            @endif>
                                            @csrf

                                            <a id="mob_edit"
                                               style="position: absolute;left: 475px;top: 89px;z-index: 1;display: none;"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <div class="form-group">
                                                <label class="icon-lp"><i class="fas fa-user-tag"></i></label>
                                                <input type="text"
                                                       data-url="{{ route('frontend.user.register') }}" name="name"
                                                       id="name" tabindex="1"
                                                       class="form-control" placeholder="Enter Your Full Name..."
                                                       value=""
                                                       required=""/>
                                                <a id="nm_rqr" style="display: none;">
                                                    <h4 style="color: red;"></h4>
                                                </a>

                                            </div>
                                            <div class="form-group">
                                                <label class="icon-lp"><i class="fas fa-mobile-alt"></i></label>
                                                <input onkeypress="slider()" type="text"
                                                       data-url="{{ route('frontend.user.register') }}" name="mobile"
                                                       id="mobile" tabindex="1"
                                                       class="form-control" placeholder="Enter Your Mobile No..."
                                                       value=""
                                                       required="">
                                            </div>
                                            <div class="form-group" id="pass_group" style="display: none;">
                                                <label class="icon-lp"><i class="fas fa-key"></i></label>
                                                <input type="password" name="password" id="password_reg" tabindex="2"
                                                       class="form-control" placeholder="Password" required="">
                                            </div>
                                            <div class="form-group" id="otp_group" style="display: none;">
                                                <label class="icon-lp"><i
                                                        class="fas fa-sort-numeric-down-alt"></i></label>
                                                <input name="otp" id="otp" tabindex="1"
                                                       class="form-control" placeholder="Enter OTP here..." value=""
                                                       required=""
                                                       style="text-indent: 39px;height: 56px;border-radius: 30px;">
                                            </div>
                                            <div class="form-group">
                                                <div id="page-wrap" style="padding-top: 0;width: 100%;">
                                                    <div id="well"
                                                         style="background: cadetblue;height: 62px;width: 100%;">
                                                        <h2 style="font-size: 144%;top: -7px;width: 104%;">
                                                            <strong id="slider" class="ui-draggable ui-draggable-handle"
                                                                    style="position: relative; background-size: 62px 42px; width: 67px; height: 42px; top: 0px; transform: translateX(0px); transition: none 0s ease 0s;"></strong>
                                                            <span>slide to send OTP</span>
                                                        </h2>
                                                    </div>
                                                    <div id="otpStatus" style="display: none;">
                                                        <h3 style="color: darkcyan;font-size: 30px;">OTP Successfully
                                                            sent to the mobile...</h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div id="circle-1" data-circle-dialWidth=10
                                                                 style="position: relative;left: 32%;top: 14%;width: 130px;height: 130px;display: none;">
                                                                <div class="loader-bg">
                                                                    <div class="text">00:00:00</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="icon-lp"><i class="fas fa-key"></i></label>--}}
                                            {{--                                                <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required="">--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="form-group">--}}
                                            {{--                                                <label class="icon-lp"><i class="fas fa-key"></i></label>--}}
                                            {{--                                                <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" required="">--}}
                                            {{--                                            </div>--}}

                                            <div class="che-box">
                                                <label class="checkbox-in">
                                                    <input name="checkbox" type="checkbox"> <span></span>I agree to the
                                                    <a href="#"> Terms and Conditions </a> and <a href="#">Privacy
                                                        Policy </a>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 offset-sm-3">
                                                        <input style="display: none;" type="button"
                                                               name="register-submit" id="register-submit"
                                                               tabindex="4" class="form-control btn btn-register"
                                                               value="Register Now" onclick="register()">
                                                    </div>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <button class="fb"><i class="fab fa-facebook-f"></i> Connect with
                                                        Facebook
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="{{ route('sign-in.google.redirect') }}"
                                                       style="background-color: crimson;" class="tw btn btn-block"><i
                                                            class="fab fa-google"></i> Connect with
                                                        Google
                                                    </a>
                                                </li>
                                            </ul>

                                        </form>
                                        <form action="{{ route('frontend.reset.password') }}" method="POST"
                                              class="reset_form"
                                              @if (session('resettingPassword') ?? false)
                                              style="display: block;"
                                              @else
                                              style="display: none;"
                                            @endif>
                                            @csrf
                                            <div class="col-sm-9 col-md-9 offset-md-2">
                                                <div class="text-center">
                                                    <h5>Password Reset Form</h5>
                                                </div>
                                                <div class="form-group" id="message_board">

                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="text-dark">Mobile</label>
                                                    <input type="text" value="{{ old('mobile') }}"
                                                           placeholder="Enter Your Mobile Number" class="form-control"
                                                           name="mobile" id="reset_mobile">
                                                    @error('mobile') <span
                                                        class="text-danger">{{ $message }}</span> @enderror
                                                </div>

                                                <div id="reset_send_section"
                                                     @if (session('resettingPassword') ?? false)
                                                     style="display: none;"
                                                     @else
                                                     style="display: block;"
                                                    @endif>
                                                    <div class="col text-center">
                                                        <button id="reset_otp_send_btn" disabled class="btn btn-success"
                                                                type="button"><span class="text-dark">Send OTP</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="reset_section"
                                                     @if (session('resettingPassword') ?? false)
                                                     style="display: block;"
                                                     @else
                                                     style="display: none;"
                                                    @endif>
                                                    <div class="form-group">
                                                        <label for="" class="text-dark">OTP</label>
                                                        <input type="number" value="{{ old('otp') }}"
                                                               class="form-control" name="otp" required>
                                                        @error('otp') <span
                                                            class="text-danger">{{ $message }}</span> @enderror

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="text-dark">Password</label>
                                                        <input type="password" class="form-control" name="password"
                                                               required>
                                                        @error('password') <span
                                                            class="text-danger">{{ $message }}</span> @enderror

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="text-dark">Password Confirmation</label>
                                                        <input type="password" class="form-control"
                                                               name="password_confirmation" required>
                                                    </div>
                                                    <div class="col text-center">
                                                        <button class="btn btn-success"><span
                                                                class="text-dark">Reset</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="footer-company-name">All Rights Reserved. &copy; 2020 <a href="#">AnazBD.com</a>
                            Design By : <a href="#">AnazBD Developer Team</a></p>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Account Login & register end  -->

@endsection
@push('js')
    {{--    <script src="{{asset('login_registration_form/js/jquery.min.js')}}"></script>--}}
    {{--    <script src="{{asset('login_registration_form/js/bootstrap.min.js')}}"></script>--}}
    <script src="{{asset('login_registration_form/js/particles.min.js')}}"></script>
    <script src="{{asset('login_registration_form/js/index.js')}}"></script>
    <script src="https://unpkg.com/circlebars@1.0.3/dist/circle.js"></script>
    {{--    <script src="{{asset('SlideToUnlock/js/slidetounlock.js')}}"></script>--}}
    <script type="text/javascript">
        let resetOTPBtn = $("#reset_otp_send_btn");
        let resetSendBtnSection = $("#reset_send_section");
        let resetSection = $("#reset_section");
        let messageBoard = $("#message_board");
        let resetMobile = $("#reset_mobile");
        let resetForm = $(".reset_form");


        $(function () {

            $('#login-form-link').click(function (e) {
                $("#login-form").delay(100).fadeIn(100);
                $("#register-form").fadeOut(100);
                resetForm.fadeOut()
                $('#register-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
            $('#register-form-link').click(function (e) {
                $("#register-form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                resetForm.fadeOut()
                $('#login-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
            resetOTPBtn.click(function () {
                let request = $.ajax({
                    url: "{{ route('frontend.reset.otp') }}",
                    type: "POST",
                    data: {mobile: resetMobile.val()}
                });

                request.done(function (response) {
                    resetSection.fadeIn();
                    resetSendBtnSection.fadeOut();

                    // re-appear OTP after 15 sec
                    setTimeout(function () {
                        let d = resetSendBtnSection.find('#reset_otp_send_btn').find('span');
                        d.text('Resend OTP');
                        resetSendBtnSection.fadeIn();

                    }, 30000);
                    // re-appear OTP after 15 sec


                    messageBoard.html(`
                        <div class="alert alert-success">OTP sent Successfully.</div>
                    `);
                    messageBoard.fadeIn()
                    messageBoard.fadeOut(10000);
                });

                request.fail(function (jqxhr, status, error) {
                    messageBoard.html(`
                        <div class="alert alert-danger">Selected Mobile Number is Invalid.</div>
                    `);
                    messageBoard.fadeIn()
                });
            });
            resetMobile.keyup(function () {
                let val = resetMobile.val();
                checkMobile(val)
            });
            $("#mob_edit").click(function () {
                $("#mobile").removeAttr("disabled");
            });
            $(document).on("click", ".forgot-password", function (e) {
                $("#login-form").fadeOut(100);
                $(".reset_form").fadeIn(100);
            });
        });

        // slide to unlock
        function slider() {
            let otpFail = true;
            let mobileChk = $('#mobile').val().length;
            if (mobileChk === 10) {
                var exec = false;
                $("#slider").draggable({
                    axis: 'x',
                    containment: 'parent',
                    drag: function (event, ui) {
                        if (ui.position.left > 250) {
                            // OTP Send start
                            if (exec == false) {
                                exec = true;
                                console.log("this is: " + $("#mobile").data('url'));
                                const val = $('#mobile').val().toString().trim();
                                // console.log(val);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $.post($("#mobile").data('url'), {mobile: val})
                                    .done(function (res) {
                                        console.log(res);
                                        $('#otpStatus h3').html("OTP Sent Successfully!").css('color', 'green');
                                        // making pass group visible
                                        $('#otp_group').fadeIn();
                                        $('#pass_group').fadeIn();
                                        // making pass group visible
                                        otpFail = false;
                                    })
                                    .fail(function (xhr, status, error) {
                                        // error handling
                                        // console.log('xhr: '+xhr+' '+'status: '+status+' '+'error: '+error);
                                        let mobile = error;
                                        $('#otpStatus h3').html("Something went wrong. Try again later.").css('color', 'red');
                                        {{--if (mobile !== undefined || null || "") {--}}
                                        {{--    console.log('may day: ' + JSON.parse(xhr.responseText).errors.mobile);--}}
                                        {{--    // console.log('may day: '+JSON.stringify(xhr));--}}

                                        {{--    $('#otpStatus h3').html(JSON.parse(xhr.responseText).errors.mobile).css('color', 'red');--}}
                                        {{--    // OTP fail consequences--}}
                                        {{--    $('#otp_group').hide();--}}
                                        {{--    $('#pass_group').hide();--}}
                                        {{--    otpFail = true;--}}
                                        // otp resent
                                        // let sameMobile = (JSON.parse(xhr.responseText).errors.mobile)[0];
                                        // if (sameMobile === "The mobile has already been taken.") {
                                        $.post('{{route('frontend.reset.otp')}}', {mobile: $('#mobile').val()}).done(function (res) {
                                            $('#otpStatus h3').html("OTP Re-sent Successfully!").css('color', 'DarkMagenta');
                                            $('#otp_group').fadeIn();
                                            $('#pass_group').fadeIn();

                                        }).fail(function (xhr, status, error) {
                                            $('#otpStatus h3').html("Something is wrong during OTP re-sent!").css('color', 'pink');
                                        });
                                        // }
                                        // otp resent

                                        {{--    // OTP fail consequences--}}

                                        {{--}--}}

                                    });
                            }

                            //OTP send End

                            $("#well").fadeOut();
                            $("#mob_edit").fadeOut();
                            setTimeout(function () {
                                $("#mobile").attr("disabled", true);

                                // checking if otp is failed
                                if (otpFail === false) {
                                    $("#otp_group").fadeIn();
                                }
                                // checking if otp is failed

                                $("#mob_edit").fadeIn();
                                $('#otpStatus').fadeIn(1000, function () {
                                    $('#otpStatus').fadeOut(1000, function () {
                                        $("#register-submit").fadeIn();
                                        // checking if otp is failed
                                        if (otpFail === true) {
                                            $("#circle-1").Circlebar({
                                                maxValue: 120,
                                                fontSize: "25px",
                                                triggerPercentage: false
                                            });
                                            $('#well').hide();
                                            $("#circle-1").show();
                                            // $('#well').fadeIn(1000, function () {
                                            //     $("#slider").css('left', 0);
                                            // });
                                            setTimeout(function () {
                                                $("#circle-1").hide();
                                                $('#well').fadeIn(1000, function () {
                                                    $("#slider").css('left', 0);
                                                });
                                            }, 120000);
                                            $("#mob_edit").fadeIn();
                                            exec = false;

                                        } else {
                                            setTimeout(function () {
                                                $("#circle-1").Circlebar({
                                                    maxValue: 120,
                                                    fontSize: "25px",
                                                    triggerPercentage: false
                                                });
                                                $('#circle-1').fadeIn(function () {

                                                    setTimeout(function () {
                                                        $('#well').fadeIn(1000, function () {
                                                            $("#slider").css('left', 0);
                                                        });
                                                        $('#circle-1').fadeOut(function () {
                                                            $("#mob_edit").fadeIn();
                                                            exec = false;
                                                        });
                                                    }, 120000);
                                                });
                                            }, 1002);
                                        }
                                        // checking if otp is failed
                                    });
                                });
                            }, 1000);
                            // $('#counter').fadeIn(1000);

                        } else {
                            // Apparently Safari isn't allowing partial opacity on text with background clip? Not sure.
                            // $("h2 span").css("opacity", 100 - (ui.position.left / 5))
                        }

                    },
                    stop: function (event, ui) {
                        if (ui.position.left < 251) {
                            exec = false;
                            $(this).animate({
                                left: 0
                            })
                        }
                    }
                });

                // The following credit: http://www.evanblack.com/blog/touch-slide-to-unlock/

                {{--$('#slider')[0].addEventListener('touchmove', function (event) {--}}
                {{--    event.preventDefault();--}}
                {{--    var el = event.target;--}}
                {{--    var touch = event.touches[0];--}}
                {{--    curX = touch.pageX - this.offsetLeft - 73;--}}
                {{--    if (curX <= 0) return;--}}
                {{--    if (curX > 250) {--}}
                {{--        // OTP Send start--}}
                {{--        if (exec == false) {--}}
                {{--            exec = true;--}}
                {{--            console.log("this is: " + $("#mobile").data('url'));--}}
                {{--            const val = $('#mobile').val().toString().trim();--}}
                {{--            // console.log(val);--}}
                {{--            $.ajaxSetup({--}}
                {{--                headers: {--}}
                {{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                {{--                }--}}
                {{--            });--}}
                {{--            // $.post($("#mobile").data('url'),--}}
                {{--            //     {--}}
                {{--            //         mobile: val--}}
                {{--            //     },--}}
                {{--            //     function (res) {--}}
                {{--            //         console.log(res);--}}
                {{--            //     });--}}
                {{--            $.post($("#mobile").data('url'), {mobile: val})--}}
                {{--                .done(function (res) {--}}
                {{--                    console.log(res);--}}
                {{--                    $('#otpStatus h3').html("OTP Sent Successfully!").css('color', 'green');--}}
                {{--                    // making pass group visible--}}
                {{--                    $('#otp_group').fadeIn();--}}
                {{--                    $('#pass_group').fadeIn();--}}
                {{--                    // making pass group visible--}}
                {{--                    otpFail = false;--}}
                {{--                })--}}
                {{--                .fail(function (xhr, status, error) {--}}
                {{--                    // error handling--}}
                {{--                    alert("error")--}}
                {{--                    // console.log('xhr: '+xhr+' '+'status: '+status+' '+'error: '+error);--}}
                {{--                    let mobile = error;--}}
                {{--                    if (mobile !== undefined || null || "") {--}}
                {{--                        console.log('may day: ' + JSON.parse(xhr.responseText).errors.mobile);--}}
                {{--                        // console.log('may day: '+JSON.stringify(xhr));--}}
                {{--                        $('#otpStatus h3').html(JSON.parse(xhr.responseText).errors.mobile).css('color', 'red');--}}
                {{--                        // OTP fail consequences--}}
                {{--                        $('#otp_group').hide();--}}
                {{--                        $('#pass_group').hide();--}}
                {{--                        otpFail = true;--}}

                {{--                        // otp resent--}}
                {{--                        let sameMobile = (JSON.parse(xhr.responseText).errors.mobile)[0];--}}
                {{--                        if (sameMobile === "The mobile has already been taken.") {--}}
                {{--                            $.post('{{route('sign-up.otp.resend')}}', {mobile: $('#mobile').val()}).done(function (res){--}}
                {{--                                $('#otpStatus h3').html("OTP Re-sent Successfully!").css('color', 'DarkMagenta');--}}
                {{--                                $('#otp_group').fadeIn();--}}
                {{--                                $('#pass_group').fadeIn();--}}
                {{--                            }).fail(function (xhr, status, error){--}}
                {{--                                $('#otpStatus h3').html("Something is wrong during OTP re-sent!").css('color', 'pink');--}}
                {{--                            });--}}
                {{--                        }--}}
                {{--                        // otp resent--}}
                {{--                        // OTP fail consequences--}}
                {{--                    }--}}
                {{--                });--}}
                {{--        }--}}

                {{--        //OTP send End--}}
                {{--        $("#well").fadeOut();--}}
                {{--        $("#mob_edit").fadeOut();--}}
                {{--        setTimeout(function () {--}}
                {{--            $("#mobile").attr("disabled", true);--}}

                {{--            // checking if otp is failed--}}
                {{--            if (otpFail === false) {--}}
                {{--                $("#otp_group").fadeIn();--}}
                {{--            }--}}
                {{--            // checking if otp is failed--}}

                {{--            $("#mob_edit").fadeIn();--}}
                {{--            $('#otpStatus').fadeIn(1000, function () {--}}
                {{--                $('#otpStatus').fadeOut(1000, function () {--}}
                {{--                    $("#register-submit").fadeIn();--}}

                {{--                    // checking if otp is failed--}}
                {{--                    if (otpFail === true) {--}}
                {{--                        $("#circle-1").hide();--}}
                {{--                        $('#well').fadeIn(1000, function () {--}}
                {{--                            $("#slider").css('left', 0);--}}
                {{--                        });--}}
                {{--                        $("#mob_edit").fadeIn();--}}
                {{--                        exec = false;--}}

                {{--                    } else {--}}
                {{--                        setTimeout(function () {--}}
                {{--                            $("#circle-1").Circlebar({--}}
                {{--                                maxValue: 120,--}}
                {{--                                fontSize: "25px",--}}
                {{--                                triggerPercentage: false--}}
                {{--                            });--}}
                {{--                            $('#circle-1').fadeIn(function () {--}}
                {{--                                setTimeout(function () {--}}
                {{--                                    $('#well').fadeIn(1000, function () {--}}
                {{--                                        $("#slider").css('left', 0);--}}
                {{--                                    });--}}
                {{--                                    $('#circle-1').fadeOut(function () {--}}
                {{--                                        $("#mob_edit").fadeIn();--}}
                {{--                                        exec = false;--}}
                {{--                                    });--}}
                {{--                                }, 120000);--}}
                {{--                            });--}}
                {{--                        }, 1002);--}}
                {{--                    }--}}
                {{--                    // checking if otp is failed--}}

                {{--                });--}}
                {{--            });--}}
                {{--        }, 1000);--}}
                {{--        // $('#counter').fadeIn(1000);--}}
                {{--    }--}}
                {{--    el.style.webkitTransform = 'translateX(' + curX + 'px)';--}}
                {{--}, false);--}}


                $('#slider')[0].addEventListener('touchend', function (event) {
                    this.style.webkitTransition = '-webkit-transform 0.3s ease-in';
                    this.addEventListener('webkitTransitionEnd', function (event) {
                        this.style.webkitTransition = 'none';
                    }, false);
                    this.style.webkitTransform = 'translateX(0px)';
                }, false);

            }

        }

        // slide to unlock


        function checkMobile(val) {
            let exp = new RegExp('^01[0-9]{9}$');
            attachError(exp.test(val))
            return exp.test(val)
        }

        function attachError(res) {
            if (res) {
                messageBoard.fadeOut();
                resetOTPBtn.removeAttr("disabled")
            } else {
                let ele = `
                    <div class="alert alert-danger">Invalid Phone Number</div>
                `;
                resetOTPBtn.attr("disabled", "disabled")
                messageBoard.html(ele)
                messageBoard.fadeIn()
            }

        }

        $('.form-group input').focus(function () {
            $(this).parent().addClass('addcolor');
        }).blur(function () {
            $(this).parent().removeClass('addcolor');
        });

        function register() {
            console.log("this is: " + $("#mobile").data('url'));
            const val = $('#mobile').val().toString().trim();
            const otp = $('#otp').val().toString().trim();
            const pass = $('#password_reg').val().toString().trim();
            const name = $('#name').val().toString().trim();
            if (name.length > 0) {
                // console.log(val);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post($("#mobile").data('url'),
                    {
                        name: name,
                        mobile: val,
                        otp: otp,
                        password: pass
                    },
                    function (res) {
                        // console.log(res);

                        // var mobile = res.mobile;
                        // var password = res.password;
                        //
                        // $('#username').val(mobile);
                        // $('#password').val(password);
                        //
                        // $('#submit-login').click();

                        // localStorage.setItem('newReg', 'yes');

                        // $('#login-form-link').click();
                        location.replace('{{url('/')}}');

                    });

            } else {
                // alert("please enter your so-called name!");
                $('#nm_rqr').fadeIn();
                $('#nm_rqr h4').html('Please enter your name').css('color','red');
                setTimeout(function (){
                    $('#nm_rqr').fadeOut();
                },3000);
            }
        }

    </script>
@endpush
