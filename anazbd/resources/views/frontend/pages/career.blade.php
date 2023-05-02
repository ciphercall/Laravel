@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Career
@endsection
@push('css')
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{asset('career/css/bootstrap.css')}}"/>

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

    <!-- font awesome style -->
    <link href="{{asset('career/css/font-awesome.min.css')}}" rel="stylesheet"/>
    <!-- nice select -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
          integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('career/css/style.css')}}" rel="stylesheet"/>
    <!-- responsive style -->
    <link href="{{asset('career/css/responsive.css')}}" rel="stylesheet"/>
    <style>
        .container {
            max-width: 100%;
        }
        .career_btn{
            display: inline-block;
            padding: 10px 45px;
            background-color: #e41a2b;
            color: #ffffff;
            border-radius: 5px;
            -webkit-transition: all .3s;
            -o-transition: all .3s;
            -moz-transition: all .3s;
            transition: all .3s;
            border: 1px solid #e41a2b;
            outline: none;
            text-transform: uppercase;
        }
        .career_btn:hover {
            display: inline-block;
            color: red;
            text-align: center;
            background-color: transparent;
            border: 1px solid red;
            border-radius: 0.25rem;
        }
    </style>
@endpush
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>Career</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--about bg area start-->
    <div class="hero_area" style="height: 50vh;">
        <!-- header section strats -->
    {{--         <header class="header_section">--}}
    {{--             <div class="container-fluid">--}}
    {{--             </div>--}}
    {{--         </header>--}}
    <!-- end header section -->
        <!-- slider section -->
        <section class="slider_section " style="height: inherit; padding: 0;">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-7 col-md-8 mx-auto">
                        <div class="detail-box">
                            <h1>
                                Build Your <br>
                                POWERFUL CAREER with <br> ANAZBD
                            </h1>
                            <p>
                                when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                normal
                                distribution of letters, as opposed to
                            </p>
                        </div>
                    </div>
                </div>
                <div class="find_container ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('frontend.career') }}">
                                    <div class="form-row ">
                                        <div class="form-group col-lg-2">

                                        </div>
                                        <div class="form-group col-lg-3">
                                            <input type="text" name="title" class="form-control" id="inputPatientName"
                                                   placeholder="Keywords">
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <select name="location" class="form-control wide" id="inputDoctorName">
                                                <option value="" selected>All Locations</option>
                                                @foreach ($divisions as $item)
                                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <div class="btn-box">
                                                <button type="submit" class="btn ">Submit Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div>
                                    <div class="btn-box">
                                        <div class="row">
                                            <div class="col-4">

                                            </div>
                                            <div class="col-4" style="text-align: center;">
                                                <a href="{{url('jobs/apply/form')}}">
                                                    <button type="submit" class="btn career_btn">Apply Now</button>
                                                </a>
                                            </div>
                                            <div class="col-4">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  <ul class="job_check_list">
                            <li class=" ">
                                <input id="checkbox_qu_01" type="checkbox" class="styled-checkbox">
                                <label for="checkbox_qu_01">
                                    Freelancer
                                </label>
                            </li>
                            <li class=" ">
                                <input id="checkbox_qu_02" type="checkbox" class="styled-checkbox">
                                <label for="checkbox_qu_02">
                                    Part Time
                                </label>
                            </li>
                            <li class=" ">
                                <input id="checkbox_qu_03" type="checkbox" class="styled-checkbox">
                                <label for="checkbox_qu_03">
                                    Full Time
                                </label>
                            </li>
                        </ul>  --}}
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider section -->
    </div>
    <!-- job section -->
    <section class="job_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    RECENT JOBS
                </h2>
            </div>
            {{--   <div class="job_container">
                 <h4 class="job_heading">
                     Featured Jobs
                 </h4>
                 <div class="row">
                     <div class="col-lg-6">
                         <div class="box">
                             <div class="job_content-box">
                                 <div class="img-box">
                                     <img src="{{asset('career/images/job_logo1.png')}}" alt="">
                                 </div>
                                 <div class="detail-box">
                                     <h5>
                                         Development Team Lead
                                     </h5>
                                     <div class="detail-info">
                                         <h6>
                                             <i class="fa fa-map-marker" aria-hidden="true"></i>
                                             <span>
                        Washington. D.C.
                      </span>
                                         </h6>
                                         <h6>
                                             <i class="fa fa-money" aria-hidden="true"></i>
                                             <span>
                        $1200 - $1300
                      </span>
                                         </h6>
                                     </div>
                                 </div>
                             </div>
                             <div class="option-box">
                                 <button class="fav-btn">
                                     <i class="fa fa-heart-o" aria-hidden="true"></i>
                                 </button>
                                 <a href="" class="apply-btn">
                                     Apply Now
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="box">
                             <div class="job_content-box">
                                 <div class="img-box">
                                     <img src="{{asset('career/images/job_logo2.png')}}" alt="">
                                 </div>
                                 <div class="detail-box">
                                     <h5>
                                         Make my website responsive device compatible
                                     </h5>
                                     <div class="detail-info">
                                         <h6>
                                             <i class="fa fa-map-marker" aria-hidden="true"></i>
                                             <span>
                        New York
                      </span>
                                         </h6>
                                         <h6>
                                             <i class="fa fa-money" aria-hidden="true"></i>
                                             <span>
                        $200 - $340
                      </span>
                                         </h6>
                                     </div>
                                 </div>
                             </div>
                             <div class="option-box">
                                 <button class="fav-btn">
                                     <i class="fa fa-heart-o" aria-hidden="true"></i>
                                 </button>
                                 <a href="" class="apply-btn">
                                     Apply Now
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>  --}}
            <div class="job_container">
                <h4 class="job_heading">
                    Recent Openings
                </h4>
                <div class="row">
                    @forelse ($jobs as $job)
                        <div class="col-lg-6">
                            <div class="box">
                                <div class="job_content-box">
                                    <div class="img-box">
                                        <img src="{{asset('frontend/assets/anazlogo.png')}}" alt="">
                                    </div>
                                    <div class="detail-box">
                                        <h5>
                                            Looking for {{ $job->title }}
                                        </h5>
                                        <div class="detail-info">
                                            <h6>
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                <span>{{ $job->location }}</span>
                                            </h6>
                                            <h6>
                                                <i class="fa fa-money" aria-hidden="true"></i>
                                                <span>{{ $job->salary }}</span>
                                            </h6>
                                            <h6>
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                <span>{{ $job->deadline->format('d M Y') }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-box">

                                    <a href="{{ route('frontend.career.apply',$job->slug) }}" class="apply-btn">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <div class="box">
                                <div class="job_content-box m-auto">
                                    <h3>Currently no circular available.</h3>
                                </div>
                                {{--  <div class="option-box">
                                    <button class="fav-btn">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </button>
                                    <a href="" class="apply-btn">
                                        Apply Now
                                    </a>
                                </div>  --}}
                            </div>
                        </div>
                    @endforelse


                </div>
                <div class="btn-box">
                    @if ($jobs->hasMorePages())
                        <a href="{{ $jobs->nextPageUrl() }}">
                            View More
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- about section -->

    <section class="about_section layout_padding" style="padding: 30px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="heading_container">
                            <h2>
                                About Us
                            </h2>
                        </div>
                        <p>
                            Normal distribution of letters, as opposed to using 'Content here, content here', making it
                            look like
                            readable English. Many desktop publishing packages and web page editors has a more-or-less
                            normal
                            distribution of letters, as opposed to using 'Content here, content here', making it look
                            like readable
                            English. Many desktop publishing packages and web page editors
                        </p>
                        <a href="">
                            Read More
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-box">
                        <img src="{{asset('career/images/about-img.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->


    <!-- category section -->
    <section class="category_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                    <a href="#" class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/c1.png')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Web Design
                            </h5>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                    <a href="#" class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/c2.png')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Web Development
                            </h5>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                    <a href="#" class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/c3.png')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Graphic Design
                            </h5>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                    <a href="#" class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/c4.png')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Seo marketing
                            </h5>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                    <a href="#" class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/c5.png')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Accounting
                            </h5>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-2 px-0">
                    <a href="#" class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/c6.png')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                Content Writing
                            </h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- end category section -->


    <!-- end job section -->

    <!-- expert section -->

    {{--  <section class="expert_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    LOOKING FOR EXPERTS?
                </h2>
                <p>
                    Lorem ipsum dolor sit amet, non odio tincidunt ut ante, lorem a euismod suspendisse vel, sed quam nulla mauris
                    iaculis. Erat eget vitae malesuada, tortor tincidunt porta lorem lectus.
                </p>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 mx-auto">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/e1.jpg')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <a href="">
                                Martin Anderson
                            </a>
                            <h6 class="expert_position">
               <span>
                 Web Anaylzer
               </span>
                                <span>
                 41 Jobs Done
               </span>
                            </h6>
                            <span class="expert_rating">
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
             </span>
                            <p>
                                Lorem ipsum dolor sit amet, non odio tincidunt ut ante, lorem a euismod suspendisse vel, sed quam
                                nulla
                                mauris iaculis.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mx-auto">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/e2.jpg')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <a href="">
                                Semanta Klores
                            </a>
                            <h6 class="expert_position">
               <span>
                 Graphic Designer
               </span>
                                <span>
                 32 Jobs Done
               </span>
                            </h6>
                            <span class="expert_rating">
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
             </span>
                            <p>
                                Lorem ipsum dolor sit amet, non odio tincidunt ut ante, lorem a euismod suspendisse vel, sed quam
                                nulla
                                mauris iaculis.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mx-auto">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{asset('career/images/e3.jpg')}}" alt="">
                        </div>
                        <div class="detail-box">
                            <a href="">
                                Ryan Martines
                            </a>
                            <h6 class="expert_position">
               <span>
                 SEO Expert
               </span>
                                <span>
                 27 Jobs Done
               </span>
                            </h6>
                            <span class="expert_rating">
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
             </span>
                            <p>
                                Lorem ipsum dolor sit amet, non odio tincidunt ut ante, lorem a euismod suspendisse vel, sed quam
                                nulla
                                mauris iaculis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-box">
                <a href="">
                    View All Freelancers
                </a>
            </div>
        </div>
    </section>  --}}

    <!-- end expert section -->


    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"
            integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ=="
            crossorigin="anonymous"></script>  <!-- bootstrap js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha512-Ah5hWYPzDsVHf9i2EejFBFrG2ZAPmpu4ZJtW4MfSgpZacn+M9QHDt+Hd/wL1tEkk1UgbzqepJr6KnhZjFKB+0A=="
            crossorigin="anonymous"></script>  <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
            integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
    <!-- custom js -->
    <script>
        $(document).ready(function () {
            $('select').niceSelect();
        });
    </script>

@endsection
