@extends('mobile.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Anaz Recipes
@endsection
@push('css')
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style2.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/themes/metroui.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/noty.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css')}}">

@endpush
@section('mobile')
    <!--blog body area start-->
    <div class="blog_bg_area">
        <div class="container">
            <div class="blog_page_section">
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <!--blog grid area start-->
                        <div class="blog_wrapper blog_details">

                            <div class="related_posts">
                                <h3>Recipes</h3>
                                <div class="row">
                                    @if($posts)

                                        @forelse($posts as $blog)
                                            <div class="col-lg-4 col-md-6">
                                                <a href="{{ route('blog.show', $blog->slug) }}">
                                                    <article class="single_related">
                                                        <figure>
                                                            <div class="related_thumb">
                                                                <img src="{{ asset($blog->short_image) }}"
                                                                     alt="{{ ($blog->short_image) }}">
                                                            </div>
                                                            <figcaption class="related_content">
                                                                <h4><a href="#">{{ $blog->title }}</a></h4>
                                                                <small
                                                                    class="text-muted">{{ Str::limit(strip_tags($blog->description),100) }}</small>
                                                                <div class="blog_meta">
                                                                    <span class="author">By : <a
                                                                            href="#">{{ $blog->admin->name }}</a> / </span>
                                                                    <span class="meta_date">
                                                                {{ \Carbon\Carbon::parse($blog->create)->format('d-M-Y')}}
                                                            </span>
                                                                </div>
                                                            </figcaption>
                                                        </figure>
                                                    </article>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--blog grid area start-->
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="blog_sidebar_widget">
                            {{-- <div class="widget_list widget_search">
                                <div class="widget_title">
                                    <h3>Search</h3>
                                </div>
                                <form action="#">
                                    <input placeholder="Search..." type="text">
                                    <button type="submit">search</button>
                                </form> --}}
                            {{-- </div> --}}
                            <div class="widget_list widget_post">
                                <div class="widget_title">
                                    <h3>Recent Posts</h3>
                                </div>
                                @if($recent_posts)
                                    @forelse($recent_posts as $blog)
                                        <div class="post_wrapper">
                                            <div class="post_thumb">
                                                <a href="blog-details.html"><img src="{{ asset($blog->short_image) }}"
                                                                                 alt=""></a>
                                            </div>
                                            <div class="post_info">
                                                <h4><a href="blog-details.html">{{ $blog->title }}</a></h4>
                                                <span{{ \Carbon\Carbon::parse($blog->create)->format('d-M-Y')}} </span>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                @endif

                            </div>

                            {{-- <div class="widget_list widget_categories">
                                <div class="widget_title">
                                    <h3>Categories</h3>
                                </div>
                                <ul>
                                    <li><a href="#">Audio</a></li>
                                    <li><a href="#">Company</a></li>
                                    <li><a href="#">Gallery</a></li>
                                    <li><a href="#">Image</a></li>
                                    <li><a href="#">Other</a></li>
                                    <li><a href="#">Travel</a></li>
                                </ul>
                            </div> --}}

                            {{-- <div class="widget_list widget_tag">
                                <div class="widget_title">
                                    <h3>Tag products</h3>
                                </div>
                                <div class="tag_widget">
                                    <ul>
                                        <li><a href="#">asian</a></li>
                                        <li><a href="#">brown</a></li>
                                        <li><a href="#">euro</a></li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--blog section area end-->
@endsection
