@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Order History
@endsection
@push('css')
    <style>
      /* The actual timeline (the vertical ruler) */
.timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
    content: '';
    position: absolute;
    width: 3px;
    background-color: #948e8e42;
    top: 0;
    bottom: 0;
    /* left: 50%; */
    margin-left: -3px;
}

/* container-timeline around content */
.container-timeline {
  padding: 10px 40px;
  position: relative;
  background-color: inherit;
  width: 100%;
}

/* The circles on the timeline */
.container-timeline::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    /* right: -17px; */
    background-color: white;
    border: 4px solid #FF9F55;
    top: 0px;
    border-radius: 50%;
    z-index: 1;
}

/* Place the container-timeline to the left */
.left {
  left: 0;
}


/* Add arrows to the left container-timeline (pointing right) */
.left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container-timeline (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent #f9f8f8 transparent transparent;
}

/* Fix the circle for container-timelines on the right side */
.right::after {
  left: -13px;
}

/* The actual content */
.content {
    padding: 10px 30px;
    background-color: #c9c2c21c;
    position: relative;
    border-radius: 10px;
}
html {
  -webkit-font-smoothing: antialiased!important;
  -moz-osx-font-smoothing: grayscale!important;
  -ms-font-smoothing: antialiased!important;
}
body {
  font-family: 'Open Sans', sans-serif;
  font-size:16px;
  color:#555555;
}
.md-stepper-horizontal {
  display:table;
  width:100%;
  margin:0 auto;
  background-color:#FFFFFF;
  box-shadow: 0 3px 8px -6px rgba(0,0,0,.50);
}
.md-stepper-horizontal .md-step {
  display:table-cell;
  position:relative;
  padding:24px;
}
.md-stepper-horizontal .md-step:hover .md-step-circle {
  background-color:#757575;
}
.md-stepper-horizontal .md-step:first-child .md-step-bar-left,
.md-stepper-horizontal .md-step:last-child .md-step-bar-right {
  display:none;
}
.md-stepper-horizontal .md-step .md-step-circle {
  width:30px;
  height:30px;
  margin:0 auto;
  background-color:#999999;
  border-radius: 50%;
  text-align: center;
  line-height:30px;
  font-size: 16px;
  font-weight: 600;
  color:#FFFFFF;
}
.md-stepper-horizontal.green .md-step.active .md-step-circle {
  background-color:#00AE4D;
}
.md-stepper-horizontal.orange .md-step.active .md-step-circle {
  background-color:#F96302;
}
.md-stepper-horizontal .md-step.active .md-step-circle {
  background-color: rgb(33,150,243);
}
.md-stepper-horizontal .md-step.done .md-step-circle:before {
  font-family:'FontAwesome';
  font-weight:100;
  content: "\f00c";
}
.md-stepper-horizontal .md-step.done .md-step-circle *,
.md-stepper-horizontal .md-step.editable .md-step-circle * {
  display:none;
}
.md-stepper-horizontal .md-step.editable .md-step-circle {
  -moz-transform: scaleX(-1);
  -o-transform: scaleX(-1);
  -webkit-transform: scaleX(-1);
  transform: scaleX(-1);
}
.md-stepper-horizontal .md-step.editable .md-step-circle:before {
  font-family:'FontAwesome';
  font-weight:100;
  content: "\f040";
}
.md-stepper-horizontal .md-step .md-step-title {
  margin-top:16px;
  font-size:16px;
  font-weight:600;
}
.md-stepper-horizontal .md-step .md-step-title,
.md-stepper-horizontal .md-step .md-step-optional {
  text-align: center;
  color:rgba(0,0,0,.26);
}
.md-stepper-horizontal .md-step.active .md-step-title {
  font-weight: 600;
  color:rgba(0,0,0,.87);
}
.md-stepper-horizontal .md-step.active.done .md-step-title,
.md-stepper-horizontal .md-step.active.editable .md-step-title {
  font-weight:600;
}
.md-stepper-horizontal .md-step .md-step-optional {
  font-size:12px;
}
.md-stepper-horizontal .md-step.active .md-step-optional {
  color:rgba(0,0,0,.54);
}
.md-stepper-horizontal .md-step .md-step-bar-left,
.md-stepper-horizontal .md-step .md-step-bar-right {
  position:absolute;
  top:36px;
  height:1px;
  border-top:1px solid #DDDDDD;
}
.md-stepper-horizontal .md-step .md-step-bar-right {
  right:0;
  left:50%;
  margin-left:20px;
}
.md-stepper-horizontal .md-step .md-step-bar-left {
  left:0;
  right:50%;
  margin-right:20px;
}
i{
    color:#f96302;
    font-size:18px;
  }
.fa-check{
    color: white;
}
.fa-search{
    color: white;
}
/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  left: 31px;
  }

  /* Full-width container-timelines */
  .container-timeline {
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }

  /* Make sure that all arrows are pointing leftwards */
  .container-timeline::before {
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
  left: 15px;
  }

  /* Make all right container-timelines behave like the left ones */
  .right {
  left: 0%;
  }
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
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>My Order History</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    @php
       $histories = App\Models\OrderHistory::where('order_id',$order->id)->orderBy('time')->get();
    @endphp

    <div class="container">
        <div class="row">
           <div class="col-md-6">
                <p style="font-weight: bold">Order No : {{ $order->no }}</p>
           </div>
           <div class="col-md-6" >
           {{-- <p style="font-weight: bold;float: right;">{{ $histories->take(1)->created_at->format('Y-m-d') }}</p> --}}
           </div>
        </div>

            <div class="row">
                <div class="col-md-12">
                    {{-- @foreach ($histories as $key => $history) --}}
                    <div class="md-stepper-horizontal orange">
                        @foreach ($histories as $key => $history)
                            <div class="md-step active">
                                <div class="md-step-circle">
                                    <span>
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </span>
                                </div>
                            <div class="md-step-title">{{ $history->type }}</div>
                                <div class="md-step-bar-left"></div>
                                <div class="md-step-bar-right"></div>
                            </div>

                        @endforeach
                    </div>

                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-6">
                    <p style="text-transform: uppercase; font-weight: bold; margin-top: 2%;">Order TimeLine</p>
                </div>
                <div class="col-md-6">
                    <button style="border: 0; float: right; margin-top: 2%;">Confirm Delivery</button>
                </div>
            </div>
            @foreach ($histories as $history)
                <div class="row">
                    <div class="col-md-2">
                        <h4 style="float: right;"> {{ Carbon\Carbon::parse($history->time)->format('Y-m-d') }} <br>
                            {{ Carbon\Carbon::parse($history->time)->format('H : i a') }}
                        </h4>
                    </div>

                    <div class="col-md-10">
                        <div class="timeline">
                            <div class="container-timeline right">
                                <div class="content">
                                    <h4>Order {{ $history->type }} </h4>
                                    <p>Your Order {{ $history->type }} Successfully.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
     </div>
@endsection
