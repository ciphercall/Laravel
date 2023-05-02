@extends('material.layouts.master')
@section('title','Seller Profile')
@section('page_header','Profile')
@section('content')


    <?php
    $seller_id = auth()->id();
    $id = \App\Models\SellerProfile::where('seller_id', $seller_id)->pluck('id')->first();
    $businessAddressId = \App\Models\SellerBusinessAddress::where('seller_id', $seller_id)->pluck('id')->first();
    $returnAddressId = \App\Models\SellerReturnAddress::where('seller_id', $seller_id)->pluck('id')->first();
    ?>

    <div class="row">
        <div class="col-sm-9  col-md-9 col-lg-7 card card-primary">
            <div class="card-header-primary">
                {{ Auth('seller')->user()->name }} - Profile
            </div>
            <div class="card-body">

                <form class="form-horizontal"
                      method="post"
                      action="{{route('seller.profile.add', ['id'=>$id, 'businessId'=>$businessAddressId, 'returnId'=>$returnAddressId])}}"
                      role="form"
                      enctype="multipart/form-data">
                @csrf

                <!-- Name -->

                    <div class="row">
                        <!-- Name -->
                        <div class="col form-group">
                            <label class="" for="proprietor_name">Proprietor name <sup class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="proprietor_name"
                                       placeholder=" - Proprietor_name -"
                                       class="form-control input-sm"
                                       name="proprietor_name"

                                       value="{{($sellerId && ($seller != null)) ? $seller->proprietor_name : ''}}"
                                >
                                {{--    <strong class=" red">{{ $errors->first('proprietor_name') }}</strong>--}}
                            </div>
                        </div>

                        {{-- Company Registration number --}}

                        <div class="col form-group">
                            <label class="" for="registration_number">Company Registration number <sup
                                    class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="registration_number"
                                       placeholder=" - Registration Number -"
                                       class="form-control input-sm"
                                       name="registration_number"

                                       value="{{($sellerId && ($seller != null)) ? $seller->registration_number : ''}}"
                                >
                                <strong class=" red">{{ $errors->first('registration_number') }}</strong>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        {{-- Corporate address --}}
                        <div class="col form-group">
                            <label for="crporate_address">Corporate Address <sup class="red">*</sup></label>

                            <div>
                                <input type="text"
                                       id="crporate_address"
                                       placeholder=" - Corporate Address -"
                                       class="form-control input-sm"
                                       name="crporate_address"

                                       value="{{($sellerId && ($seller != null)) ? $seller->crporate_address : ''}}"
                                >
                                <strong class=" red">{{ $errors->first('crporate_address') }}</strong>
                            </div>
                        </div>

                        {{-- Vat Registration number --}}
                        <div class="col form-group">
                            <label for="vat_registration_number">Vat Registration number <sup
                                    class="red">*</sup></label>

                            <div>
                                <input type="text"
                                       id="vat_registration_number"
                                       placeholder=" - Vat Registration number -"
                                       class="form-control input-sm"
                                       name="vat_registration_number"

                                       value="{{($sellerId && ($seller != null)) ? $seller->vat_registration_number : ''}}"
                                >
                                <strong class=" red">{{ $errors->first('vat_registration_number') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- owners NID numberr --}}
                        <div class="col form-group">
                            <label class="" for="nid_number">Owners NID number <sup class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="nid_number"
                                       placeholder=" - NID number -"
                                       class="form-control input-sm"
                                       name="nid_number"

                                       value="{{($sellerId && ($seller != null)) ? $seller->nid_number : ''}}"
                                >
                                <strong class=" red">{{ $errors->first('nid_number') }}</strong>
                            </div>
                        </div>

                        {{-- Trade licenses --}}
                        <div class="col form-group">
                            <label class="" for="trade_licenses">Trade licenses <sup class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="trade_licenses"
                                       placeholder=" - Trade licenses -"
                                       class="form-control input-sm"
                                       name="trade_licenses"

                                       value="{{($sellerId && ($seller != null)) ? $seller->trade_licenses : ''}}"
                                >
                                <strong class=" red">{{ $errors->first('trade_licenses') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- 8. Main Business --}}
                        <div class="col form-group">
                            <label class="" for="main_business">Main Business <sup class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="main_business"
                                       placeholder=" - Trade licenses -"
                                       class="form-control input-sm"
                                       name="main_business"

                                       value="{{($sellerId && ($seller != null)) ? $seller->main_business : ''}}"
                                >
                                <strong class=" red">{{ $errors->first('main_business') }}</strong>
                            </div>
                        </div>

                        {{-- Product Category --}}

                        <div class="col form-group">
                            <label class="" for="product_category">Product Category<sup class="red">*</sup></label>

                            <div class="">
                                <input type="text" name="product_category" class="form-control"
                                       value="{{($sellerId && ($seller != null)) ? $seller->product_category : ''}}"
                                       >
                                <strong class=" red">{{ $errors->first('product_category') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- company corporate number --}}
                        <div class="col form-group">
                            <label class="" for="corporate_number">company corporate number <sup class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="corporate_number"
                                       placeholder=" - corporate number -"
                                       class="form-control input-sm"
                                       name="corporate_number"
                                       value="{{($sellerId && ($seller != null)) ? $seller->corporate_number : ''}}"

                                >
                                <strong class=" red">{{ $errors->first('corporate_number') }}</strong>
                            </div>
                        </div>

                        {{-- 13. main contact person: number --}}
                        <div class="col form-group">
                            <label class="" for="address">Main contact person: number <sup class="red">*</sup></label>

                            <div class="">
                                <input type="text"
                                       id="address"
                                       placeholder=" - address -"
                                       class="form-control input-sm"
                                       name="address"
                                       value="{{($sellerId && ($seller != null)) ? $seller->address : ''}}"

                                >
                                <strong class=" red">{{ $errors->first('corporate_number') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- 14. site location contact person and cellphone number --}}

                        <div class="col form-group">
                            <label class="" for="location_details"> Site location contact person and cellphone number <sup
                                    class="red">*</sup></label>
                            <textarea id="form-field-11" name="location_details"
                                      class="autosize-transition form-control"
                                      style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 52px;">{{($sellerId && ($seller != null)) ? $seller->location_details : ''}}</textarea>

                        </div>
                    </div>

                    <div class="row">
{{--                                                 ---seller-logo-----}}
{{--                                                <div class="col form-group">--}}
{{--                                                    <label class="text-dark font-weight-bold" for="sellerLogo"><i--}}
{{--                                                            class="material-icons">backup</i> Seller Logo &nbsp;<sub class="text-danger">*</sub></label>--}}
{{--                                                    <input type="file" id="sellerLogo" class="form-control-file" name="seller_logo"--}}
{{--                                                           accept="image/*" {{ ($sellerId && $businessAddress)??required }}>--}}

