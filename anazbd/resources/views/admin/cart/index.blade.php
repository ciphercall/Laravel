@extends('admin.layout.master')
@section('title','Cart List')
@section('page-header')
    <i class="fa fa-list"></i> Chalan List
@stop
@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary text-center">
                    <div class="row">
                        <div class="col-6 text-left">Filter Products</div>
                        <div class="col-6 text-right">
                            <div class="card-tool">
                            </div>
                        </div>
                    </div>
                </div>
                <form class="collapse show" id="filterForm" action="#">
                    <div class="card-body " >
                        <div class="row" >
                            <div class="col-sm-6 col-md-3 col-lg-3 text-center ">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Customer Name</label>
                                    <input type="text" name="name" value="{{request()->name}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3 text-center ">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Customer Mobile</label>
                                    <input type="text" name="mobile" value="{{request()->mobile}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3 text-center ">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Customer Email</label>
                                    <input type="text" name="email" value="{{request()->email}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-lg-3 text-center ">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Includes Item</label>
                                    <input type="text" name="item" value="{{request()->item}}" class="form-control">
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">search</i></button>
                            <button type="reset" class="btn btn-sm btn-info"><i class="material-icons">clear</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 card card-body">
            <table class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th style="width: 4%">SL</th>
                    <th style="width: 10%">User</th>
                    <th style="width: 10%">Mobile</th>
                    <th style="width: 10%">Email</th>
                    <th style="width: 36%">Item</th>
                    <th style="width: 12%">Created At</th>
                    <th >Action</th>
                </tr>
                @forelse($cart as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->user->name ?? '' }}</td>
                        <td>{{ $item->user->mobile ?? 'N/A' }}</td>
                        <td>{{ $item->user->email ?? 'N/A' }}</td>
                        <td>
                            <table class="table table-bordered" style="margin-bottom: 0px !important;">
                                @php
                                    $price = 0;
                                @endphp
                                @forelse($item->cart_items as $c_item)
                                    @php
                                        $price += $c_item->product->price ?? 0;
                                    @endphp
                                    <tr class="text-center {{ ($c_item->product->status == false || $c_item->product->deleted_at != null) ? 'bg-danger' : '' }}">
                                        <td style="width:90%; text-align: center !important;"><a href="{{ route('frontend.product',$c_item->product->slug) }}">{{ $c_item->product->name }}</a></td>
                                        <td style="width:90%; text-align: center !important;">{{ $c_item->product->price }}</td>
                                    </tr>
                                @empty
                                    NO Product Available.
                                @endforelse
                                @if(count($item->cart_items) > 0)
                                    <tr>
                                        <td>Total</td>
                                        <td>{{$price}}</td>
                                    </tr>
                                @endif
                            </table>
        
                        </td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                        <td>
                            @if($item->cart_items->count() > 0)
                            <form action="#" method="post">
                                @csrf
                                <input type="text" name="coupon" class="form-control" placeholder="Coupon">
                                <button class="btn btn-primary btn-sm" onclick="return confirm('Are you sure to place order ?');">Place Order</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No data available in table</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $cart->links() }}
        </div>
    </div>
    
@endsection

{{--  @push('js')
    <script type="text/javascript">
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush  --}}
