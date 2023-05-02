@extends('backend.layouts.master')
@section('title','Seller Profile')
@section('page-header')
    <i class="ace-icon glyphicon glyphicon-user"></i> Seller Profile
@stop

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Seller Profile',
       'route' => route('seller.profile.index')
    ])

    <div class="col-sm-9">
        <form class="form-horizontal"
              method="post"
              action="{{route('backend.seller.update',$seller->id)}}"
              role="form"
              enctype="multipart/form-data">
        @csrf

        <!-- Name -->
            <div class="form-group">
                <label class="col-sm-3 " for="proprietor_name">Proprietor name <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="proprietor_name"
                           placeholder=" - Proprietor_name -"
                           class="form-control input-sm"
                           name="proprietor_name"
                           required
                           value="{{ $seller->proprietor_name?? ''}}"
                    >
                    {{--    <strong class=" red">{{ $errors->first('proprietor_name') }}</strong>--}}
                </div>
            </div>

            {{-- Company Registration number --}}

            <div class="form-group">
                <label class="col-sm-3" for="registration_number">Company Registration number <sup
                        class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="registration_number"
                           placeholder=" - Registration Number -"
                           class="form-control input-sm"
                           name="registration_number"
                           required
                           value="{{ $seller->registration_number??' '}}"
                    >
                    <strong class=" red">{{ $errors->first('registration_number') }}</strong>
                </div>
            </div>

            {{-- Corporate address --}}
            <div class="form-group">
                <label class="col-sm-3 " for="crporate_address">Corporate Address <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="crporate_address"
                           placeholder=" - Corporate Address -"
                           class="form-control input-sm"
                           name="crporate_address"
                           required
                           value="{{ $seller->crporate_address?? ''}}"
                    >
                    <strong class=" red">{{ $errors->first('crporate_address') }}</strong>
                </div>
            </div>

            {{-- Vat Registration number --}}
            <div class="form-group">
                <label class="col-sm-3 " for="vat_registration_number">Vat Registration number <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="vat_registration_number"
                           placeholder=" - Vat Registration number -"
                           class="form-control input-sm"
                           name="vat_registration_number"
                           required
                           value="{{ $seller->vat_registration_number??  ''}}"
                    >
                    <strong class=" red">{{ $errors->first('vat_registration_number') }}</strong>
                </div>
            </div>


            {{-- owners NID numberr --}}
            <div class="form-group">
                <label class="col-sm-3 " for="nid_number">Owners NID number <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="nid_number"
                           placeholder=" - NID number -"
                           class="form-control input-sm"
                           name="nid_number"
                           required
                           value="{{ $seller->nid_number?? ''}}"
                    >
                    <strong class=" red">{{ $errors->first('nid_number') }}</strong>
                </div>
            </div>

            {{-- Trade licenses --}}
            <div class="form-group">
                <label class="col-sm-3 " for="nid_number">Trade licenses <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="nid_number"
                           placeholder=" - Trade licenses -"
                           class="form-control input-sm"
                           name="trade_licenses"
                           required
                           value="{{ $seller->trade_licenses?? ''}}"
                    >
                    <strong class=" red">{{ $errors->first('trade_licenses') }}</strong>
                </div>
            </div>

            {{-- 8. Main Business --}}
            <div class="form-group">
                <label class="col-sm-3 " for="nid_number">Main Business <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="nid_number"
                           placeholder=" - Trade licenses -"
                           class="form-control input-sm"
                           name="main_business"
                           required
                           value="{{ $seller->main_business?? ''}}"
                    >
                    <strong class=" red">{{ $errors->first('main_business') }}</strong>
                </div>
            </div>

            {{-- Product Category --}}

            <div class="form-group">
                <label class="col-sm-3 " for="nid_number">Product Category<sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text" name="product_category" class="form-control"
                           value="{{ $seller->product_category??  ''}}"
                           required>
                    <strong class=" red">{{ $errors->first('product_category') }}</strong>
                </div>
            </div>

            {{-- company corporate number --}}
            <div class="form-group">
                <label class="col-sm-3 " for="name">company corporate number <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="name"
                           placeholder=" - corporate number -"
                           class="form-control input-sm"
                           name="corporate_number"
                           value="{{ $seller->corporate_number??  ''}}"
                           required
                    >
                    <strong class=" red">{{ $errors->first('corporate_number') }}</strong>
                </div>
            </div>

            {{-- 13. main contact person: number --}}
            <div class="form-group">
                <label class="col-sm-3 " for="name">Main contact person: number <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <input type="text"
                           id="name"
                           placeholder=" - number -"
                           class="form-control input-sm"
                           name="address"
                           value="{{ $seller->address?? ''}}"
                           required
                    >
                    <strong class=" red">{{ $errors->first('corporate_number') }}</strong>
                </div>
            </div>
            {{-- 14. site location contact person and cellphone number --}}

            <div class="form-group">
                <label class="col-sm-3 " for="name"> Site location contact person and cellphone number <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <textarea id="form-field-11" name="location_details" class="autosize-transition form-control"
                              style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 52px;">{{ $seller->location_details?? ''}}</textarea>
                </div>
            </div>

            {{-- ---seller-logo-----}}
            <div class="form-group">
                <label class="col-sm-3" for="sellerLogo">Seller Logo<sub class="red">*</sub></label>
                <div class="col-sm-8">
                    <input type="file" id="sellerLogo" name="seller_logo" accept="image/*"
                        {{-- {{ ($sellerId && $businessAddress)??required }} --}}
                    >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="product_image">Highlight Product Image<sub class="red">*</sub></label>
                <div class="col-sm-8">
                    <input type="file" id="product_image" name="product_image" accept="image/*"
                        {{-- {{ ($sellerId && $businessAddress)??required }} --}}
                    >
                </div>
            </div>

            <!-- division -->
            <div class="form-group">
                <label class="col-sm-3" for="division">Division<sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <div class="text-center">
                        <select class="form-control"

                                id="divisionId"
                                name="division"
                                data-placeholder="- division -">
                            <option value="-1">---select---</option>
                            @foreach($divisions as $division)
                                <option
                                    value="{{ $division->id }}"{{ $seller->division  == $division->id ? 'selected' : ' ' }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <!--city -->
            <div class="form-group">
                <label class="col-sm-3" for="city">City <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <div class="text-center">
                        <select
                            class="form-control"
                            id="getCityByDivision"
                            name="city"
                            data-placeholder="- City -"
                        >
                            <option value="-1">---select---</option>
                            @foreach($cities as $key=>$city)
                                <option
                                    value="{{$city->id}}"{{ $seller->city == $city->id ? 'selected' : ' ' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- Postcode --}}

            <div class="form-group">
                <label class="col-sm-3 " for="postcode">Postcode <sup class="red">*</sup></label>

                <div class="col-sm-8">
                    <div class="text-center">
                        <select
                            class="form-control"

                            id="getPostcodeByCity"
                            name="postcode"
                            data-placeholder="- postcode -">
                            <option value="-1">---select---</option>
                            @foreach($allArea as $area)
                                <option
                                    value="{{ $area->id }}"{{ $seller->postcode == $area->id ? 'selected' : ' ' }}>{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <h3>Business Address</h3>

            <div class="" style="margin-bottom: 20px">
                <p style="float: left;margin-right: 10%;"> Same as Warehouse Address</p> <input type="checkbox"
                                                                                                id="business_check">
            </div>
            <div id="business_class">
                <!-- Address -->
                <div class="form-group">
                    <label class="col-sm-3 " for="name">Address <sup class="red">*</sup></label>

                    <div class="col-sm-8">
                        <input type="text"
                               id="business_address"
                               placeholder=" - address -"
                               class="form-control input-sm"
                               name="business_address"
                               required
                               value="{{ $businessAddress->business_address?? ''}}">
                        <strong class=" red">{{ $errors->first('business_address') }}</strong>
                    </div>
                </div>

                <!-- division -->
                <div class="form-group">
                    <label class="col-sm-3" for="division">Division<sup class="red">*</sup></label>

                    <div class="col-sm-8">
                        <div class="text-center">
                            <select class="form-control"

                                    id="divisionIdForBusiness"
                                    name="business_division"
                                    data-placeholder="- division -">
                                <option value="-1">---select---</option>
                                @foreach($divisions as $business_div)
                                    <option
                                        value="{{ $business_div->id }}"{{ $businessAddress->business_division == $business_div->id ? 'selected': '' }}>{{ $business_div->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <!--city -->
                <div class="form-group">
                    <label class="col-sm-3" for="city">City <sup class="red">*</sup></label>

                    <div class="col-sm-8">
                        <div class="text-center">
                            <select
                                class="form-control"

                                id="getCityByDivisionForBusinessAddress"
                                name="business_city"
                                data-placeholder="- City -"
                            >
                                <option value="-1">---select---</option>
                                @foreach($cities as $city)
                                    <option
                                        value="{{$city->id}}"{{ $businessAddress->business_city == $city->id? 'selected': '' }}>{{ $city->name }}</option>

                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

                {{-- Postcode --}}
                <div class="form-group">
                    <label class="col-sm-3 " for="postcode">Postcode <sup class="red">*</sup></label>
                    <div class="col-sm-8">
                        <div class="text-center">
                            <select
                                class="form-control"

                                id="getPostcodeByCityForBusinessAddress"
                                name="business_postcode"
                            >
                                <option value="-1">---select---</option>
                                @foreach($allArea as $area)
                                    <option value="{{ $area->id }}"
                                    <option value="{{$city->id}}"
                                        {{ $businessAddress->business_postcode == $area->id? 'selected': '' }}>{{ $area->name }}</option>
                                    >{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <hr>

            <h3>Return Address</h3>

            <div class="" style="margin-bottom: 20px">
                <p style="float: left;margin-right: 10%;"> Same as Warehouse Address</p> <input type="checkbox"
                                                                                                id="return_check">
            </div>
            <div id="return_class">
                <!-- Address -->
                <div class="form-group">
                    <label class="col-sm-3 " for="name">Address <sup class="red">*</sup></label>

                    <div class="col-sm-8">
                        <input type="text"
                               id="return_address"
                               placeholder=" - address -"
                               class="form-control input-sm"
                               name="return_address"
                               required
                               value="{{ $returnAddress->return_address?? ''}}">
                        <strong class=" red">{{ $errors->first('return_address') }}</strong>
                    </div>
                </div>

                <!-- division -->
                <div class="form-group">
                    <label class="col-sm-3" for="division">Division<sup class="red">*</sup></label>

                    <div class="col-sm-8">
                        <div class="text-center">
                            <select class="form-control"

                                    id="divisionIdForReturnAddress"
                                    name="return_division"
                                    data-placeholder="- division -">
                                <option value="-1">---select---</option>
                                @foreach($divisions as $r_division)

                                    <option value="{{ $r_division->id }}"
                                        {{ $r_division->id ===  (int)$returnAddress->return_division ? 'selected' : ''}}
                                    >
                                        {{ $r_division->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>


                <!--city -->
                <div class="form-group">
                    <label class="col-sm-3" for="city">City <sup class="red">*</sup></label>

                    <div class="col-sm-8">
                        <div class="text-center">
                            <select
                                class="form-control"

                                id="getCityByDivisionForReturnAddress"
                                name="return_city"
                                data-placeholder="- City -">
                                <option value="-1">---select---</option>
                                @foreach($cities as $r_city)
                                    <option
                                        value="{{$city->id}}"{{ $returnAddress->return_city == $r_city->id ? 'selected' : ''}}>{{ $r_city->name }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 " for="postcode">Postcode <sup class="red">*</sup></label>
                    <div class="col-sm-8">
                        <div class="text-center">
                            <select
                                class="form-control"

                                id="getPostcodeByCityForReturnAddress"
                                name="return_postcode"
                            >
                                <option value="-1">---select---</option>
                                @foreach($allArea as $r_area)
                                    <option
                                        value="{{ $r_area->id }}"{{ (int)$returnAddress->return_postcode === $r_area->id ? 'selected' : '' }}>{{ $r_area->name }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row padding">
                <label class="col-md-9">

                </label>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-md btn-warning">update</button>
                </div>
            </div>

        </form>

    </div>
    <div class="col-sm-3" style="margin-top: 40px;border:1px solid gray" class="">
        <p>Seler Logo && Highlight Product Image</p>
        <hr>
        @if(!empty( $id))
            <img src="{{ asset($seller->seller_logo??' ') }}" alt="{{ ($seller->seller_logo) }}"
                 style="width:50px;height:50px">
            <img src="{{ asset($seller->product_image??' ') }}" alt="{{ ($seller->product_image) }}"
                 style="width:50px;height:50px">
        @endif
    </div>

@endsection

@push('js')
    <script type="text/javascript">
        let division = null;
        let city = null;
        let post_code = null;
        let corporate_address = null;

        let business_check = null;
        let business_class = null;
        let business_division = null;
        let business_city = null;
        let business_post_code = null;
        let business_address = null;

        let return_check = null;
        let return_class = null;
        let return_division = null;
        let return_city = null;
        let return_post_code = null;
        let return_address = null;

        $(document).ready(function () {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({'width': '100%'});
                    })
                }).trigger('resize.chosen');
            }

            // original
            division = $('#divisionId');
            city = $('#getCityByDivision');
            post_code = $('#getPostcodeByCity')
            corporate_address = $('#crporate_address');

            // business
            business_check = $("#business_check");
            business_class = $("#business_class");
            business_division = $('#divisionIdForBusiness');
            business_city = $('#getCityByDivisionForBusinessAddress');
            business_post_code = $('#getPostcodeByCityForBusinessAddress');
            business_address = $('#business_address');

            // return
            return_check = $("#return_check");
            return_class = $("#return_class");
            return_division = $('#divisionIdForReturnAddress');
            return_city = $('#getCityByDivisionForReturnAddress');
            return_post_code = $('#getPostcodeByCityForReturnAddress');
            return_address = $('#return_address');

            business_check.click(function () {
                if ($(this).is(":checked")) {
                    business_division.empty();
                    business_city.empty();
                    business_post_code.empty();

                    $('#divisionId option').clone().appendTo('#divisionIdForBusiness');
                    $('#getCityByDivision option').clone().appendTo('#getCityByDivisionForBusinessAddress');
                    $('#getPostcodeByCity option').clone().appendTo('#getPostcodeByCityForBusinessAddress');

                    business_address.val(corporate_address.val());
                    business_division.val(division.val()).change();
                    business_city.val(city.val()).change();
                    business_post_code.val(post_code.val()).change();
                    business_class.hide();
                } else {
                    business_class.show();
                }
            });

            return_check.click(function () {
                if ($(this).is(":checked")) {
                    return_city.empty();
                    return_post_code.empty();

                    $('#divisionId option').clone().appendTo('#divisionIdForReturnAddress');
                    $('#getCityByDivision option').clone().appendTo('#getCityByDivisionForReturnAddress');
                    $('#getPostcodeByCity option').clone().appendTo('#getPostcodeByCityForReturnAddress');

                    return_address.val(corporate_address.val());
                    return_division.val(division.val()).change();
                    return_city.val(city.val()).change();
                    return_post_code.val(post_code.val()).change();
                    return_class.hide();
                } else {
                    return_class.show();
                }
            });

            {{-- Division [joy]--}}
            division.change(function () {
                let divId = $(this).val();
                let url = "{{ route('postCode.getCity', ":divId") }}";
                url = url.replace(':divId', divId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        city.empty();
                        city.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        post_code.empty();
                        post_code.append('<Option value="' + -1 + '">' + "--select-- " + '</Option>')

                        $.each(data, function (key, value) {
                            city.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });

            {{-- City  --}}
            city.change(function () {
                let cityId = $(this).val();
                let url = "{{ route('located.area', ":cityId") }}";
                url = url.replace(':cityId', cityId);

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        post_code.empty();
                        post_code.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        $.each(data, function (key, value) {
                            post_code.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });

            {{--    business address --}}
            business_division.change(function () {
                if (business_check.prop('checked')) {
                    return 0;
                }

                let divId = $(this).val();
                let url = "{{ route('postCode.getCity', ":divId") }}";
                url = url.replace(':divId', divId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        business_city.empty();
                        business_city.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        business_post_code.empty();
                        business_post_code.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        $.each(data, function (key, value) {
                            business_city.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });

            business_city.change(function () {
                if (business_check.prop('checked')) {
                    return 0;
                }

                let cityId = $(this).val();
                let url = "{{ route('located.area', ":cityId") }}";
                url = url.replace(':cityId', cityId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        business_post_code.empty();
                        business_post_code.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        $.each(data, function (key, value) {
                            business_post_code.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });

            {{--    Return address--}}
            return_division.change(function () {
                if (return_check.prop('checked')) {
                    return 0;
                }

                let divId = $(this).val();
                let url = "{{ route('postCode.getCity', ":divId") }}";
                url = url.replace(':divId', divId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        return_city.empty();
                        return_city.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        return_post_code.empty();
                        return_post_code.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        $.each(data, function (key, value) {
                            return_city.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });

            return_city.change(function () {
                if (return_check.prop('checked')) {
                    return 0;
                }

                let cityId = $(this).val();
                let url = "{{ route('located.area', ":cityId") }}";
                url = url.replace(':cityId', cityId);
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: 'jsonData',
                    dataType: 'JSON',
                    success: function (data) {
                        return_post_code.empty();
                        return_post_code.append('<Option value="' + -1 + '">' + "--select--" + '</Option>');

                        $.each(data, function (key, value) {
                            return_post_code.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function (e) {
                        console.log(e);
                    },
                });
            });
        });
    </script>

@endpush

