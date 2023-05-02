<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>Delivery Login | Anaz </title>

    <meta name="description" content="User login page"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}"/>

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css') }}"/>

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}"/>


    <link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}"/>

    <style>
        .red {
            color: red !important;
        }
    </style>

</head>

<body class="login-layout light-login">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12 ">
                <div class="login-container login-width-new">
                    <div class="left">
                        <h1>
                            {{-- <i class="ace-icon fa fa-leaf green"></i> --}}
                            <span class="white text-left" style="color: #403b3b!important;font-size: 20px"
                                  id="id-text2">Welcome! You are just one step away to sell on Anaz.</span>
                        </h1>

                    </div>

                    <div class="space-12"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    {{-- <div class="" style="text-align:end">
                                        <span style="font-size: 14px">New Member? <a
                                                href="{{ route('seller.register.form') }}">Sign Up</a></span>
                                    </div> --}}
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
                                    <form class="form-horizontal" role="form" action="{{ route('delivery.login.post') }}"
                                          method="Post">
                                        @csrf
                                        {{-- Mobile --}}
                                        <div class="form-group">
                                            <label class="col-sm-3 " for="mobile">
                                                email <span class="red">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                       id="mobile"
                                                       name="email"
                                                       placeholder="Your mobile"
                                                       class="col-xs-10 col-sm-10"
                                                       required>
                                            </div>
                                        </div>

                                        {{-- Password --}}
                                        <div class="form-group">
                                            <label class="col-sm-3 " for="password">
                                                Password <span class="red">*</span>
                                            </label>

                                            <div class="col-sm-9">
                                                <input type="password"
                                                       id="password"
                                                       name="password"
                                                       placeholder="password"
                                                       class="col-xs-10 col-sm-10"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="space-4"></div>
                                        <input type="hidden" name="remember" value="true">

                                        <div class="clearfix form-actions">
                                            <div class="pull-right">
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
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>


<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>" + "<" + "/script>");
</script>

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>


<!-- inline scripts related to this page -->
<script type="text/javascript">

    //you don't need this, just used for changing background
    jQuery(function ($) {
        $('#btn-login-dark').on('click', function (e) {
            $('body').attr('class', 'login-layout');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-light').on('click', function (e) {
            $('body').attr('class', 'login-layout light-login');
            $('#id-text2').attr('class', 'grey');
            $('#id-company-text').attr('class', 'blue');

            e.preventDefault();
        });
        $('#btn-login-blur').on('click', function (e) {
            $('body').attr('class', 'login-layout blur-login');
            $('#id-text2').attr('class', 'white');
            $('#id-company-text').attr('class', 'light-blue');

            e.preventDefault();
        });

        const mobilePattern = /^01[0-9]{9}$/;
        // const passwordPattern = /^(?=.*\d)[A-Za-z\d]{8,}$/;
        const submitBtn = $('#submit-login');
        let validPass = true;
        let validMobile = true;

        // username
        $('#username').on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!mobilePattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    validMobile = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                validMobile = true;
            }
            submitBtn.attr('disabled', !validMobile || !validPass);
        });

        // password
        $('#password').on('input', function (e) {
            const val = $(this).val().toString().trim();
            $(this).val(val);

            if (!passwordPattern.test(val)) {
                if (!$(this).hasClass('form-input-error')) {
                    $(this).addClass('form-input-error');
                    validPass = false;
                }
            } else {
                $(this).removeClass('form-input-error');
                validPass = true;
            }
            submitBtn.attr('disabled', !validMobile || !validPass);
        });
    });
</script>

{{-- Sweet Alert--}}
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
    @if(session()->get('message'))
    swal.fire({
        title: "Success",
        html: "<b>{{ session()->get('message') }}</b>",
        type: "success",
        timer: 1000
    });
    @elseif(session()->get('error'))
    swal.fire({
        title: "Error",
        html: "<b>{{ session()->get('error') }}</b>",
        type: "error",
        timer: 1000
    });
    @endif

    $('.success').fadeIn('slow').delay(10000).fadeOut('slow');
</script>
</body>

</html>
