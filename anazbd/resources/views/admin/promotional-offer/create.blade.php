@extends('admin.layout.master')
@section('title',"New Offer")
@section('page_header')
    <i class="material-icons">add_circle</i> New Offer
@endsection
@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="row">
            <div class="card">
                <div class="card-header-primary">
                    Offer Form
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.campaign.offer.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Offer Name</label>
                                <input type="text" name="offer_name" class="form-control">
                                @error('offer')
                                    <small class="alert alert-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Offer Type</label>
                                <select name="type" name="offer_type" class="form-control">
                                    <option value="">Select Offer Type</option>
                                    <option value="cashback">Cashback</option>
                                    <option value="free_delivery">Free Delivery</option>
                                    <option value="buy2get1">Buy 2 Get 1</option>
                                </select>
                                @error('offer')
                                    <small class="alert alert-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Subtotal</label><br>
                                <input type="number" name="amount" class="form-control">
                                @error('offer')
                                    <small class="alert alert-danger">{{ $message }}</small>
                                @else
                                    <small class="text-muted">Applies offer for Subtotal equal or greater than given value.</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="">Valid From</label>
                                <input type="datetime-local" placeholder="2021-12-31T13:00" name="from" class="form-control">
                                @error('from')
                                    <small class="alert alert-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col form-group">
                                <label for="">Valid Till</label><br>
                                <input type="datetime-local" placeholder="2021-12-31T13:00" name="to" class="form-control">
                                @error('offer')
                                    <small class="alert alert-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-md-4 col-lg-4 form-group">
                                <label for="">Applicable On</label>
                                <select class="chosen-select form-control" name="applicable_to" id="applicable_to">
                                    <option>Apply To All</option>
                                    <option value="Category">Category</option>
                                    <option value="SubCategory">SubCategory</option>
                                    <option value="ChildCategory">ChildCategory</option>
                                    <option value="Seller">Seller</option>
                                    <option value="User">User</option>
                                    <option value="Location">Location</option>
                                    <option value="Item">Item</option>
                                    <option value="anaz_empire">anaz_empire</option>
                                    <option value="anaz_spotlight">anaz_spotlight</option>
                                </select>
                                @error('on')
                                    <span class="text-danger">{{ $message }}</span>
                                @else
                                    <small class="text-muted">Leave blank if Offer Applies to everyone & on every item</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="offer_applicable_item_table">

                                </tbody>
                                
                            </table>
                            
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-primary"><i class="material-icons">save</i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header-primary">
                Offer Extra Helpers
            </div>
            <div class="card-body">
                <div class="col mb-3">
                    <input type="text" class="form-control" id="search_box" onkeyup="search()" placeholder="Search here...">
                </div>
                <table class="table table-bordered">
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
        var count = 0;
        let NonCallableType = ["subtotal","delivery_charge","anaz_empire","anaz_spotlight","Apply To All"];
        let table_body = $("#extras_table");

        $(document).on("change","#applicable_to",function(){
            label = $(this).val();
            if(!NonCallableType.includes(label)){
                table_body.empty();
                getData($(this).val())
            }else{
                if(label == "anaz_empire" || label == "anaz_spotlight"){
                    count++;
                    row = "<tr id='applicable_row_"+count+"'><td colspan=2>"+label+"<input type='hidden' value='"+label+"' name='type[]'><input type='hidden' value='"+label+"' name='name[]'><input type='hidden' value='"+label+"' name='id[]'></td><td><button class='btn btn-sm btn-danger' id='delete_row' type='button' data-row="+count+"><i  class='material-icons'>delete</i></button></td></tr>";
                    $("#offer_applicable_item_table").append(row);
                }
            }
        });

        function getData(type){
            $.get("{{ route('admin.campaign.coupons.helper') }}?type="+type,function(response){
                if(response.status == "success"){
                    attachDataInExtraTable(response.data,type)
                }else{
                    alert("Failed To fetch data.");
                }
            });
        }

        function attachDataInExtraTable(data,type){
            let html = ""
            $.each(data, function (index,item){
                html += "<tr><td>"+item.name+"</td><td><button class='btn btn-sm btn-primary' id='extra_select_btn' data-type='"+type+"' data-name='"+item.name+"' data-id='"+item.id+"'><i class='material-icons'>add_task</i></button></td></tr>";
            });
            table_body.html(html);
        }

        $(document).on("click","#extra_select_btn",function(){
            count++;
            const id = $(this).data('id');
            const name = $(this).data('name');
            const type = $(this).data('type');
            let row = "<tr id='applicable_row_"+count+"'><td>"+type+"<input type='hidden' value='"+type+"' name='type[]'></td><td>"+name+"<input type='hidden' value='"+name+"' name='name[]'><input type='hidden' value='"+id+"' name='id[]'></td><td><button class='btn btn-sm btn-danger' id='delete_row' type='button' data-row="+count+"><i class='material-icons'>delete</i></button></td></tr>";
            $("#offer_applicable_item_table").append(row);
        });

        function search(){
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search_box");
            filter = input.value.toUpperCase();
            table = document.getElementById("extras_table");
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

        $(document).on("click","#delete_row",function(){
            const id = $(this).data('row');
            $("#applicable_row_"+id).remove()
        });
    </script>
@endpush