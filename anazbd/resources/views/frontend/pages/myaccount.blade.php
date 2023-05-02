@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    My Account
@endsection
<style>

    .nice-select {
        float: none !important;
    }

    .info-box {
        display: block;
        min-height: 90px;
        background: #fff;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        border-radius: 2px;
        margin-bottom: 15px;
    }

    .info-box-content {
        padding: 5px 10px;
        margin-left: 90px;
    }

    .info-box-icon {
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
        display: block;
        float: left;
        height: 90px;
        width: 90px;
        text-align: center;
        font-size: 45px;
        line-height: 90px;
    }

    .card-counter {
        box-shadow: 2px 2px 10px #DADADA;
        margin: 5px;
        padding: 20px 10px;
        background-color: #fff;
        height: 100px;
        border-radius: 5px;
        transition: .3s linear all;
    }

    .card-counter:hover {
        box-shadow: 4px 4px 20px #DADADA;
        transition: .3s linear all;
    }

    .card-counter.info {
        background-color: #6d3eb3;
    / / purpleish color: #FFF;
    }

    .card-counter.danger {
        background-color: #ef5350;
        color: #FFF;
    }

    .card-counter.success {
        background-color: #5ba33c;
        color: #FFF;
    }

    .card-counter.primary {
        background-color: #6ba1d6;
        color: #FFF;
    }

    .card-counter.warning {
        background-color: #f0a02a;
        color: #FFF;
    }

    .card-counter i {
        font-size: 5em;
        opacity: 0.2;
    }

    .card-counter .count-numbers {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 32px;
        display: block;
    }

    .card-counter .count-name {
        position: absolute;
        right: 35px;
        top: 65px;
        font-style: italic;
        text-transform: capitalize;
        opacity: 0.5;
        display: block;
        font-size: 18px;
    }
</style>
<style type="text/css">
    * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }

    table, tbody {
        vertical-align: top;
        overflow: visible;
    }
