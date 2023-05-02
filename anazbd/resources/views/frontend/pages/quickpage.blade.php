@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    aboutus
@endsection
@section('content')
     <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>{{ collect(request()->segments())->last() }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--about bg area start-->
    <div class="about_bg_area">
        <div class="container">

            <!--services img area-->
            <div class="about_gallery_section mb-55">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <article class="single_gallery_section">
                            <figure>
                                <figcaption class="about_gallery_content">                                    
                                    <p>
                                       {!! $page->short_desc !!}
                                    </p>
                                </figcaption>
                            </figure>
                        </article>
                    </div>
                </div>
            </div>
            <!--services img end-->

        </div>
    </div>
    <!--about bg area end-->
@endsection
