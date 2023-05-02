@extends('mobile.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    aboutus
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.6/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous"/>
    <style>
        #drop_zn {
            border-radius: 27px;
        }

        .dz-button {
            font-size: 20px !important;
        }
    </style>
@endpush
@section('mobile')
{{--    <!--breadcrumbs area start-->--}}
{{--    <div class="breadcrumbs_area">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="breadcrumb_content">--}}
{{--                        <ul>--}}
{{--                            <li><a href="{{ url('/') }}">Home</a></li>--}}
{{--                            <li>Upload & Order</li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--breadcrumbs area end-->--}}

    <!--about bg area start-->
    <div class="about_bg_area">
        <div class="container">

            <!--services img area-->
            <div class="about_gallery_section mb-55">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <article class="single_gallery_section"
                                 style="border-radius: 20px;background: url('https://drive.google.com/uc?export=download&id=1OhuM3yE9ASy9UxO7v-h1jh2wf-B4E13N');background-size: contain;background-repeat: round;">
                            <figure>
                                <figcaption class="about_gallery_content">
                                    <div class="col-12 offset-3" style="margin: 0;">
                                        <div class="row">
                                            <div
                                                style="border-radius: 18px; width: 100%; background: linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73))">
                                                <div class="col-12 text-center"
                                                     style="background:  url('https://drive.google.com/uc?export=download&id=1ICtvHOPPTEKCmBOVx3jAqbEh0V_uo3Ck');height: 117px;background-size: 24% 100%;background-repeat: no-repeat;">
                                                    <h4 style="font-size: 27px;position: relative;top: 34%;left: 10%;">Upload &
                                                        Order</h4>
                                                </div>
                                            </div>
                                        </div>
                                        @isset($order)

                                        @else
                                            @guest
                                                <form action="{{url('/login')}}?redirect={{url()->current()}}" method="post"
                                                      style="display: none; margin-bottom: 23px;margin-top: 24px;background: linear-gradient(rgba(255, 255, 0, 0.23) 0%, rgba(170, 0, 255, 0.21) 100%), url('https://drive.google.com/uc?export=download&id=1blZQLjWEXPJzbzHy3SRY0OLYl9EplLWe');padding: 21px;border-radius: 18px;background-size: 100% 100%;"
                                                      id="login_order">

                                                    <div id="login-form" class="row justify-content-center">
                                                        @csrf
                                                        <div class="col-12 form-group">
                                                            <label style="color: black;" for="">Mobile</label>
                                                            <input type="text" name="username" class="form-control">
                                                            @if($errors->has('mobile'))<small
                                                                class="text-danger">{{$errors->first('mobile')}}</small>@endif
                                                        </div>
                                                        <div class="col-12 form-group">
                                                            <label style="color: black;" for="">Password</label>
                                                            <input type="password" name="password" class="form-control">
                                                            @if($errors->has('password'))<small
                                                                class="text-danger">{{$errors->first('password')}}</small>@endif
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row" style="margin-bottom: 23px;margin-top: 11px;">
                                                                <div class="col-12" style="text-align: center;">
                                                                    <lable></lable>
                                                                    <button id="btn_login_order" class="btn btn-success">
                                                                        Login
                                                                    </button>
                                                                </div>
                                                                {{--                                                            <div class="col"><input type="checkbox" checked><span style="font-size: 17px;"> &nbsp  Order Without Logging In</span>--}}
                                                                {{--                                                            </div>--}}
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12" style="font-size: 19px;text-align: center;border-bottom: 1px solid black;padding-bottom: 1px;color: black;">Log In using
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin-top: 5px;">
                                                                <ul>
                                                                    <li>
                                                                        <a href="{{ route('sign-in.facebook.redirect') }}"
                                                                           style="background-color: #3a7cd6;" class="btn btn-block text-white"><i
                                                                                class="fab fa-facebook"></i> Connect with
                                                                            Facebook
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="{{ route('sign-in.google.redirect') }}"
                                                                           style="background-color: #dd576e;" class="btn btn-block text-white"><i
                                                                                class="fab fa-google"></i> Connect with
                                                                            Google
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="{{route('frontend.self.order.store')}}" method="POST"
                                                      style="display: block;padding: 13px;background: url('https://drive.google.com/uc?export=download&id=1G-zpr1dm85nrcIb8m-McYI1LDtHICRbL'),linear-gradient(to bottom, rgba(0,255,221,0.23) 0%, rgba(0,21,255,0.21) 100%);margin-top: 19px;border-radius: 22px;background-size: contain;"
                                                      id="guest_form">
                                                    @csrf
                                                    <div
                                                        style="background-color: rgba(255,255,255,0.8);padding: 10px;border-radius: 13px;">
                                                        <div class="row" id="guest">
                                                            <div class="form-group col-12">
                                                                <label style="color: black;" style="color: black;" for="">Name</label>
                                                                <input value="{{old('name')}}" type="text" name="name" class="form-control"
                                                                       style="background-color: rgba(255,255,255,0.8);">
                                                                @if($errors->has('name'))<small
                                                                    class="text-danger">{{$errors->first('name')}}</small>@endif
                                                            </div>
                                                            <div class="form-group col-12">
                                                                <label style="color: black;" style="color: black;" for="">Mobile</label>
                                                                <input value="{{old('mobile_order')}}" type="text" name="mobile_order" class="form-control"
                                                                       style="background-color: rgba(255,255,255,0.8);">
                                                                @if($errors->has('mobile_order'))<small
                                                                    class="text-danger">{{$errors->first('mobile_order')}}</small>@endif
                                                            </div>
                                                            <div class="form-group col-12">
                                                                <label style="color: black;" style="color: black;" for="">Address</label>
                                                                <textarea cols="20" rows="4" name="address"
                                                                          class="form-control"
                                                                          style="background-color: rgba(255,255,255,0.8);">{{old('address')}}</textarea>
                                                                @if($errors->has('address'))<small
                                                                    class="text-danger">{{$errors->first('address')}}</small>@endif
                                                            </div>
                                                        </div>
                                                        <div class="row" style="padding-bottom: 15px;margin-top: 10px;">
                                                            <div class="col" style="text-align: center;">
                                                                <button class="btn btn-info" id="nxt_btn">
                                                                    Next
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col" id="guest_chk_col">
                                                    <input id="guest_chk" type="checkbox"><span style="font-size: 17px;"> &nbsp  Order by Logging In</span>
                                                </div>

                                            @else
                                                <div>
                                                    <div class="row" id="guest_next"
                                                         style="margin-top: 18px;background: url('https://drive.google.com/uc?export=download&id=1io7rrH7H9RBk8Ln7ozFgG4OTB4RQchJJ'),linear-gradient(to bottom, rgba(117, 19, 93, 0.73),rgba(245, 246, 252, 0.52));padding: 20px;border-radius: 16px;background-size: 100% 100%;min-height: 340px;">
                                                        <form action="{{route('frontend.self.order.store')}}" method="POST">
                                                            @csrf
                                                            <div class="row" id="">
                                                                <div class="form-group col-12">
                                                                    <label style="color: black;" style="color: black;" for="">Name</label>
                                                                    <input type="text" name="name" class="form-control"
                                                                           value="{{auth('web')->user()->name}}"
                                                                           style="background-color: rgba(255,255,255,0.8);">
                                                                    @if($errors->has('name'))<small
                                                                        class="text-danger">{{$errors->first('name')}}</small>@endif
                                                                </div>
                                                                <div class="form-group col-12">
                                                                    <label style="color: black;" style="color: black;" for="">Mobile</label>
                                                                    <input type="text" name="mobile_order"
                                                                           value="{{auth('web')->user()->mobile}}"
                                                                           class="form-control"
                                                                           style="background-color: rgba(255,255,255,0.8);">
                                                                    @if($errors->has('mobile_order'))<small
                                                                        class="text-danger">{{$errors->first('mobile_order')}}</small>@endif
                                                                </div>
                                                                <div class="form-group col-12">
                                                                    <label style="color: black;" style="color: black;" for="">Address</label>
                                                                    <textarea
                                                                        style="background-color: rgba(255,255,255,0.8);"
                                                                        cols="20" rows="4" name="address"
                                                                        class="form-control">{{ auth('web')->user()->billing_address->first() != null ? auth('web')->user()->billing_address->first()->complete_address : '' }}</textarea>
                                                                    @if($errors->has('address'))<small
                                                                        class="text-danger">{{$errors->first('address')}}</small>@endif
                                                                </div>
                                                            </div>
                                                            <div class="row" style="padding-bottom: 15px;margin-top: 10px;">
                                                                <div class="col" style="text-align: center;">
                                                                    <button class="btn btn-info" id="nxt_btn">
                                                                        Next
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endguest
                                        @endisset

                                        {{--                                        @if($selfOrder != null)--}}
                                        {{--                                            <form class="dropzone" action="{{route('frontend.self.order.image',az_hash($selfOrder->id))}}" method="post">--}}

                                        @isset($order)
                                        <div
                                            style="display: none; margin-top: 34px;padding: 8%;border-radius: 18px;background: url('https://drive.google.com/uc?export=download&id=1dfvyredR8Bvz8NX7zbGfdmQWPW07EzfT') 0% 0% / 100% 100%, linear-gradient(rgba(52, 195, 247, 0.51) 0%, rgba(77, 230, 39, 0.45) 100%);min-width: 100%;"
                                            id="drop_div" class="col-12">
                                            <form class="dropzone" action="{{route('frontend.self.order.image',$order->id)}}" method="post" id="drop_zn"
                                                  style="background-color: rgba(255,255,255,0.8);">
                                                @csrf
                                            </form>
                                        </div>
                                            <div class="row mt-3">
                                                <div class="col text-center">
                                                    <a href="{{url('/')}}" class="btn btn-sm btn-success">Done</a>
                                                </div>

                                            </div>
                                        @endisset
                                        {{--                                        @endif--}}
                                    </div>
                                </figcaption>
                            </figure>
                        </article>
                    </div>
                </div>

            </div>
            <!--services img end-->

        </div>
    </div>
    <!--about bg area end-->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.6/min/dropzone.min.js"
            integrity="sha512-KgeSi6qqjyihUcmxFn9Cwf8dehAB8FFZyl+2ijFEPyWu4ZM8ZOQ80c2so59rIdkkgsVsuTnlffjfgkiwDThewQ=="
            crossorigin="anonymous"></script>

    <script>
        $('#btn_login_order').on('click', function () {
            $('#guest_chk_col').hide();
            localStorage.setItem('order_redirect', 'true');
            $('#login_order').submit();
        })
        $('#nxt_btn').on('click', function () {
            localStorage.setItem('clicked_nxt', 'true');
            location.reload();
        });

        $('#guest_chk').on('change', function () {
            if ($('#guest_chk').prop('checked') === true) {
                $('#guest_form').hide();
                $('#login_order').show();
            } else {
                $('#login_order').hide();
                $('#guest_form').show();
            }
        });

        $(document).ready(function () {
            // $('#drop_div').hide();
            // var data_frm = $('#guest').css('display');
            // console.log(data_frm);
            // var gn = $('#guest_next').css('display');
            // if (gn === 'flex') {
            //     $('#guest_chk_col').hide();
            // }

            var redirected = localStorage.getItem('order_redirect');
            if (redirected === 'true') {
                localStorage.setItem('order_redirect', 'false');
                // $('#guest_form').show();
            }
            if (localStorage.getItem('clicked_nxt') === 'true') {
                localStorage.setItem('clicked_nxt', 'false');
                // $('#nxt_btn').hide();
            }
            $('#drop_div').show();
        });
    </script>
@endpush
