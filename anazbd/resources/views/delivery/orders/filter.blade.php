<form class="form-horizontal"
      method="GET"
      role="form"
      action="/{{request()->route()->uri()}}"
      enctype="multipart/form-data">
    <table class="table table-bordered">
        <tr>
            <th class="bg-dark" style="width: 14.28%"><label for="order">Order No.</label></th>
            <th class="bg-dark" style="width: 14.28%"><label for="customer">Customer</label></th>
            <th class="bg-dark" style="width: 14.28%"><label for="division">Division</label></th>
            <th class="bg-dark" style="width: 14.28%"><label for="city">City</label></th>
            <th class="bg-dark" style="width: 14.28%"><label for="area">Area</label></th>
            <th class="bg-dark" style="width: 14.28%"><label for="date">Date</label></th>
            <th class="bg-dark" style="width: 14%"><label for="">Action</label></th>
        </tr>
        <tr>
            <td>
                <select class="chosen-select" id="order" name="order" data-placeholder="- Order No. -">
                    <option value=""></option>
                    @foreach($order_nos as $order)
                        <option value="{{$order->id}}" {{$order->id == request()->query('order') ? 'selected':''}}>
                            {{$order->no}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="customer" name="customer" data-placeholder="- Customer -">
                    <option value=""></option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}" {{$user->id == request()->query('customer') ? 'selected':''}}>
                            {{$user->name}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="division" name="division" data-placeholder="- Division -">
                    <option value=""></option>
                    @foreach($divisions as $division)
                        <option value="{{$division->id}}" {{$division->id == request()->query('division') ? 'selected':''}}>
                            {{$division->name}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="city" name="city" data-placeholder="- City -">
                    <option value=""></option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}" {{$city->id == request()->query('city') ? 'selected':''}}>
                            {{$city->name}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="chosen-select" id="area" name="area" data-placeholder="- Area -">
                    <option value=""></option>
                    @foreach($areas as $area)
                        <option value="{{$area->id}}" {{$area->id == request()->query('area') ? 'selected':''}}>
                            {{$area->name}}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text"
                       id="date"
                       name="date"
                       placeholder="Date"
                       value="{{request()->query('date')}}"
                       class="input-sm form-control text-center datepicker">
            </td>
            <td>
                <div class="btn-group btn-group-mini btn-corner">
                    <button type="submit"
                            class="btn btn-xs btn-primary"
                            title="Search">
                        <i class="ace-icon fa fa-search"></i>
                    </button>

                    <a href="/{{request()->route()->uri()}}"
                       class="btn btn-xs btn-info"
                       title="Show All">
                        <i class="ace-icon fa fa-list"></i>
                    </a>
                </div>
            </td>
        </tr>
    </table>
</form>