</style>
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
    <!-- my account start  -->
    <div class="account_page_bg">
        <div class="container">
            <section class="main_content_area">
                <div class="account_dashboard">
                    <div class="row">
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <!-- Nav tabs -->
                            <div class="dashboard_tab_button">
                                <ul role="tablist" class="nav flex-column dashboard-list">
                                    <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a>
                                    </li>
                                    <li><a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                                    {{-- <li><a href="#downloads" data-toggle="tab" class="nav-link">Downloads</a></li> --}}
                                    <li><a href="#address" data-toggle="tab" class="nav-link">Addresses</a></li>
                                    <li><a href="#account-details" data-toggle="tab" class="nav-link
                                        @if (collect(request()->segments())->last() == "account/update") active show @endif">Account
                                            details</a></li>
                                    <li><a id="chngPassTriggr" href="#changePassword" data-toggle="tab" class="nav-link">Change Password</a>
                                    </li>
                                    <li><a href="#" onclick="event.preventDefault(); $('#logout').submit()"
                                           class="nav-link">logout</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-9 col-lg-9">
                            <!-- Tab panes -->
                            <div class="tab-content dashboard_content" id="tabs">
                                <div class="tab-pane fade show active" id="dashboard">
                                    {{--                                    cashback container--}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-counter"
                                                 style="background-image:  linear-gradient(to right, rgba(52,107,247,0.27) 0%, rgba(231,56,39,1) 100%), url(https://drive.google.com/uc?export=download&id=1iEKlZPkKw115WveTGfkRun4XDXqK_z2F);background-size: contain; background-repeat: no-repeat; background-position: left;">

                                                <span class="count-numbers">{{ $cashBack->amount ?? 0  }}</span>
                                                <span class="count-name">Total Cashback</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-counter"
                                                 style="background-image: linear-gradient(to left, rgba(52,195,247,1) 0%, rgba(77,230,39,0.51) 100%),url(https://drive.google.com/uc?export=download&id=1q0NhTMKwtXVnfRENCP1Fi0JVRyEnVSYu);background-size: contain; background-repeat: no-repeat; background-position: left;">
                                                <a href="{{ $points->amount > 0 ? route('user.account.point') : '#' }}">
                                                <span class="count-numbers">{{ $points->amount ?? 0 }}</span>
                                                <span class="count-name">Total Dark Elixir</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                    cashback container--}}


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-counter primary">
                                                <i class="fas fa-shopping-cart"></i>
                                                <span class="count-numbers">{{ count($orders) }}</span>
                                                <span class="count-name">Total Orders</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-counter warning">
                                                <i class="fas fa-clock"></i>
                                                <span
                                                    class="count-numbers">{{ $orders->where('status','Pending')->count() }}</span>
                                                <span class="count-name">Pending</span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-counter success">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span
                                                    class="count-numbers">{{ $orders->where('status','Accepted')->count() }}</span>
                                                <span class="count-name">Accepted</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-counter info">
                                                <i class="fas fa-truck"></i>
                                                <span
                                                    class="count-numbers">{{ $orders->where('status','On Delivery')->count() }}</span>
                                                <span class="count-name">On Delivery</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-counter danger">
                                                <i class="fas fa-window-close"></i>
                                                <span
                                                    class="count-numbers">{{ $orders->where('status','Cancelled')->count() }}</span>
                                                <span class="count-name">Cancelled</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card-counter success">
                                                <i class="fas fa-box-open"></i>
                                                <span
                                                    class="count-numbers">{{ $orders->where('status','Delivered')->count() }}</span>
                                                <span class="count-name">Delivered</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <table style="border-collapse:collapse;margin-left: 23rem;" cellspacing="0">
                                        <tr style="height:76pt">
                                            <td style="width:77pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt; background-color: #0c82df">
                                                <p style="text-indent: 0pt;text-align: center;font-size: 25pt;padding-top: 23pt;">
                                                    112
                                                </p>
                                            </td>
                                            <td style="background-color: #00b894;width:76pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                                <p style="text-indent: 0pt;text-align: center;font-size: 25pt;padding-top: 23pt;">
                                                    113
                                                </p>
                                            </td>
                                        </tr>
                                        <tr style="height:76pt">
                                            <td style="background-color: #1b4b72;width:77pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                                <p style="text-indent: 0pt;text-align: center;font-size: 25pt;padding-top: 23pt;">
                                                    114
                                                </p>
                                            </td>
                                            <td style="background-color: #3b5998;width:76pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                                                <p style="text-indent: 0pt;text-align: center;font-size: 25pt;padding-top: 23pt;">
                                                    115
                                                </p>
                                            </td>
                                        </tr>
                                    </table> -->

                                </div>
                                <div class="tab-pane fade" id="orders">
                                    <h3>Orders</h3>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($orders as $key=>$order)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-M-Y') }}</td>
                                                    <td><span class="success">{{ $order->status }}</span></td>
                                                    <td>{{ $order->total }}TK for {{ $order->items->count() }} item</td>
                                                    <td><a href="{{ route('order.view',$order->id) }}"
                                                           class="view">View</a>&nbsp;||&nbsp;<a
                                                            href="{{route('order.details',$order->id)}}" class="view">OrderDetails</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address">
                                    <h3>Address</h3>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="card  bg-light">
                                                <div class="card-header">
                                                    Billing Address
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        {{ $billing_address != null ? $billing_address->completeAddress : "" }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="card  bg-light">
                                                <div class="card-header">
                                                    Shipping Address
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        {{ $delivery_address != null ?  $delivery_address->completeAddress : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="account-details">
                                    <h3>Account details </h3>
                                    <div class="login">
                                        <div class="login_form_container">
                                            <div class="account_login_form">
                                                <form action="{{ route('user.account.save') }}" method="POST">
                                                    @csrf
                                                    <label>First Name</label>
                                                    <input type="text" name="name" value="{{auth('web')->user()->name}}"
                                                           placeholder="Full Name">
                                                    <label>Email</label>
                                                    <input type="text" name="email"
                                                           value="{{auth('web')->user()->email}}"
                                                           placeholder="example@email.com">
                                                    <span class="error"></span>
                                                    <label>Mobile</label>
                                                    <span class="error"></span>
                                                    <input type="text" name="mobile"
                                                           value="{{auth('web')->user()->mobile}}"
                                                           placeholder="01xxxxxxxxx">
                                                    <span class="error"></span>


                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1">Division
                                                            <span>*</span></label>
                                                        <select class="" name="division" id="bill_division">
                                                            @foreach($divisions as $div)
                                                                <option value="{{az_hash($div->id)}}"
                                                                    {{auth('web')->user()->division_id == $div->id ? 'selected' : ''}}>
                                                                    {{$div->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1">City
                                                            <span>*</span></label>
                                                        <select class="" name="city" id="bill_city">
                                                            <option value="" disabled>Select Area</option>
                                                            @foreach($cities as $city)
                                                                <option value="{{az_hash($city->id)}}"
                                                                    {{auth('web')->user()->city_id == $city->id ? 'selected' : ''}}>
                                                                    {{$city->name}}
                                                                </option>$billing_address->city_id ??
                                                            @endforeach
                                                        </select>
                                                        <span class="error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1">Area
                                                            <span>*</span></label>
                                                        <select class="" name="area" id="bill_area">
                                                            <option value="" disabled>Select Area</option>
                                                            @foreach($areas as $area)
                                                                <option value="{{az_hash($area->id)}}"
                                                                    {{auth('web')->user()->post_code_id == $area->id ? 'selected' : ''}}>
                                                                    {{$area->name}}
                                                                </option>$billing_address->post_code_id ??
                                                            @endforeach
                                                        </select>
                                                        <span class="error"></span>
                                                    </div>
                                                    <label>Address line One</label>
                                                    <input type="text" name="address_line_1"
                                                           value="{{auth('web')->user()->address_line_1}}"
                                                           placeholder="your streat address"><br>
                                                    <label>Address line Two</label>
                                                    <input type="text" name="address_line_2"
                                                           value="{{auth('web')->user()->address_line_2}}"
                                                           placeholder="your streat address"><br>

                                                    <div class="save_button primary_btn default_button">
                                                        <button type="submit">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="changePassword">
                                    <h3>Change Password </h3>
                                    <form id="password_change_form"
                                          action="{{ route('frontend.user.password.change') }}" method="POST">
                                        @method('PATCH')
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>New Password</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="password" id="new_password" minlength="8"
                                                       class="form-control" name="password" value=""
                                                       placeholder="Enter Your New Password" style="width: 80%;">
                                                <span
                                                    class="form-validation-error">{{$errors->first('password')}}</span>

                                            </div>

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Confirm Password</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="password" id="confirm_new_password" minlength="8"
                                                       class="form-control" name="password_confirmation" value=""
                                                       placeholder="Confirm Your New Password" style="width: 80%;">
                                                <span class="form-validation-error"
                                                      id="password_confirmation_error">{{$errors->first('password_confirmation')}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">

                                            </div>
                                            <div class="col-md-5" style="text-align: right;padding-right: 3%;">
                                                <div class="save_button primary_btn default_button">
                                                    <button type="button" onclick="return validatePassword()">Change
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- my account end   -->

@endsection
<script src="{{ asset('frontend\assets\jquery\jquery-1.8.3.min.js')}}"></script>
<script>
    function validatePassword() {
        localStorage.setItem('newReg', 'no');
        let password = document.getElementById('new_password').value;
        let confirmPassword = document.getElementById('confirm_new_password').value;
        if (password != confirmPassword) {
            $("#password_confirmation_error").text("Passwords don't Match.")
            return false;
        }
        $("#password_change_form").submit();
        return true;
    }

    $(document).ready(function (e) {
        let tab = "{{{ session('tab') }}}"

        if ("{{{ session()->has('tab') }}}") {
            $('#dashboard').removeClass('active');
            $('#changePassword').addClass('active show');
            let flash = "{{{ session()->forget('tab') }}}"
        }

        var chkReg = localStorage.getItem('newReg');
        if (chkReg === 'yes'){
            $('#chngPassTriggr').click();
        }

    });
    $(document).ready(function () {

        const mobilePattern = /^01[0-9]{9}$/;
        const emailPattern = /^\S+@\S+\.\S+$/;

        const bill_mobile = $('#bill_mobile');
        const bill_email = $('#bill_email');
        const bill_division = $('#bill_division');
        const bill_city = $('#bill_city');
        const bill_area = $('#bill_area');
        const bill_address_line_1 = $('#bill_address_line_1');
        const bill_address_line_2 = $('#bill_address_line_2');


        bill_mobile.on('input', function () {
            if (!mobilePattern.test($(this).val())) {
                $(this).parent().find('.error').text('Valid mobile number is required');
            } else {
                $(this).parent().find('.error').text('');
            }
        });

        bill_email.on('input', function () {
            if (!emailPattern.test($(this).val())) {
                $(this).parent().find('.error').text('Valid email address is required');
            } else {
                $(this).parent().find('.error').text('');
            }
        });

        bill_address_line_1.on('input', function () {
            if ($(this).val().toString().trim().length > 255)
                $(this).val($(this).val().toString().trim().substring(0, 255));
        });

        bill_address_line_2.on('input', function () {
            if ($(this).val().toString().trim().length > 255)
                $(this).val($(this).val().toString().trim().substring(0, 255));
        });

        bill_division.niceSelect();

        bill_division.on('change', function () {
            updateCities($(this).val());
        });

        bill_city.niceSelect();
        bill_city.on('change', function () {
            const val = $(this).val();
            const isDhaka = $(this).find('option:selected').text().toString().trim().includes('Dhaka');
            updateAreas(val);
        });

        bill_area.niceSelect();


        function updateCities(division) {
            $.get('{{route('frontend.checkout.cities.ajax')}}?division=' + division, function (res) {
                if (res.cities) {
                    bill_city.empty();
                    bill_city.append(`<option value="" disabled>Select Cities</option>`);
                    res.cities.forEach(function (c, i) {
                        bill_city.append(`<option value="${c.id}" ${i === 0 ? 'selected' : ''}>${c.name}</option>`);
                    });
                    bill_city.niceSelect('update');
                }
            });
        }

        function updateAreas(city) {
            $.get('{{route('frontend.checkout.areas.ajax')}}?city=' + city, function (res) {
                if (res.areas) {
                    bill_area.empty();
                    bill_area.append(`<option value="" disabled>Select Areas</option>`);
                    res.areas.forEach(function (a) {
                        bill_area.append(`<option value="${a.id}">${a.name}</option>`);
                    });
                    bill_area.niceSelect('update');
                }
            });
        }

        $

    });
</script>
