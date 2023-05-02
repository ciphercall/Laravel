@extends('material.layouts.slim')
@section('content')
<style>
    .radio{
        float: left;
        margin-right: 10%;
    }
</style>
    <div class="main-content" >
        <div class="row justify-content-center">
            <div class="col-8 card" style="min-width: 407px;">
                <div class="card-header-primary text-center" style="font-size: 178%;">
                    {{--  <h3>Sign Up</h3>  --}}
                    AnazBD Seller
                </div>
                <div class="card-body">
                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="" style="text-align:end">
                                    <span style="font-size: 14px">All ready have an account? <a
                                            href="{{ route('seller.login.form') }}">Sign In</a></span>
                                    </div>

                                    <div class="space-6"></div>
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <div class="row" id="headsup_display" style="display: none">
                                        <div class="col my-3 alert text-center bg-dark">
                                            <span id="headsup_message" class="text-white">SomeAlert</span>
                                        </div>
                                    </div>
                                    
                                    <form class="form-horizontal" role="form"
                                          action="{{ route('seller.register.post') }}" method="Post">
                                        @csrf

                                        {{--  Mobile Page  --}}
                                        <div class="row mt-4">
                                            <div class="col-sm-6 col-md-6 col-lg-3">
                                                <h5>Mobile:</h5>
                                            </div>
                                                {{-- uncomment for OTP --}}
                                            {{-- <div class="col-sm-6 col-md-6 col-lg-6"> --}}
                                                {{-- without otp --}}
                                            <div class="col">
                                                <input value="{{ old('mobile') }}" type="text" name="mobile" id="mobile" class="form-control border-info">
                                                @error('mobile') <span class="text-danger">{{ $message }}</span> @enderror
                                                <span id="mobile_error" style="color: red"></span>
                                            </div>
                                            {{-- <div class="col-sm-6 col-md-6 col-lg-3">
                                                <div id="sendOTP">
                                                    <button type="button" disabled id="otp_btn" class="btn btn-outline-success btn-block">Send OTP</button>
                                                </div>
                                                 <div id="resendOTP" style="display: none">
                                                    <button type="button" id="otp_btn_resend" class="btn btn-outline-warning btn-block">Resend OTP</button>
                                                </div> 
                                            </div> --}}
                                            {{-- <div class="col-12 text-center">
                                                <button type="button" id="otp_recieved_btn" class="btn btn-link">Alredy Recieved OTP?</button>
                                            </div> --}}
                                        </div>
                                        {{--  Complete Registration with OTP --}}
                                        {{-- <div class="row mt-3" id="general_informations" @if(!session()->has('errors'))
                                            style="display: none"
                                        @endif> --}}
                                        {{--  Complete Registration with OTP --}}
                                        <div class="row mt-3" id="general_informations" style="display: block">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-3 ">
                                                        <h5>Account:</h5>
                                                    </div>
                                                    <div class="col">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio"
                                                                       id="business"
                                                                       required
                                                                       name="type"
                                                                       @if (old('type') == '1')
                                                                           checked="checked"
                                                                       @endif
                                                                       class="ace"
                                                                       value="1">
                                                                <span class="lbl" style="font-size: 14px;">Business</span>
                                                            </label>
                                                        </div>
                                                
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio"
                                                                       id="personal"
                                                                       required
                                                                       class="ace"
                                                                       name="type"
                                                                       @if (old('type') == '0')
                                                                           checked="checked"
                                                                       @endif
                                                                       value="0">
                                                                <span class="lbl" style="font-size: 14px;">Personal</span>
                                                            </label>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-12 my-1">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <h5>Name: <span class="text-danger">*</span></h5>
                                                    </div>
                                                    <div class="col">
                                                        <input value="{{ old('name') }}" required type="text" name="name" id="name" class="form-control border-info">
                                                        @error('name') <span class="text-danger">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <h5>Shop Name: <span class="text-danger">*</span></h5>
                                                    </div>
                                                    <div class="col">
                                                        <input value="{{ old('shop_name') }}" required type="text" name="shop_name" id="name" class="form-control border-info">
                                                        @error('shop_name') <span class="text-danger">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-12 my-1">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <h5>OTP Code: <span class="text-danger">*</span></h5>
                                                    </div>
                                                    <div class="col">
                                                        <input required value="{{ old('otp') }}" type="number" name="otp" id="name" class="form-control border-info">
                                                        @error('otp') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="col-12 my-1">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-3">
                                                        <h5>Password: <span class="text-danger">*</span></h5>
                                                    </div>
                                                    <div class="col">
                                                        <input required type="password" placeholder="Minimum 8 characters of letters and numbers" name="password" id="name" class="form-control border-info">
                                                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <div class="row">
                                                    <div class="col-3"></div>
                                                    <div class="col">
                                                        {!! NoCaptcha::display() !!}
                                                        @if ($errors->has('g-recaptcha-response'))
                                                            <span class="text-danger">
                                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-1">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-3"></div>
                                                    <div class="col">
                                                        <div class="radio">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input"
                                                                name="terms" required
                                                                type="checkbox">  I've read and understood <a
                                                                href="/quick-page/terms-and-conditions"
                                                                target="_blank">AnazBD's Terms & Conditions</a>
                                                              </label>
                                                              @error('terms') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-2 text-center">
                                                <button type="submit" class="btn btn-primary">Register</button>
                                            </div>
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
@endsection
@push('js')
    <!--[if !IE]> -->
    <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>

     {!! NoCaptcha::renderJs() !!}

    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>" + "<" + "/script>");
    </script>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    {{--radio button select event to show some instruction--}}
    <script>
        $('input:radio[name="type"]').change(
            function () {
                var personal = "Individual will need Personal Identity card and at least 18 years old in order to sell as Individual on AnazBD";
                var business = "Please make sure you have active Business License in order to sell on AnazBD as a Corporate";

                $('#headsup_display').fadeIn(1000);

                if (this.checked && this.id == 'personal') {
                    $('#headsup_display').css('display','block');
                    $('#headsup_message').html(personal);
                } else if (this.checked && this.id == 'business') {
                    $('#headsup_display').css('display','block');
                    $('#headsup_message').html(business);
                }
                $('#headsup_display').fadeOut(30000);
            });

            const otpSendBtn = $('#otp_btn');
            const otpResendBtn = $('#resendOTP');
            const mobilePattern = /^01[0-9]{9}$/;
            const otpRecievedBtn = $('#otp_recieved_btn');

            $('#mobile').on('input', function (e) {
                const val = $(this).val().toString().trim();
                $(this).val(val);

                if (!mobilePattern.test(val)) {
                    $('#mobile_error').html("Enter a Valid Mobile Number.");
                    otpSendBtn.attr('disabled','disabled')
                    $('#mobile_error').show();
                } else {
                    $('#mobile_error').hide();
                    otpSendBtn.removeAttr('disabled')
                }
            });

            otpSendBtn.click(function () {
                const val = $('#mobile').val().toString().trim();
                sendOTP(val)
                otpRecievedBtn.fadeOut();
            });

            {{--  otpResendBtn.click(function(){
                const val = $('#mobile').val().toString().trim();
                sendOTP(val)
            });  --}}
            otpRecievedBtn.click(function(){
                $('#general_informations').fadeIn(1000);
                addResendOtpBtn();
                otpRecievedBtn.fadeOut();
            });
            function sendOTP(val){

                $.post('{{route('seller.otp.send')}}',
                {
                    mobile: val,

                },function (res) {
                   
                    $('#general_informations').fadeIn(1000);
                   addResendOtpBtn();

                }).fail(function(error){
                    let hrml = "";
                    $.each(error.responseJSON.errors,function(index,val){
                        hrml += val;
                    });
                    showHeadsUp(hrml);
                });
            }

            function showHeadsUp(html){
                $('#headsup_display').fadeIn(1000);
                $('#headsup_message').html(html);
                $('#headsup_display').fadeOut(10000);
            }

            function hideSendOtpBtn(){
                otpSendBtn.fadeOut();
            }

            function addResendOtpBtn(){
                hideSendOtpBtn();
                otpResendBtn.fadeIn();
                otpResendBtn.disabled = true
                setTimeout(function(){  
                    otpResendBtn.disabled = false;
                }, 30000);
            }
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

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': '{{@csrf_token()}}'}
        });
    </script>
@endpush
