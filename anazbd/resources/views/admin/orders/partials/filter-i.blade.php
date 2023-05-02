<div class="col-12">
    <div class="card">
        <div class="card-header-primary">
            <div class="row mx-3 justify-content-between">
                <p>Filter {{ ucwords(last(request()->segments())) }} Orders</p>
            <button class="btn btn-sm btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <form action="#" method="get">
            <div class="card-body" id="collapseExample">
                <div class="row">
                    <div class="col form-group">
                        <label for="">Order No</label>
                        <input type="text" name="order_no" value="{{request()->order_no}}" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">Invoice No</label>
                        <input type="text" name="invoice_no" value="{{request()->invoice_no}}" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">Agent</label>
                        <select class="form-control" name="user" id="">
                            <option value="">Select Agent</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if(request()->user == $user->id) seleceted="selected" @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col form-group">
                        <label for="">From Date</label>
                        <input type="date" value="{{request()->from}}" name="from" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">To Date</label>
                        <input type="date" value="{{request()->to}}" name="to" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">Total</label>
                        <input type="text" name="total" value="{{request()->total}}" class="form-control" id="">
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="">Mobile</label>
                        <input type="text" class="form-control" value="{{ request()->mobile }}" name="mobile">
                    </div>
                    <div class="col form-group">
                        <label for="">Order Date</label>
                        <input type="date" class="form-control" value="{{ request()->order_date }}" name="order_date">
                    </div>
                    <div class="col form-group">
                        <label for="">Total From</label>
                        <input type="text" name="price_from" value="{{request()->price_from}}" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">Total To</label>
                        <input type="text" name="price_to" value="{{request()->price_to}}" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">Payment Status</label>
                        <select class="form-control" name="payment_status" id="">
                            <option value="">Select Payment Status</option>
                            <option value="Paid" @if(request()->payment_status == "Paid") seleceted="selected" @endif>Paid</option>
                            <option value="Unpaid" @if(request()->payment_status == "Unpaid") seleceted="selected" @endif>Unpaid</option>
                            <option value="Partially Paid" @if(request()->payment_status == "Partially Paid") seleceted="selected" @endif>Partially Paid</option>
                        </select>
                    </div>
                </div>
                @if(last(request()->segments()) == "delivered")
                    <div class="row">
                        <div class="col form-group">
                            <label for="">Items</label>
                            <select data-select2-id='items' name="item_id" class="select2">
                                <option value="" @if(request()->item_id == NULL)  selected="selected" @endif>Select Item</option>
                                @foreach($data['items'] as $item)
                                    <option value="{{ $item->id }}" @if(request()->item_id == $item->id)  selected="selected" @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="">Categories</label>
                            <select data-select2-id='categories' name="category_id" class="select2">
                                <option value="" @if(request()->category_id == NULL)  selected="selected" @endif>Select Category</option>
                                @foreach($data['categories'] as $item)
                                    <option value="{{ $item->id }}" @if(request()->category_id == $item->id)  selected="selected" @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="">Sub Categories</label>
                            <select data-select2-id='subcategories' name="sub_category_id" class="select2">
                                <option value="" @if(request()->sub_category_id == NULL)  selected="selected" @endif>Select Sub Category</option>
                                @foreach($data['subCategories'] as $item)
                                    <option value="{{ $item->id }}" @if(request()->sub_category_id == $item->id)  selected="selected" @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="">Child Categories</label>
                            <select data-select2-id='childcategories' name="child_category_id" class="select2">
                                <option value="" @if(request()->child_category_id == NULL)  selected="selected" @endif>Select Child Category</option>
                                @foreach($data['childCategories'] as $item)
                                    <option value="{{ $item->id }}" @if(request()->child_category_id == $item->id)  selected="selected" @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3  text-right">
                        <button class="btn btn-sm btn-primary">Filter</button>
                    </div>
                    <div class="col-3 text-left">
                        <a href="{{route(request()->route()->getName())}}" class="btn btn-sm btn-warning">Reset</a>
                    </div>
                    <div class="col-3"></div>
                </div>
            </div>
        </form>
    </div>
</div>