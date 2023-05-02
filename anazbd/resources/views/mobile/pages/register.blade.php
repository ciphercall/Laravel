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

<style>
    #month.option{
        color: black;
    }
</style>

 <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center" style="background-color: white;">
      <!-- Background Shape-->
      {{--  <div class="background-shape"></div>  --}}
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img class="big-logo" src="{{ asset('frontend/assets/anazlogo.png') }}" alt="">
            <!-- Register Form-->
            <div class="register-form mt-5 px-4">
                <form action="{{ route('frontend.user.register.post') }}" method="Post">
                    @csrf
                    <div class="form-group text-left mb-4">
                        <span>Mobile / Email *</span>
                        <label for="username"><i class="lni lni-user"></i></label>
                        <input class="form-control" id="username" type="text" name="username" placeholder="Please enter your mobile number / email address" required />
                        <span class="form-validation-error">
                            {{$errors->first('username')}}
                        </span>
                    </div>
                    <div class="form-group text-left mb-4">
                        <span>Full Name</span>
                        <label for="name"><i class="lni lni-envelope"></i></label>
                        <input class="form-control" id="name" type="text" name="full_name" placeholder="Enter your first and last name" required />
                        <span class="form-validation-error">{{$errors->first('full_name')}}</span>
                    </div>
                    <span class="text-left" for="code">Verification Code *</span>

                    <div class="input-group mb-3">
                        <label for="username"></label>
                        <input type="text" class="form-control" placeholder="Enter OTP" pattern="[0-9]*" inputmode="numeric" data-meta="Field" id="otp" name="otp" />
                        <div class="input-group-append">
                            <button id="otp_send" class="btn btn-outline-secondary" type="button">Send</button>
                        </div>
                        <span class="form-validation-error">{{$errors->first('otp')}}</span>
                    </div>
                    <div class="form-group text-left mb-4">
                        <span>Password</span>
                        <label for="password"><i class="lni lni-lock"></i></label>
                        <input class="input-psswd form-control" name="password" id="password" type="password" required />
                        <span class="form-validation-error">{{$errors->first('password')}}</span>
                    </div>
                    {{--  <!-- Birthday -->
                    <label class="form-group text-left" for=""><span> Birthday </span></label>
                    <div class="input-group" style="">
                        <div class="form-group" style="width: 25%;">
                            <select class="form-control" name="month" id="month" required>
                                <option value="">Month</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option style="color:black" value="{{$i}}">{{date('F',mktime(0,0,0,$i,10))}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="form-group" style="width: 25%;" required>
                            <select class="form-control" name="day" id="" required>
                                <option value=" ">Day</option>
                                @for ($i = 1; $i <= 31; $i++)
                                <option style="color:black" value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group" style="width: 25%;">
                            <select class="form-control" name="year" id="" required>
                                <option>Year</option>
                                @for ($i=(now()->year)-12; $i < (now()->year); $i--)
                                <option style="color:black" value="{{ $i }}">{{ $i }}</option>
                                @if ($i == (now()->year)-60) @break @endif @endfor
                            </select>
                        </div>
                        <div class="form-group" style="width: 25%;">
                            <select class="form-control" name="gender" id="" required>
                                <option value=" ">Gender</option>
                                <option style="color:black"value="Male">Male</option>
                                <option style="color:black"value="Female">Female</option>
                                <option style="color:black"value="Other">Other</option>
                            </select>
                        </div>
                    </div>  --}}
                    <button class="btn btn-success btn-lg w-100" type="submit">Sign Up</button>
                </form>
                <div class="row">
                    <div class="col-12 p-2">
                        <p>Or You can login using social app.</p>
                    </div>
                    {{--  <div class="col-6">  --}}
{{--                            <a href="{{ route('sign-in.facebook.redirect') }}"--}}
{{--                                               class="btn btn-block btn-social btn-facebook social-width fb" type="button" style="background-color: royalblue;color: white;">--}}
{{--                                <i class="fab fa-facebook-f"></i>--}}
{{--                            </a>--}}
                    {{--  </div>  --}}
                    <div class="col">
                        <a href="{{ route('sign-in.google.redirect') }}"
                                           class="btn btn-block btn-lg btn-danger btn-social btn-google-plus social-width go" type="button" style="background-image: url('mobile/images/googlebutton.png')">
                            <i class="fab fa-google">&nbsp; Google</i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Login Meta-->
            <div class="login-meta-data">
              <p class="mt-3 mb-0">Already have an account?<a class="ml-1" href="{{ url('/login') }}">Sign In</a></p>
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

                 //if (!passwordPattern.test(val)) {
                  //   if (!$(this).hasClass('form-input-error')) {
                  //       $(this).addClass('form-input-error');
                  //       $(this).parent().find('.form-validation-error').text('Requires 8 characters of numbers and letters');
                  //   }
                // } else {
                 //    $(this).removeClass('form-input-error');
                 //    $(this).parent().find('.form-validation-error').text('');
                // }
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
                 let data = {
                     'username':val,
                     '_token': "{{{ csrf_token() }}}"
                 }
                 $.post('{{route('frontend.otp.send')}}',
                     data,
                     function (res) {
                         console.log(res);
                     });
             });
         });
     </script>
 @endpush
