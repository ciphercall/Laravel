@extends('admin.layout.master')
@section('title','Edit New Coupon')
@section('page_header')
    <i class="material-icons">edit</i> Edit Coupon
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header-primary">
                    Coupon Form
                </div>
                <div class="card-body">
                    <form id="coupon_form" action="{{route('admin.campaign.coupons.update',$coupon->id)}}" method="POST">
                        @csrf
                            @if ($errors->any())
                                <div class="row alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        <div class="row">
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">Name</label>
                                <input value="{{ $coupon->name }}" type="text" name="name" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">Max_use</label>
                                <input type="text" value="{{ $coupon->max_use }}" name="max_use" class="form-control">
                                @error('max_use')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">Is Active</label>
                                <input type="checkbox" value="true" id="is_active" name="is_active" class="form-control input-sm text-center" checked="{{ $coupon->is_active == "checked" ? "checked" : "" }}" style="width: 20px;">
                                @error('is_active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">From</label>
                                <input type="date" value="{{ Carbon\Carbon::parse($coupon->from)->format("Y-m-d") }}" name="from" class="form-control">
                                @error('from')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">To</label>
                                <input type="date" name="to" value="{{ Carbon\Carbon::parse($coupon->to)->format("Y-m-d") }}" class="form-control">
                                @error('to')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label>Minimum Amount</label>
                                <input type="number" name="min_amount" value="{{ $coupon->min_amount }}" class="form-control">
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
                            
                                @foreach($coupon->couponExtra as $extra)
                                    <input type="hidden" name="couponExtra_id[]" value="{{ $extra->id }}" >
                                    <div class="row" id="extra-{{ $extra->index }}">
                                        <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                            <label for="">Type </label><br>
                                            <select class="chosen-select form-control" name="type[]" id="type">
                                                <option value="amount" @if($extra->type == "amount" ) selected @endif>Amount</option>
                                                <option value="percent" @if($extra->type == "percent" ) selected @endif>Percent</option>
                                            </select>
                                            @error("type.$extra->index")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-sm-3 col-md-3 col-lg-3 form-group">
                                            <label for="">Coupon On</label>
                                            <select class="chosen-select form-control" data-id="{{ $extra->index }}" name="coupon_on[]" id="coupon_on">
                                                <option value="">Select Option</option>
                                                <option value="subtotal" @if($extra->coupon_on == "subtotal" ) selected @endif>Subtotal</option>
                                                <option value="Category" @if($extra->coupon_on == "Category" ) selected @endif>Category</option>
                                                <option value="SubCategory" @if($extra->coupon_on == "SubCategory" ) selected @endif>SubCategory</option>
                                                <option value="ChildCategory" @if($extra->coupon_on == "ChildCategory" ) selected @endif>ChildCategory</option>
                                                <option value="Seller" @if($extra->coupon_on == "Seller" ) selected @endif>Seller</option>
                                                <option value="User" @if($extra->coupon_on == "User" ) selected @endif>User</option>
                                                <option value="Location" @if($extra->coupon_on == "Location" ) selected @endif>Location</option>
                                                <option value="Item" @if($extra->coupon_on == "Item" ) selected @endif>Item</option>
                                                <option value="anaz_empire" @if($extra->coupon_on == "anaz_empire" ) selected @endif>anaz_empire</option>
                                                <option value="anaz_spotlight" @if($extra->coupon_on == "anaz_spotlight" ) selected @endif>anaz_spotlight</option>
                                                <option value="delivery_charge" @if($extra->coupon_on == "delivery_charge" ) selected @endif>delivery_charge</option>
                                            </select>
                                            @error("coupon_on.$extra->index")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-sm-3 col-md-2 col-lg-2">
                                            <label for="">Value</label>
                                            <input type="text" value="{{ $extra->value }}" name="value[]" class="form-control">
                                            @error("value.$extra->index")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-3 col-md-2 col-lg-2">
                                            <label for="">M Amount</label>
                                            <input type="text" value="{{ $extra->min_amount }}" name="minimum_amount[]" class="form-control">
                                            @error("minimum_amount.$extra->index")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    
                                        <div class="col-sm-3 col-md-2 col-lg-2" id="extra_selected-{{ $extra->index }}">
                                            <label for="">{{ $extra->coupon_on }}</label>
                                            
                                            <p>
                                                @if($extra->couponable != null)
                                                    {{ $extra->couponable->name }}
                                                @endif
                                            </p>
                                            <input type="hidden" name="couponable_id[]" value="{{ $extra->couponable_id }}">
                                            <input type="hidden" name="couponable_type[]" value="{{ $extra->couponable_type }}">
                                            
                                            
                                            @error("couponable_id.$extra->index")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            @error("couponable_type.$extra->index")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-6 col-md-6">
                                <label for="">Success Message</label>
                                <textarea class="form-control border-success" name="success_msg" id="" cols="30" rows="3">{{ $coupon->success_msg }}</textarea>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label for="">Error Message</label>
                                <textarea class="form-control border-danger" name="error_msg" id="" cols="30" rows="3">{{ $coupon->error_msg }}</textarea>
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

            $(document).on("change","#coupon_on",function(){
                label = $(this).val();
                table_body.empty();
                if(!NonCallableType.includes(label)){
                    getData($(this).val())
                    setupExtraSelectedView($(this).val(),["",""])
                }
            });

            

            function setupExtraSelectedView(label = "", child = ""){
               let html = "<label>"+label+"</label><p>"+child[0]+"</p><input type='hidden' name='couponable_type' value="+label+" /><input type='hidden' name='couponable_id' value="+child[1]+" />";
               extra_selected_view.html(html);
            }

            function getData(type){
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