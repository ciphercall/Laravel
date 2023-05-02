@isset($chalan)
    @php
        $groupedItems = [];
        foreach ($chalan->order->items as $item){
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
        if ($chalan->order->delivery_breakdown != null){
            $arr = explode(',',$chalan->order->delivery_breakdown);
            foreach ($arr as $single){
                $singleString = explode(':',$single);
                $delivery[$singleString[0]] = $singleString[1];
            }
        }
        $chalanItems = $chalan->chalan_items->pluck('item_id')->toArray();
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
                        <div class="col-12 text-white text-center p-1 bg-primary">
                            {{$shop_name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Original Price</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr class="text-white {{ in_array($item->item_id,$chalanItems) ? 'bg-info' : 'bg-warning' }}">
                                        <td><a href="{{ route('frontend.product',$item->product->slug) }}" class="text-white">{{Str::limit($item->product->name,40)}}</a></td>
                                        <td>{{$item->variant->price}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{$item->subtotal}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
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
    @endforeach
    @if($chalan->order->note != null)
        <div class="col-12 card rounded">
            <div class="card-header-primary text-center">
                Order Instructions
            </div>
            <div class="card-body">
                {{$chalan->order->note}}
            </div>
        </div>
    @endif
@else
    @php
        $groupedItems = [];
        foreach ($order->items as $item){
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
                        <div class="col-12 text-white text-center p-1 bg-primary">
                            {{$shop_name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Original Price</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td><a href="{{ route('frontend.product',$item->product->slug) }}">{{Str::limit($item->product->name,40)}}</a></td>
                                        <td>{{$item->variant->price}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{$item->subtotal}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
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
    @endforeach
    @if($order->note != null)
        <div class="col-12 card rounded">
            <div class="card-header-primary text-center">
                Order Instructions
            </div>
            <div class="card-body">
                {{$order->note}}
            </div>
        </div>
    @endif
@endisset
