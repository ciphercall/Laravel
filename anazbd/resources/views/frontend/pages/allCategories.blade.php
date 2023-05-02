@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    {{$category->name}}
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/category.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/loadMore.css')}}">
@endpush
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>{{$category->name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
{{-- @dd($category->image) --}}
    <!-- caagory image -->
    <div class="shop_banner_area mb-30 pl-5 pr-5">
        <div class="row">
            <div class="col-md-12 ">
                <div class="shop_banner_thumb">
                    <img src="{{ asset($category->image ??' ') }}" alt="{{ ($category->image) }}" style="width: 1440px;height: 290px;">
                </div>
            </div>
        </div>
    </div>
    @php
        $GLOBALS['catName'] = '';
        $GLOBALS['subCatName'] = '';
        $GLOBALS['childCatName'] = '';
        $GLOBALS['brandName'] = '';
    @endphp
    <div class="shop_area shop_reverse allcategory-responsive">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 ">
                    @include('frontend.include.product-filter', ['route' => 'frontend.category', 'slug' => $category->slug,])
                </div>

                <div class="col-lg-9 col-md-12">
                    <!-- @include('frontend.include.product-topbar') -->

                    @include('frontend.include.product-clear-filter', ['route' => 'frontend.category', 'slug' => $category->slug])

                    <div class="row no-gutters shop_wrapper grid_list_4" id="product-card-holder">
                        @foreach($items as $item)
                            @include('frontend.include.product-1')
                        @endforeach
                    </div>
                    <div style="text-align: center; width: 100%">
                        @if(count($items) > 0)
                            <button class="button" id="load-more"><span>Load More </span></button>
                        @endif
                    </div>
{{--                    @include('frontend.include.paginate', ['data' => $items])--}}
                </div>
            </div>
        </div>
    </div>
@endsection
