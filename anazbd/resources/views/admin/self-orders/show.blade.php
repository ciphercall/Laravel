@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">receipt</i> Self Order
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary">
                    Self-Order by {{$order->name}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            Name: {{$order->name}} <br>
                            Mobile: {{$order->mobile}}
                        </div>
                        <div class="col-6">
                            Address: {{$order->address}}
                        </div>
                    </div>
                    <div class="row mt-3">
                        @forelse($order->images as $image)
                            <div class="col-3">
                                <img src="{{asset($image->image)}}" alt="Order Image" class="img img-fluid">
                            </div>
                        @empty
                            <div class="col-12">
                                <h3>No Images Were Uploaded.</h3>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