{{--                                                </div>--}}
{{--                                                <div class="col form-group">--}}
{{--                                                    <label class="text-dark font-weight-bold" for="product_image"><i class="material-icons">backup</i>--}}
{{--                                                        Highlight Product Image &nbsp;<sub class="text-danger">*</sub></label>--}}
{{--                                                    <input type="file" id="product_image" name="product_image"--}}
{{--                                                           accept="image/*" {{ ($sellerId && $businessAddress)??required }}>--}}

{{--                                                </div>--}}
                    </div>

                    <div class="row">
                        <!-- division -->
                        <div class="col form-group">
                            <label class="" for="division">Division <sup class="red">*</sup></label>

                            <div class="">
                                <div class="text-center">
                                    <select class="form-control"

                                            id="divisionId"
                                            name="division"

                                            data-placeholder="- division -">
                                        <option value="-1">---select---</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <strong class=" red">{{ $errors->first('division') }}</strong>
                            </div>
                        </div>
                        <!--city -->
                        <div class="col form-group">
                            <label class="" for="city">City <sup class="red">*</sup></label>

                            <div class="">
                                <div class="text-center">
                                    <select
                                        class="form-control"

                                        id="getCityByDivision"
                                        name="city"
                                        data-placeholder="- City -"
                                    >
                                        <option value="-1">---select---</option>
                                        @foreach($allCity as $city)
                                            <option value="{{$city->id}}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <strong class=" red">{{ $errors->first('city') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Postcode --}}

                        <div class="form-group">
                            <label class="col-sm-5 " for="postcode">Postcode <sup class="red">*</sup></label>

                            <div class="col-sm-8">
                                <div class="text-center">
                                    <select
                                        class="form-control"

                                        id="getPostcodeByCity"
                                        name="postcode"
                                        data-placeholder="- postcode -">
                                        <option value="-1">---select---</option>
                                        @foreach($allArea as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <strong class=" red">{{ $errors->first('postcode') }}</strong>
                            </div>
                        </div>
                    </div>


                    <hr>

                    <h3>Business Address</h3>

                    <div class="" style="margin-bottom: 20px">
                        <p style="float: left;margin-right: 10%;"> Same as Warehouse Address</p> <input type="checkbox"
                                                                                                        id="business_check"
                                                                                                        checked="">
                    </div>
                    <div id="business_class">
                        <div class="row">
                            <!-- Address -->
                            <div class="col form-group">
                                <label class=" " for="business_address">business_address <sup class="red">*</sup></label>

                                <div class="">
                                    <input type="text"
                                           id="business_address"
                                           placeholder=" - address -"
                                           class="form-control input-sm"
                                           name="business_address"

                                           value="{{($sellerId && $businessAddress) ? $businessAddress->business_address : ''}}">
                                    <strong class=" red">{{ $errors->first('business_address') }}</strong>
                                </div>
                            </div>

                            <!-- division -->
                            <div class="col form-group">
                                <label class="" for="business_division">Division<sup class="red">*</sup></label>

                                <div class="">
                                    <div class="text-center">
                                        <select class="form-control"

                                                id="divisionIdForBusiness"
                                                name="business_division"
                                                data-placeholder="- division -">
                                            <option value="-1">---select---</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <strong class=" red">{{ $errors->first('business_division') }}</strong>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <!--city -->
                            <div class="col form-group">
                                <label class="" for="business_city">City <sup class="red">*</sup></label>

                                <div class="">
                                    <div class="text-center">
                                        <select
                                            class="form-control"

                                            id="getCityByDivisionForBusinessAddress"
                                            name="business_city"
                                            data-placeholder="- City -"
                                        >
                                            <option value="-1">---select---</option>
                                            @foreach($allCity as $city)
                                                <option value="{{$city->id}}">{{ $city->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class=" red">{{ $errors->first('business_city') }}</strong>
                                </div>
                            </div>

                            {{-- Postcode --}}
                            <div class="col form-group">
                                <label class=" " for="business_postcode">Postcode <sup class="red">*</sup></label>
                                <div class="">
                                    <div class="text-center">
                                        <select
                                            class="form-control"

                                            id="getPostcodeByCityForBusinessAddress"
                                            name="business_postcode"
                                        >
                                            <option value="-1">---select---</option>
                                            @foreach($allArea as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <strong class=" red">{{ $errors->first('business_postcode') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h3>Return Address</h3>

                    <div class="" style="margin-bottom: 20px">
                        <p style="float: left;margin-right: 10%;"> Same as Warehouse Address</p> <input type="checkbox"
                                                                                                        id="return_id"
                                                                                                        checked="">
                    </div>
                    <div id="return_class">

                        <div class="row">
                            <!-- Address -->
                            <div class="col form-group">
                                <label class="" for="return_address">Address <sup class="red">*</sup></label>

                                <div class="">
                                    <input type="text"
                                           id="return_address"
                                           placeholder=" - address -"
                                           class="form-control input-sm"
                                           name="return_address"

                                           value="{{($sellerId && $returnAddress) ? $returnAddress->return_address : ''}}">
                                    <strong class=" red">{{ $errors->first('return_address') }}</strong>
                                </div>
                            </div>

                            <!-- division -->
                            <div class="col form-group">
                                <label class="" for="return_division">Division<sup class="red">*</sup></label>

                                <div class="">
                                    <div class="text-center">
                                        <select class="form-control"

                                                id="divisionIdForReturnAddress"
                                                name="return_division"
                                                data-placeholder="- division -">
                                            <option value="-1">---select---</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <strong class=" red">{{ $errors->first('return_division') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!--city -->
                            <div class="col form-group">
                                <label class="" for="return_city">City <sup class="red">*</sup></label>

                                <div class="">
                                    <div class="text-center">
                                        <select
                                            class="form-control"

                                            id="getCityByDivisionForReturnAddress"
                                            name="return_city"
                                            data-placeholder="- City -"
                                        >
                                            option value="-1">---select---</option>
                                            @foreach($allCity as $city)
                                                <option value="{{$city->id}}">{{ $city->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class=" red">{{ $errors->first('return_city') }}</strong>
                                </div>
                            </div>

                            <div class="col form-group">
                                <label class="" for="return_postcode">Postcode <sup class="red">*</sup></label>
                                <div class="">
                                    <div class="text-center">
                                        <select
                                            class="form-control"

                                            id="getPostcodeByCityForReturnAddress"
                                            name="return_postcode"
                                        >
                                            <option value="-1">---select---</option>
                                            @foreach($allArea as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <strong class=" red">{{ $errors->first('return_postcode') }}</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row padding">
                        <label class="col-md-9">

                        </label>
                        <div class="col-md-3">
                            <button type="submit" name="btn" class="btn btn-primary btn-lg float-right">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="col-sm-9 col-md-6 col-lg-5" class="">
            <div class="card">
                <div class="card-header-primary">
                    <p>Logo && Highlighted Product</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('seller.profile.update.image', $seller->id ?? 0) }}" method="POST"
                          enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            <div class="row m-2">
                                {{-- ---seller-logo-----}}
                                <div class="col form-group">
                                    <label class="text-dark font-weight-bold" for="sellerLogo"><i
                                            class="material-icons">backup</i> Seller Logo &nbsp;<sub class="text-danger">*</sub></label>
                                    <input type="file" id="sellerLogo" class="form-control-file" name="seller_logo"
                                           accept="image/*" >

                                </div>
                                <div class="col form-group">
                                    <label class="text-dark font-weight-bold" for="product_image"><i class="material-icons">backup</i>
                                        Highlight Product Image &nbsp;<sub class="text-danger">*</sub></label>
                                    <input type="file" id="product_image" name="product_image"
                                           accept="image/*" >

                                </div>
                            </div>
                        </div>
                        @if(!empty( $id))
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <img src="{{ asset($seller->seller_logo??' ') }}" alt="{{ ($seller->seller_logo) }}"
                                         width="100%" height="200px">

                                </div>
                                <div class="col text-center">
                                    <img src="{{ asset($seller->product_image??' ') }}"
                                         alt="{{ ($seller->product_image) }}" width="100%" height="200px">

                                </div>
                            </div>
                        @endif
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-sm btn-warning">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript">

        $(document).ready(function () {

            // business_check
            if ($("#business_check").is(':checked')) {
                $("#business_class").hide();
            }

            $("#business_check").click(function () {
                if ($(this).is(":checked")) {
                    $("#business_class").hide();
                } else {
                    $("#business_class").show();
                }
            });

            // Return Address return_id
            if ($("#return_id").is(':checked')) {
                $("#return_class").hide();
            }

            $("#return_id").click(function () {
                if ($(this).is(":checked")) {
                    $("#return_class").hide();
                } else {
                    $("#return_class").show();
                }
            });

        });

        jQuery(function ($) {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                //resize the chosen on window resize
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({'width': '100%'});
                        // $this.next().css({'width': $this.parent().width()});
                    })
                }).trigger('resize.chosen');
            }


        });


    </script>

    {{--    //city-dropDown [arman]--}}
    <script>
        $(document).ready(function () {
            $('#divisionId').change(function () {
                var divisionId = $(this).val();
                var jsonData = {divisionId: divisionId};
                $.ajax({
                    url: 'division/getCityByDivision/' + divisionId,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#getCityByDivision").empty();
                        $("#getCityByDivision").append('<Option value="' + -1 + '">' + "--select--" + '</Option>');
                        $.each(data, function (key, value) {
                            $("#getCityByDivision").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#getCityByDivision').change(function () {
                var cityId = $(this).val();
                var jsonData = {cityId: cityId};
                $.ajax({
                    url: 'cities/getPostCodeBycity/' + cityId,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#getPostcodeByCity").empty();
                        $("#getPostcodeByCity").append('<Option value="' + -1 + '">' + "--select--" + '</Option>');
                        $.each(data, function (key, value) {
                            $("#getPostcodeByCity").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    {{--    business address --}}
    <script>
        $(document).ready(function () {
            $('#divisionIdForBusiness').change(function () {
                var divisionId = $(this).val();
                var jsonData = {divisionId: divisionId};
                $.ajax({
                    url: 'division/getCityByDivisionForBusiness/' + divisionId,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#getCityByDivisionForBusinessAddress").empty();
                        $("#getCityByDivisionForBusinessAddress").append('<Option value="' + -1 + '">' + "--select--" + '</Option>');
                        $.each(data, function (key, value) {
                            $("#getCityByDivisionForBusinessAddress").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#getCityByDivisionForBusinessAddress').change(function () {
                var cityId = $(this).val();
                var jsonData = {cityId: cityId};
                $.ajax({
                    url: 'cities/getPostCodeByCitiesForBusinessAddress/' + cityId,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#getPostcodeByCityForBusinessAddress").empty();
                        $("#getPostcodeByCityForBusinessAddress").append('<Option value="' + -1 + '">' + "--select--" + '</Option>');
                        $.each(data, function (key, value) {
                            $("#getPostcodeByCityForBusinessAddress").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    {{--    Return address--}}
    <script>
        $(document).ready(function () {
            $('#divisionIdForReturnAddress').change(function () {
                var divisionId = $(this).val();
                var jsonData = {divisionId: divisionId};
                $.ajax({
                    url: 'division/getCityByDivisionForReturnAddress/' + divisionId,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#getCityByDivisionForReturnAddress").empty();
                        $("#getCityByDivisionForReturnAddress").append('<Option value="' + -1 + '">' + "--select--" + '</Option>');
                        $.each(data, function (key, value) {
                            $("#getCityByDivisionForReturnAddress").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#getCityByDivisionForReturnAddress').change(function () {
                var cityId = $(this).val();
                var jsonData = {cityId: cityId};
                $.ajax({
                    url: 'cities/getPostcodeByCityForReturnAddress/' + cityId,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        $("#getPostcodeByCityForReturnAddress").empty();
                        $("#getPostcodeByCityForReturnAddress").append('<Option value="' + -1 + '">' + "--select--" + '</Option>');
                        $.each(data, function (key, value) {
                            $("#getPostcodeByCityForReturnAddress").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>

    {{--    select insert value in selector --}}
    <script>
        $(document).ready(function () {

            $('#divisionId').val('{{ $id ? $seller->division : -1 }}');

            $("#getCityByDivision").val('{{ $id ? $seller->city : ' ' }}');

            $("#getPostcodeByCity").val('{{ $id ? $seller->postcode : ' ' }}');


            // for business address
            $("#divisionIdForBusiness").val('{{ $id ? $businessAddress->business_division : -1 }}');
            $("#getCityByDivisionForBusinessAddress").val('{{ $id ? $businessAddress->business_city : '' }}');
            $("#getPostcodeByCityForBusinessAddress").val('{{ $id ? $businessAddress->business_postcode : '' }}');

            //for Return address

            $('#divisionIdForReturnAddress').val('{{ $id ? $returnAddress->return_division : -1 }}');
            $('#getCityByDivisionForReturnAddress').val('{{ $id ? $returnAddress->return_city : '' }}');
            $('#getPostcodeByCityForReturnAddress').val('{{ $id ? $returnAddress->return_postcode : ''}}');


        });
    </script>

@endpush

