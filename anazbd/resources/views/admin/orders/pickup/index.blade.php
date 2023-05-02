@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Orders
@endsection
@section('title','Awaiting for pickup')
@section('content')
    <div class="row">
        @include('admin.orders.partials.filter')
        
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row justify-content-between">
                        <p class="col">All Orders Awaiting Pickup</p>
                        @include('admin.orders.partials.export',[
                                'route' => 'admin.order.export',
                                'status' => 'Pickup From Seller'
                            ])
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive">
                            <thead>
                            <tr class="text-center">
                                <th width="5%">SL</th>
                                <th width="10%">Order No</th>
                                <th width="15%">User</th>
                                <th width="20%">Sellers</th>
                                <th width="25%">Items</th>
                                <th width="10%">Order At</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr class="text-center justify-content-center">
                                    <td>{{ ($orders->total()-$loop->index)-(($orders->currentpage()-1) * $orders->perpage() ) }}</td>
                                    <td>#{{ $order->no }}</td>
                                    <td>{{ $order->billing_address->name }}</td>

                                    <td>
                                        <table class="table table-bordered">
                                            @foreach($order->details as $detail)
                                                <tr>
                                                    <td>{{$detail->seller->shop_name}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td><a href="{{route('frontend.product',$item->product->slug)}}">{{$item->product->name}}</a></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($order->created_at)->format("d-m-Y h:i A") }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <form action="{{route('admin.orders.status',$order)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Arrived at Warehouse">
                                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-primary"><i class="material-icons">check</i> Arrived</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
       $(document).on('click','#sellersBtn',function (){
           $('#exampleModal').modal();
       });
       //
       //  $(document).on('click','#itemsBtn',function (){
       //      $('#itemsModal').modal();
       //  });
    </script>
@endpush

