@push('css')
    <style>
        .row2 {
            display: flex;
            flex-wrap: wrap;
            /*min-width: 129px;*/
        }
        .col2{
            min-width: 117px;
            margin-right: 16px;
            margin-left: 16px;
        }
    </style>
@endpush
<form class="form-horizontal"
      action="{{route('seller.order.pending.index')}}"
      method="GET" style="overflow: auto;">
    <div class="container-fluid">
        <div class="table" >
            <div class="row">
                <div class="col col2" style="width: 14.28%;">
                    <div class="row" style="text-align: center;"><div class="col" style="text-align: center">Order No</div></div>
                    <div class="row" >
                        <select name="order" id="order" class="chosen-select" data-placeholder="- Select Order -">
                            <option value=""></option>
                            @foreach($orders as $order)
                                <option value="{{$order->no}}"
                                    {{request()->query('order') == $order->no ? 'selected' : ''}}>
                                    {{$order->no}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col2" style="width: 15.1%;">
                    <div class="row" style="text-align: center;"><div class="col" style="text-align: center">Item</div></div>
                    <div class="row" >
                        <select name="item" id="item" class="chosen-select" data-placeholder="- Select Item -">
                            <option value=""></option>
                            @foreach($items as $item)
                                <option value="{{$item->id}}"
                                    {{request()->query('item') == $item->id ? 'selected' : ''}}>
                                    {{$item->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col col2" style="width: 14.28%;">
                    <div class="row" style="text-align: center;"><div class="col" style="text-align: center">Quantity</div></div>
                    <div class="row" >
                        <input name="qty"
                               id="qty"
                               type="text"
                               class="form-control input-sm text-center"
                               value="{{request()->query('qty')}}"
                               placeholder="Quantity">
                    </div>
                </div>
                <div class="col col2" style="width: 14.28%;">
                    <div class="row" style="text-align: center;"><div class="col" style="text-align: center">Total</div></div>
                    <div class="row" >
                        <input name="total"
                               id="total"
                               type="text"
                               class="form-control input-sm text-center"
                               value="{{request()->query('total')}}"
                               placeholder="Total">
                    </div>
                </div>
                <div class="col col2" style="width: 14.28%;">
                    <div class="row" style="text-align: center;"><div class="col" style="text-align: center">From Date</div></div>
                    <div class="row" >
                        <input type="text"
                               id="from_date"
                               name="from_date"
                               placeholder="From Date"
                               value="{{request()->query('from_date')}}"
                               class="input-sm form-control text-center datepicker">
                    </div>
                </div>
                <div class="col col2" style="width: 14.28%;">
                    <div class="row" style="text-align: center;"><div class="col" style="text-align: center">To Date</div></div>
                    <div class="row" >
                        <input type="text"
                               id="to_date"
                               name="to_date"
                               placeholder="To Date"
                               value="{{request()->query('to_date')}}"
                               class="input-sm form-control text-center datepicker">
                    </div>
                </div>
                <div class="col col2" style="width: 12%;">
                    <div class="row"><div class="col" style="text-align: center">Actions</div></div>
                    <div class="row">
                        <div class="col" style="text-align: center">
                            <div class="btn-group btn-group-mini btn-corner" style="margin: 0;">
                                <button type="submit" class="btn btn-mini btn-primary" title="Search"><i class="fa fa-search"></i></button>
                                <a href="/{{request()->route()->uri()}}" class="btn btn-mini btn-info" title="Show All"><i class="fa fa-list"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
