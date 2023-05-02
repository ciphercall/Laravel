@extends('admin.layout.master')
@section('title','Create New Coupon')
@section('page_header')
    <i class="material-icons">add_circle</i> New Coupon
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header-primary">
                    Coupon Form
                </div>
                <div class="card-body">
                    <form id="coupon_form" action="{{route('admin.campaign.coupons.store')}}" method="POST">
                        @csrf
                            @if ($errors->any())
                                <!-- @dump($errors) -->
                            @endif
                        <div class="row">
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">Name</label>
                                <input value="{{ old('name') }}" type="text" name="name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">MaxUse</label>
                                <input type="text" value="{{ old('max_use') }}" name="max_use" class="form-control">
                                @error('max_use')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">Is Active</label>
                                <input type="checkbox" value="true" id="is_active" name="is_active" class="form-control input-sm text-center" checked="{{ old('is_active') == "checked" ? "checked" : "" }}" style="width: 20px;">
                                @error('is_active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">From</label>
                                <input type="date" value="{{ old('from') }}" name="from" class="form-control">
                                @error('from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">To</label>
                                <input type="date" name="to" value="{{ old('to') }}" class="form-control">
                                @error('to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label>Minimum Amount</label>
                                <input type="number" name="min_amount" value="{{ old('min_amount') }}" class="form-control">
                                @error('min_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="couponExtraSection border-top mt-3 shadow-sm p-2">
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <h5>Coupon Extra Options</h5>
                                </div>
                                <div class="col-sm-6 col-md-6 text-right">
                                    <button type="button" id="couponExtraAddBtn" class="btn btn-sm btn-primary"><i class="material-icons">add_circle</i></button>
                                </div>
                            </div>
                            @php
                                $count = count(old('type') ?? []);
                            @endphp
                            @if($count > 0)
                                @for($i = 0; $i < $count;$i++)
                                
                                <div class="row" id="extra-{{ $i + 1 }}">
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <label for="">Type </label><br>
                                        <select class="chosen-select form-control" name="type[]" id="type">
                                            <option value="amount" @if(old('type.'.$i) == "amount" ) selected @endif>Amount</option>
                                            <option value="percent" @if(old('type.'.$i) == "percent" ) selected @endif>Percent</option>
                                        </select>
                                        @error("type.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <label for="">Coupon On</label>
                                        <select class="chosen-select form-control" data-id="{{ $i + 1 }}" name="coupon_on[]" id="coupon_on">
                                            <option value="">Select Option</option>
                                            <option value="subtotal" @if(old('coupon_on.'.$i) == "subtotal" ) selected @endif>Subtotal</option>
                                            <option value="Category" @if(old('coupon_on.'.$i) == "Category" ) selected @endif>Category</option>
                                            <option value="SubCategory" @if(old('coupon_on.'.$i) == "SubCategory" ) selected @endif>SubCategory</option>
                                            <option value="ChildCategory" @if(old('coupon_on.'.$i) == "ChildCategory" ) selected @endif>ChildCategory</option>
                                            <option value="Seller" @if(old('coupon_on.'.$i) == "Seller" ) selected @endif>Seller</option>
                                            <option value="User" @if(old('coupon_on.'.$i) == "User" ) selected @endif>User</option>
                                            <option value="Location" @if(old('coupon_on.'.$i) == "Location" ) selected @endif>Location</option>
                                            <option value="Item" @if(old('coupon_on.'.$i) == "Item" ) selected @endif>Item</option>
                                            <option value="anaz_empire" @if(old('coupon_on.'.$i) == "anaz_empire" ) selected @endif>anaz_empire</option>
                                            <option value="anaz_spotlight" @if(old('coupon_on.'.$i) == "anaz_spotlight" ) selected @endif>anaz_spotlight</option>
                                            <option value="delivery_charge" @if(old('coupon_on.'.$i) == "delivery_charge" ) selected @endif>delivery_charge</option>
                                        </select>
                                        @error("coupon_on.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-sm-3 col-md-2 col-lg-2 ">
                                        <label for="">Value</label>
                                        <input type="text" value="{{ old('value.'.$i) }}" name="value[]" class="form-control">
                                        @error("value.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-sm-3 col-md-2 col-lg-2 ">
                                        <label for="">M. Amount</label>
                                        <input type="text" value="{{ old('minimum_amount.'.$i) }}" name="minimum_amount[]" class="form-control">
                                        @error("minimum_amount.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 col-md-2 col-lg-2 " id="extra_selected-{{ $i + 1 }}">
                                        <label for="">{{ old("coupon_on.$i") }}</label>
                                        
                                        <p>
                                        </p>
                                        <input type="hidden" name="couponable_id[]" value="{{ old('couponable_id.'.$i) }}">
                                        <input type="hidden" name="couponable_type[]" value="{{ old('couponable_type.'.$i) }}">
                                        
                                        
                                        @error("couponable_id.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error("couponable_type.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @endfor
                            @else
                            
                                <div class="row" id="extra-1">
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <label for="">Type </label><br>
                                        <select class="chosen-select form-control" name="type[]" id="type">
                                            <option value="amount">Amount</option>
                                            <option value="percent">Percent</option>
                                        </select>
                                        
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                        <label for="">Coupon On</label>
                                        <select class="chosen-select form-control" data-id="1" name="coupon_on[]" id="coupon_on">
                                            <option value="">Select Option</option>
                                            <option value="subtotal">Subtotal</option>
                                            <option value="Category">Category</option>
                                            <option value="SubCategory">SubCategory</option>
                                            <option value="ChildCategory">ChildCategory</option>
                                            <option value="Seller">Seller</option>
                                            <option value="User">User</option>
                                            <option value="Location">Location</option>
                                            <option value="Item">Item</option>
                                            <option value="anaz_empire">anaz_empire</option>
                                            <option value="anaz_spotlight">anaz_spotlight</option>
                                            <option value="delivery_charge">delivery_charge</option>
                                        </select>
                                        
                                    </div>
                                    <div class="col-sm-3 col-md-2 col-lg-2">
                                        <label for="">Value</label>
                                        <input type="text" name="value[]" class="form-control">
                                        
                                    </div>
                                    <div class="col-sm-3 col-md-2 col-lg-2 ">
                                        <label for="">M. Amount</label>
                                        <input type="text" name="minimum_amount[]" class="form-control">
                                        
                                    </div>
                                    <div class="col-sm-3 col-md-2 col-lg-2 form-group" id="extra_selected-1">
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="row pt-3">
                            <div class="col-sm-6 col-md-6">
                                <label for="">Success Message</label>
                                <textarea class="form-control border-success" name="success_msg" id="" cols="30" rows="3">{{ old('success_msg') }}</textarea>
                                @error("success_msg")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label for="">Error Message</label>
                                <textarea class="form-control border-danger" name="error_msg" id="" cols="30" rows="3">{{ old('error_msg') }}</textarea>
                                @error("error_msg")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <button type="reset" class="btn btn-sm btn-grey"><i class="material-icons">clear</i></button>
                                <button type="button" onclick="submit()" class="btn btn-sm btn-primary"><i class="material-icons">save</i></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header-primary">
                    Coupon Extras
                </div>
                <div class="card-body">
                    <div class="col mb-3">
                        <input type="text" class="form-control" id="search_box" onkeyup="search()" placeholder="Search here...">
                    </div>
                    <table id="coupon_extra_table" class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="extras_table">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

@endsection

@push('js')

    <script>
        $(document).ready(function(){
            let extra_selected_view = $("#extra_selected");
            let label = "";
            let table = $('.datatable_init');
            let NonCallableType = ["subtotal","delivery_charge","anaz_empire","anaz_spotlight"];
            let table_body = $("#extras_table");
            
            let count = parseInt("{{ $count ?? 0 }}") + 1;
            let activeCol = 1

            $(document).on("change","#coupon_on",function(){
                label = $(this).val();
                activeCol = $(this).data('id');
                table_body.empty();
                if(!NonCallableType.includes(label)){
                    setupExtraSelectedView($(this).val(),["",""])
                    getData($(this).val())
                }else{
                    setupExtraSelectedView($(this).val())
                }
            });

            $(document).on('click','#couponExtraAddBtn',function(){
                count = count + 1;
                let row = `
                <div class="row" id="extra-`+count+`">
                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                        <label for="">Type </label><br>
                        <select class="chosen-select form-control" name="type[]" id="type">
                            <option value="amount">Amount</option>
                            <option value="percent">Percent</option>
                        </select>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                        <label for="">Coupon On</label>
                        <select class="chosen-select form-control" data-id='`+count+`' name="coupon_on[]" id="coupon_on">
                            <option value="">Select Option</option>
                            <option value="subtotal">Subtotal</option>
                            <option value="Category">Category</option>
                            <option value="SubCategory">SubCategory</option>
                            <option value="ChildCategory">ChildCategory</option>
                            <option value="Seller">Seller</option>
                            <option value="User">User</option>
                            <option value="Location">Location</option>
                            <option value="Item">Item</option>
                            <option value="anaz_empire">anaz_empire</option>
                            <option value="anaz_spotlight">anaz_spotlight</option>
                            <option value="delivery_charge">delivery_charge</option>
                        </select>
                        
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-2">
                        <label for="">Value</label>
                        <input type="text" value="" name="value[]" class="form-control">
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-2">
                        <label for="">M. Amount</label>
                        <input type="text" name="minimum_amount[]" class="form-control">
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-2" id="extra_selected-`+count+`">
                    </div>
                </div>`;
                $('.couponExtraSection').append(row);
            });

            function setupExtraSelectedView(label = "", child = ['','0']){
               let html = "<label>"+label+"</label><p>"+child[0]+"</p><input type='hidden' name='couponable_type[]' value='"+label+"' /><input type='hidden' name='couponable_id[]' value='"+child[1]+"' />";
               $("#extra_selected-"+activeCol).html(html);
            }

            function getData(type = "Category"){
                $.get("{{ route('admin.campaign.coupons.helper') }}?type="+type,function(response){
                    if(response.status == "success"){
                        attachDataInExtraTable(response.data)
                    }else{
                        alert("Failed To fetch data.")
                    }
                });
            }

            function attachDataInExtraTable(data){
                let html = ""
                $.each(data, function (index,item){
                    html += "<tr><td>"+item.name+"</td><td><button class='btn btn-sm btn-primary' id='extra_select_btn' data-name='"+item.name+"' data-id='"+item.id+"'><i class='material-icons'>add_task</i></button></td></tr>";
                });
                table_body.html(html);
            }

            $(document).on("click","#extra_select_btn",function(){
                const id = $(this).data('id');
                const name = $(this).data('name');
                setupExtraSelectedView(label,[name,id])
            });
        });
        function submit(){
            if(confirm("Are You Sure To Add New Coupon ?")){
                $("#coupon_form").submit();
            }
        }
        function search(){
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search_box");
            filter = input.value.toUpperCase();
            table = document.getElementById("coupon_extra_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }
    </script>
@endpush
