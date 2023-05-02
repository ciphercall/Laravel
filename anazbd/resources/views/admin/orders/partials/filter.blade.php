<div class="col-12">
    <div class="card">
        <div class="card-header-primary">
            <div class="row mx-3 justify-content-between">
                <p>Filter {{ ucfirst(last(request()->segments())) }} Orders</p>
            <button class="btn btn-sm btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <form action="#" method="get">
            <div class="card-body" id="collapseExample">
                <div class="row">
                    <div class="col-3 form-group">
                        <label for="">Order No</label>
                        <input type="text" name="order_no" value="{{request()->order_no}}" class="form-control" id="">
                    </div>
                    <div class="col form-group">
                        <label for="">Customer</label>
                        <select class="form-control" name="user" id="">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if(request()->user == $user->id) selected @endif>{{ $user->name ?? $user->mobile }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col form-group">
                        <label for="">From Date</label>
                        <input type="date" value="{{request()->date}}" name="from" class="form-control" id="">
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
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Partially Paid">Partially Paid</option>
                        </select>
                    </div>
                </div>
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