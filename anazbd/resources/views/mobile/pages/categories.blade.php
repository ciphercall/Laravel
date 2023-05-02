@extends('mobile.layouts.master')
@section('mobile')
    <div class="product-catagories-wrapper py-3">
        <div class="">
            <div class="product-catagory-wrap">
                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h5 class="pl-1">Categories</h5>
                </div>
                <div class="container" style="border-radius: 10px;">
                    <div class="row">
                        @foreach(collect($categories) as $category)
                            <div class="col-4" style="padding-right: 0; padding-left: 0">
                                <div class="card catagory-card" style="border-radius: 0; padding-bottom: 8px;">
                                    <div class="card-body">
                                        <a href="{{route('frontend.category', $category->slug)}}">
                                            <img src="{{ asset($category->image)}}" alt="{{ ($category->image) }}"
                                                 style="height: 50px; width:50px">
                                        </a>
                                    </div>
                                    <span style="font-size: 12px;color:black">{{ Str::limit( $category->name, 12) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
