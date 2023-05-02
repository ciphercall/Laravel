@extends('admin.layout.master')
@section('page_header')
    <i class="fa fa-apple-alt"></i> Products
@endsection
@section('title','All Products')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row justify-content-between">
                        <div class="col">
                            {{ $data['item']->name }}
                        </div>
                        <div class="col text-right" >
                            <a href="{{ route('admin.product.item.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> &nbsp; Products</a>
                        </div>
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col bg-light m-3">
                        <h5>Tags:</h5>
                        <p>
                            @foreach($data['item']->tags as $tag)
                                <span class="badge badge-success">{{ $tag->name }}</span>
                            @endforeach
                        </p>
                    </div>
                    <div class="col bg-light m-3">
                        <h5>Relevent Tags Searched:</h5>
                        <p style="line-height: 200%;">
                            @foreach($data['searchedTags'] as $tag)
                                <span class="border rounded bg-white p-1">{{ $tag->search }} <span class="badge badge-success">{{ $tag->total }}</span></span>
                            @endforeach
                        </p>
                    </div>
                    <div class="col bg-light m-3">
                        <h5>Total Sold:</h5>
                        <h1>{{ $data['total_sold'] }}</h1>
                    </div>
                    <div class="col-12 bg-light m-3">
                        <div class="row">
                            <div class="col mx-1 bg-light rounded">
                                <p>Wishlisted</p>
                                <h1>{{ $data['wishlisted'] }}</h1>
                            </div>
                            <div class="col mx-1 bg-info rounded">
                                <p>Pending</p>
                                <h1>{{ $data['orders']->where('status','Pending')->count() }}</h1>
                            </div>
                            <div class="col mx-1 bg-primary rounded">
                                <p>Accepted</p>
                                <h1>{{ $data['orders']->where('status','Accepted')->count() }}</h1>
                            </div>
                            <div class="col mx-1 bg-warning rounded">
                                <p>On Delivery</p>
                                <h1>{{ $data['orders']->where('status','On Delivery')->count() }}</h1>
                            </div>
                            <div class="col mx-1 bg-success rounded">
                                <p>Delivered</p>
                                <h1>{{ $data['orders']->where('status','Delivered')->count() }}</h1>
                            </div>
                            <div class="col mx-1 bg-danger rounded">
                                <p>Cancelled</p>
                                <h1>{{ $data['orders']->where('status','Cancelled')->count() }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 bg-light m-3">
                        <div class="row">
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order No</th>
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data['orders'] as $item)
                                            <tr>
                                                <td>{{ $data['orders']->count() - $loop->index }}</td>
                                                <td>#{{ $item->no }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->total }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Searched</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $interested = $data['interested_users']->groupBy('user_id')->map(function($item){
                                                return [$item->first()->user,$item->count()];
                                            });
                                            $interested = $interested->sortByDesc(function($item){
                                                return $item[1];
                                            });
                                        @endphp
                                        @forelse($interested->take(10) as $index => $item)
                                        
                                            <tr>
                                                <td>{{ $interested->count() - $loop->index }}</td>
                                                <td>{{ $item[0]->name ?? '' }}</td>
                                                <td>{{$item[1]}}</td>
                                                <td></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        </div>
@endsection

@push('js')
    <script>
       
    </script>
@endpush

