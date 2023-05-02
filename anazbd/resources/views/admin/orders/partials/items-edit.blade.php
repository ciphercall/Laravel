@php
    $groupedItems = [];
    if (!isset($items)){
        $items = $order->items;
    }
    if (!isset($order)){
        $order = $chalan->order;
    }

    foreach ($items as $item){
        $key = "";
        if ($item->seller->is_anazmall_seller){
            $key = "Anaz Empire";
        }elseif ($item->seller->is_premium){
            $key = "Anaz Spotlight";
        }else{
            $key = "Others";
        }
        $groupedItems[$key][$item->seller->shop_name][] = $item;
    }
    $delivery = [];
    if ($order->delivery_breakdown != null){
        $arr = explode(',',$order->delivery_breakdown);
        foreach ($arr as $single){
            $singleString = explode(':',$single);
            $delivery[$singleString[0]] = $singleString[1];
        }
    }
@endphp

@foreach($groupedItems as $key => $collection)
    <div class="row mb-2">
        <div class="col-12 bg-dark rounded">
            <h4 class="text-white text-center p-2">{{$key}}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom">
            @foreach($collection as $shop_name => $items)
                <div class="row">
                    <div class="col-12 text-center p-1 border border-info rounded">
                        {{$shop_name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th >Original Price</th>
                                <th width="25%">Price</th>
                                <th width="25%">Quantity</th>
                                <th width="10%">Subtotal</th>
                                <th width="10%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td><a href="{{ route('frontend.product',$item->product->slug) }}">{{Str::limit($item->product->name,40)}}</a></td>
                                    <td>{{$item->variant->price}}</td>
                                    <td><input id="price" data-id="{{$item->id}}" type="text" class="form-control price-{{$item->id}}" name="price[{{$item->id}}]" value="{{$item->price}}"></td>
                                    <td><input id="qty" data-id="{{$item->id}}" type="text" class="form-control qty-{{$item->id}}" name="qty[{{$item->id}}]" value="{{$item->qty}}"></td>
                                    <td id="subtotal-{{$item->id}}">{{$item->subtotal}}</td>
                                    <td><a href="{{ route('admin.orders.deactivate.item',$item) }}" onclick="return confirm('Are you sure to delete this item ?')"><i class="material-icons">delete</i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td>Subtotal</td>
                                <td>{{ collect($items)->sum('subtotal') }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    @if(array_key_exists($shop_name,$delivery))
                        <div class="col-12 text-right">Delivery Charge for {{$shop_name}}:{{ $delivery[$shop_name] }} Tk</div>
                    @endif
                </div>
            @endforeach
            @if(array_key_exists($key,$delivery))
                <div class="row">
                    <div class="col-12 text-right">Delivery Charge for {{$key}}:{{ $delivery[$key] }} Tk</div>
                </div>
            @endif
        </div>
    </div>
    @if($order->note != null)
        <div class="col-12 card rounded">
            <div class="card-header-primary text-center">
                Order Instructions
            </div>
            <div class="card-body">
                <textarea name="note" id="" class="form-control" cols="30" rows="3">{{$order->note}}</textarea>
            </div>
        </div>
    @endif
@endforeach
