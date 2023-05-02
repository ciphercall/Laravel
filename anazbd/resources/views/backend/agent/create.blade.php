{{--  @extends('backend.layouts.master')  --}}
@extends('admin.layout.master')
@section('title','Agent Profile')
@section('page-header')
    <i class="ace-icon glyphicon glyphicon-user"></i> Agent Profile
@stop

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Seller Profile',
       'route' => route('backend.product.child_categories.index')
    ])  --}}

    <div class="row">
        <div class="col-9">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Delivery Agents</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.agent.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list">&nbsp; Agents</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal"
                    method="post"
                    action="{{route('backend.agent.store')}}"
                    role="form"
                    enctype="multipart/form-data">
                  @csrf
      
                  <!-- type -->
                   <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                          Account Type <span class="red">*</span>
                      </label>
      
                      <div class="col-sm-9">
                          <div class="control-group">
                              <div class="row" id="inline_content">
      
                                  <div class="col-md-6">
                                      <div class="radio">
                                          <label>
                                              <input type="radio"
                                                     required
                                                     class="ace"
                                                     name="type"
                                                     checked
                                                     value="personal">
      
                                              <span class="lbl">Personal</span>
                                          </label>
                                      </div>
                                  </div>
      
                                  <div class="col-md-6">
                                      <div class="radio">
                                          <label>
                                              <input type="radio"
                                                     required
                                                     name="type"
                                                     class="ace"
                                                     value="business">
                                              <span class="lbl">Business</span>
                                          </label>
                                      </div>
                                  </div>
      
                                  <span class="red">{{ $errors->first('type')}}</span>
                              </div>
                          </div>
                      </div>
                  </div>
      
      
                   <!-- Name -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="name">Name <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input type="text"
                                 id="name"
                                 placeholder=" - Your name -"
                                 class="form-control input-sm"
                                 name="name"
                                 value="{{ old('name') }}"
                          >
                          <strong class=" red">{{ $errors->first('name') }}</strong>
                      </div>
                  </div>
      
                   <!-- contact name -->
                   <div class="form-group" id="contact_person" style="display: none">
                      <label class="col-sm-3 control-label no-padding-right" for="name">Contact Person <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input type="text"
                                 id="name"
                                 placeholder=" - Contact Person -"
                                 class="form-control input-sm"
                                 name="contact_person"
                                 value="{{ old('name') }}"
                          >
                          <strong class=" red">{{ $errors->first('contact_person') }}</strong>
                      </div>
                  </div>
      
      
                  <!-- mobile -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="Mobile"> Mobile<sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input  type="text"
                                  id="Mobile"
                                  placeholder=" - 0170510000 -"
                                  class="form-control input-sm"
                                  name="mobile"
                                  required
                                 value="{{ old('mobile') }}"
                          >
                         <strong class=" red">{{ $errors->first('mobile') }}</strong>
                      </div>
                  </div>
      
                  <!-- email -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="Email"> Email </label>
      
                      <div class="col-sm-8">
                          <input  type="text"
                                  id="Email"
                                  placeholder=" - email@gmil.com -"
                                  class="form-control input-sm"
                                  name="email"
                                  required
                                  value="{{ old('email') }}"
                          >
                         <strong class=" red">{{ $errors->first('email') }}</strong>
                      </div>
                  </div>
                  <!-- password -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="password"> Password </label>
      
                      <div class="col-sm-8">
                          <input  type="password"
                                  id="v"
                                  placeholder=" - xxxxxxx -"
                                  class="form-control input-sm"
                                  name="password"
                                  required
                                  value="{{ old('password') }}"
                          >
                         <strong class=" red">{{ $errors->first('password') }}</strong>
                      </div>
                  </div>
      
                   {{-- owners NID numberr --}}
                   <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="nid_number">NID Number <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input  type="text"
                                  id="nid_number"
                                  placeholder=" - NID Number(1260-235-2323..) -"
                                  class="form-control input-sm"
                                  name="nid_number"
                                  required
                                  value="{{ old('nid_number')}}"
                          >
                      <strong class=" red">{{ $errors->first('nid_number') }}</strong>
                      </div>
                  </div>
      
                  {{-- bank name --}}
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="bankaccountnumber">Bank Name <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input  type="text"
                                  id="bankaccountnumber"
                                  placeholder=" - Bank Name -"
                                  class="form-control input-sm"
                                  name="bank_name"
                                  required
                                  value=""
                          >
                          <strong class=" red">{{ $errors->first('bank_name') }}</strong>
                      </div>
                  </div>
      
                  {{-- bankaccountnumber --}}
      
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="bankaccountnumber">Bank Acc. No <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input  type="text"
                                  id="bankaccountnumber"
                                  placeholder=" - Bank Acc. No(000-000-000..) -"
                                  class="form-control input-sm"
                                  name="bankaccountnumber"
                                  required
                                 value=""
                          >
                          <strong class=" red">{{ $errors->first('bankaccountnumber') }}</strong>
                      </div>
                  </div>
      
      
                  {{-- Bikash No --}}
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="crporate_address">Bikash No. <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <input type="text"
                                  id="crporate_address"
                                  placeholder=" - Bikash No(01710000000) -"
                                  class="form-control input-sm"
                                  name="bikashnumber"
                                  required
                                  value=""
                          >
                         <strong class=" red">{{ $errors->first('bikashnumber') }}</strong>
                      </div>
                  </div>
      
                  {{--logo-----}}
      
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="sellerLogo">Agent Logo/photo<sub class="red">*</sub></label>
                      <div class="col-sm-8">
                          <input type="file" id="sellerLogo"  name="logo" accept="image/*" onchange="readURL(this);">
                      </div>
                  </div>
      
                  {{-- address --}}
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="address">Full Address<sub class="red">*</sub></label>
                      <div class="col-sm-8">
                          <textarea name="address" id="address" cols="78" rows="5" placeholder="Your full address.." required></textarea>
                      </div>
                  </div>
      
                  <div class="form-group" id="education" style="">
                      <label class="col-sm-3 control-label no-padding-right" for="crporate_address">Education <sup class="red">*</sup></label>
                      <div class="col-sm-8">
                          <select class="form-control" id="form-field-select-1" name="education">
                              <option value="">-Select Education Level-</option>
                              <option value="SSC">SSC</option>
                              <option value="HSC">HSC</option>
                          </select>
                      </div>
                  </div>
      
                  <p><i class="menu-icon fa fa-area-chart"></i> Allocated Area</p>
                  <hr>
                  <!-- division -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="division">Division <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <div class="text-center">
                              <select class="form-control"
                                         required
                                      id="divisionId"
                                      name="adiv_id"
                                      data-placeholder="- division -">
                                  <option value="-1">---select---</option>
                                  @foreach($divisions as $division)
                                      <option value="{{ $division->id }}">{{ $division->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <strong class=" red">{{ $errors->first('adiv_id') }}</strong>
                      </div>
                  </div>
      
                  <!--city -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="getCityById">City Name <sup class="red">*</sup></label>
                      <div class="col-sm-8">
                          <select class="form-control input-sm" name="acity_id" id="getCityById">
      
                          </select>
                          <strong class="red">{{ $errors->first('acity_id') }}</strong>
                      </div>
                  </div>
      
                  <div class="form-group">
                      <div class="col-sm-3 control-label no-padding-right">
                          <span class="bigger-110"> Area</span>
                      </div>
                      <div class="col-sm-8">
                          <select multiple=""  name='aarea_id[]'class="chosen-select form-control extend" id="form-field-select-4" data-placeholder=" -- Alocated Area -- ">
      
                          </select>
                      </div>
                  </div>
      
                  <p><i class="menu-icon fa fa-area-chart"></i>Extend Area</p>
                  <hr>
      
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="division">Division <sup class="red">*</sup></label>
      
                      <div class="col-sm-8">
                          <div class="text-center">
                              <select class="form-control"
                                         required
                                      id="extenddivisionId"
                                      name="exdiv_id"
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
                  <div class="form-group">
                      <label class="col-sm-3 control-label no-padding-right" for="extendCityById">City Name <sup class="red">*</sup></label>
                      <div class="col-sm-8">
                          <select class="form-control input-sm" name="excity_id" id="extendCityById">
      
                          </select>
                          <strong class="red">{{ $errors->first('city_id') }}</strong>
                      </div>
                  </div>
      
                  <div class="form-group">
                      <div class="col-sm-3 control-label no-padding-right">
                          <span class="bigger-110"> Area</span>
                      </div>
                      <div class="col-sm-8">
                          <select multiple="" name="exarea_id[]" class="chosen-select form-control extendarea" id="form-field-select-4" data-placeholder=" -- Extend Area-- ">
      
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-5">
                          <button class="btn btn-sm btn-success submit create-button"><i class="fa fa-save"></i> Add
                          </button>
                          <a href="{{route('backend.admin.index')}}" class="btn btn-sm btn-gray"> <i
                                  class="fa fa-refresh"></i>
                              Cancel</a>
                      </div>
                  </div>
      
              </form>
                </div>
                
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header-primary">
                    <h4 class="widget-title">Current Image</h4>
                </div>
                <div class="card-body"
                     style="display:flex; align-items: center; justify-content: center; height:100px;">
                    <div class="widget-main">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <img id="current" src="" width="150" height="150" class="img-responsive center-block"
                                     alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">

        function chosen_trigger() {
                    if (!ace.vars['touch']) {
                        $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                        $(window).on('resize.chosen', function () {
                            $('.chosen-select').each(function () {
                                let $this = $(this);
                                $this.next().css({'width': '100%'});
                                // $this.next().css({'width': $this.parent().width()});
                            })
                        }).trigger('resize.chosen');
                    } else {
                        $('.chosen-select').css('width', '100%');
                    }
                }

        //Joy//


        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#current')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#inline_content input[name='type']").click(function(){
            if($('input:radio[name=type]:checked').val() == "personal"){

                $("#education").css('display','unset');
                $("#contact_person").hide();
            }else if ($('input:radio[name=type]:checked').val() == "business") {
                $("#contact_person").removeAttr("style");
                $("#education").css('display','none');
            }
        });


        //city-dropDown [joy]

        $(document).ready(function(){

        chosen_trigger();

            $('#divisionId').change(function(){
                let divId   = $(this).val();
                // $('#extenddivisionId option').attr('disabled',false);
                // $('#extenddivisionId option[value='+divId+']').attr('disabled',true);
                // $('#extenddivisionId option[value='+divId+']').css('background','gray');
                var url     = "{{ route('postCode.getCity', ":divId") }}";
                url         = url.replace(':divId', divId) ;
                $.ajax ({
                    url     : url,
                    method  : 'GET',
                    dataType: 'json',
                    success :function(data){
                        $("#getCityById").empty();
                        // $(".alocatedarea").empty();
                        $('#getCityById').append('<Option value="' + 0 + '">'+ " -- select city -- " + '</option>');
                        $.each(data, function(key, value){
                            $('#getCityById').append('<option value="' + value.id +'">' + value.name +'</option>');
                        });
                    },
                    error:function(e){
                        console.log(e);
                    },
                });
            });
            //alocated-dropDown [joy]

            $('#getCityById').change(function(){
                let cityId  = $(this).val();
                let url     = "{{ route('located.area', ":cityId") }}";
                url         = url.replace(':cityId', cityId);

                $.ajax({
                    url     : url,
                    method  :'GET',
                    dataType:'Json',
                    success:function(data){
                        $('#form-field-select-4').empty();
                        $('#form-field-select-4').append('<option value=" '+ 0 +' ">'+"-- select alocated area -- "+'</option>');
                        $.each(data, function(key, value){
                            $('#form-field-select-4').append('<option selected value=" '+ value.id +' ">'+ value.name +'</option>');
                        });
                        $('#form-field-select-4').trigger("chosen:updated");
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            });


            // extend divison
            $('#extenddivisionId').change(function(){
                let divId   = $(this).val();
                var url     = "{{ route('postCode.getCity', ":divId") }}";
                url         = url.replace(':divId', divId) ;
                $.ajax ({
                    url     : url,
                    method  : 'GET',
                    dataType: 'json',
                    success :function(data){
                        $("#extendCityById").empty();
                        $('#extendCityById').append('<Option value="' + 0 + '">'+ " -- select city -- " + '</option>');
                        $.each(data, function(key, value){
                            $('#extendCityById').append('<option value="' + value.id +'">' + value.name +'</option>');
                        });
                    },
                    error:function(e){
                        console.log(e);
                    },
                });
            });

            // extend city and area
            $('#extendCityById').change(function(){
                let cityId  = $(this).val();
                let url     = "{{ route('located.area', ":cityId") }}";
                url         = url.replace(':cityId', cityId);

                $.ajax({
                    url     : url,
                    method  :'GET',
                    dataType:'Json',
                    success:function(data){
                        $('.extendarea').empty();
                        $('.extendarea').append('<option value=" '+ 0 +' ">'+"-- select alocated area -- "+'</option>');
                        $.each(data, function(key, value){
                            $('.extendarea').append('<option selected value=" '+ value.id +' ">'+ value.name +'</option>');
                        });
                        $('.extendarea').trigger("chosen:updated");
                    },
                    error:function(error){
                        console.log(error)
                    }
                });
            });
        });
    </script>
@endpush

