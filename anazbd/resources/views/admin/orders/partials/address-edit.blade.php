@isset($address)
    <div class="card rounded shadow-sm p-2">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center text-white bg-dark rounded p-2"><b>Customer Information</b></div>
            </div>
            <hr>
            <input type="hidden" name="billing_address_id" value="{{$address->id}}">
            <div class="row">
                <div class="col form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$address->name}}">
                </div>
                <div class="col form-group">
                    <label for="">Mobile</label>
                    <input type="text" name="mobile" class="form-control" value="{{$address->mobile}}">
                </div>
                <div class="col form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" value="{{$address->email}}">
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="">Address Line 1</label>
                    <input type="text" name="address_line_1" class="form-control" value="{{$address->address_line_1}}">
                </div>
                <div class="col form-group">
                    <label for="">Address Line 2</label>
                    <input type="text" name="address_line_2" class="form-control" value="{{$address->address_line_2}}">
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="">Divisions</label>
                    <select class="form-control" name="division_id" id="">
                        <option value="">Select Division</option>
                        @if(array_key_exists("divisions",$data))
                            @foreach($data["divisions"] as $division)
                                <option value="{{$division->id}}" @if($address->division_id == $division->id) selected="selected" @endif>{{$division->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col form-group">
                    <label for="">Cities</label>
                    <select class="form-control" name="city_id" id="">
                        <option value="">Select Cities</option>
                        @if(array_key_exists("cities",$data))
                            @foreach($data["cities"] as $city)
                                <option value="{{$city->id}}" @if($address->city_id  == $city->id) selected="selected" @endif>{{$city->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col form-group">
                    <label for="">Area</label>
                    <select class="form-control" name="post_code_id" id="">
                        <option  value="">Select Areas</option>
                        @if(array_key_exists("areas",$data))
                            @foreach($data["areas"] as $area)
                                <option value="{{$area->id}}" @if($address->post_code_id == $area->id) selected="selected" @endif>{{$area->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card rounded shadow-sm p-2">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center text-white bg-dark rounded p-2"><b>Customer Information</b></div>
            </div>
            <hr>
            <input type="hidden" name="billing_address_id" value="{{$order->billing_address->id}}">
            <div class="row">
                <div class="col form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$order->billing_address->name}}">
                </div>
                <div class="col form-group">
                    <label for="">Mobile</label>
                    <input type="text" name="mobile" class="form-control" value="{{$order->billing_address->mobile}}">
                </div>
                <div class="col form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" value="{{$order->billing_address->email}}">
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="">Address Line 1</label>
                    <input type="text" name="address_line_1" class="form-control" value="{{$order->billing_address->address_line_1}}">
                </div>
                <div class="col form-group">
                    <label for="">Address Line 2</label>
                    <input type="text" name="address_line_2" class="form-control" value="{{$order->billing_address->address_line_2}}">
                </div>
            </div>
            <div class="row">
                <div class="col form-group">
                    <label for="">Divisions</label>
                    <select class="form-control" name="division_id" id="">
                        <option value="">Select Division</option>
                        @if(array_key_exists("divisions",$data))
                            @foreach($data["divisions"] as $division)
                                <option value="{{$division->id}}" @if($order->billing_address->division_id == $division->id) selected="selected" @endif>{{$division->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col form-group">
                    <label for="">Cities</label>
                    <select class="form-control" name="city_id" id="">
                        <option value="">Select Cities</option>
                        @if(array_key_exists("cities",$data))
                            @foreach($data["cities"] as $city)
                                <option value="{{$city->id}}" @if($order->billing_address->city_id  == $city->id) selected="selected" @endif>{{$city->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col form-group">
                    <label for="">Area</label>
                    <select class="form-control" name="post_code_id" id="">
                        <option  value="">Select Areas</option>
                        @if(array_key_exists("areas",$data))
                            @foreach($data["areas"] as $area)
                                <option value="{{$area->id}}" @if($order->billing_address->post_code_id == $area->id) selected="selected" @endif>{{$area->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
@endisset
