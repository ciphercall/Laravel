@php
$hasAgents = isset($agents);
@endphp

<form class="form-horizontal"
      method="GET"
      role="form"
      action="/{{request()->route()->uri()}}"
      enctype="multipart/form-data">
    <table class="table table-bordered">
        <tr>
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="order">Order No.</label></th>
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="customer">Customer</label></th>
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="shop">Shop</label></th>
            @if($hasAgents)
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="agent">Agent</label></th>
            @endif
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="total">Total</label></th>
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="from_date">From Date</label></th>
            <th class="bg-dark" style="width: {{$hasAgents ? '12.5%':'14.28%'}}"><label for="to_date">To Date</label></th>
            <th class="bg-dark" style="width: {{$hasAgents ? '12%':'14%'}}"><label for="">Action</label></th>
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
                <select class="chosen-select" id="shop" name="shop" data-placeholder="- Shop -">
                    <option value=""></option>
                    @foreach($sellers as $seller)
                        <option value="{{$seller->id}}" {{$seller->id == request()->query('shop') ? 'selected':''}}>
                            {{$seller->shop_name}}
                        </option>
                    @endforeach
                </select>
            </td>
            @if($hasAgents)
            <td>
                <select class="chosen-select" id="agent" name="agent" data-placeholder="- Agent -">
                    <option value=""></option>
                    @foreach($agents as $agent)
                        <option value="{{$agent->id}}" {{$agent->id == request()->query('agent') ? 'selected':''}}>
                            {{$agent->name}}
                        </option>
                    @endforeach
                </select>
            </td>
            @endif
            <td>
                <input type="text"
                       id="total"
                       name="total"
                       placeholder="Total"
                       value="{{request()->query('total')}}"
                       class="input-sm form-control text-center">
            </td>
            <td>
                <input type="text"
                       id="from_date"
                       name="from_date"
                       placeholder="From Date"
                       value="{{request()->query('from_date')}}"
                       class="input-sm form-control text-center datepicker">
            </td>
            <td>
                <input type="text"
                       id="to_date"
                       name="to_date"
                       placeholder="To Date"
                       value="{{request()->query('to_date')}}"
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
