@extends('mobile.layouts.master')
@section('mobile')
<div class="blog_bg_area">
    <div class="container">
        <div class="blog_page_section">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <!--blog grid area start-->
                    <div class="blog_wrapper blog_details">
                            <article class="single_blog">
                                    <figure>
                                        <div class="post_header">
                                            <h3 class="post_title"></h3>
                                            <div class="blog_meta">
                                                <span class="author">Posted by : <a href="#"></a> / </span>
                                                {{-- <span class="meta_date">On : <a href="#">{{ ($blog->update->format('d/m/Y')) }}</a> /</span> --}}
                                                <span class="meta_date">On : <a href="#">
                                                </a> /</span>
                                                {{-- <span class="post_category">In : <a href="#">Company, Image, Travel</a></span> --}}
                                            </div>
                                        </div>
                                        <div class="blog_thumb">
                                            <img src="" alt="">
                                        </div>
                                        <figcaption class="blog_content">
                                            <div class="post_content">

                                            </div>

                                        </figcaption>
                                    </figure>
                            </article>
                        <div class="related_posts">
                            <h3>Related posts</h3>
                            <div class="row">

                                        <div class="col-lg-4 col-md-6">
                                            <a href="">
                                                <article class="single_related">
                                                    <figure>
                                                        <div class="related_thumb">
                                                            <img src="" alt="">
                                                        </div>
                                                        <figcaption class="related_content">
                                                            <h4><a href="#"></a></h4>
                                                            <div class="blog_meta">
                                                                <span class="author">By : <a href="#"></a> / </span>
                                                                <span class="meta_date">
                                                            </span>
                                                            </div>
                                                        </figcaption>
                                                    </figure>
                                                </article>
                                            </a>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <!--blog grid area start-->
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="blog_sidebar_widget">
                        <div class="widget_list widget_post">
                            <div class="widget_title">
                                <h3>Recent Posts</h3>
                            </div>
                                    <div class="post_wrapper">
                                        <div class="post_thumb">
                                            <a href="blog-details.html"><img src="" alt=""></a>
                                        </div>
                                        <div class="post_info">
                                            <h4><a href="blog-details.html"></a></h4>
                                            <span></span>
                                        </div>
                                    </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
