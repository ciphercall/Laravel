@extends('mobile.layouts.master')
@section('mobile')
    <!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css').'?v='.(config()->get('version'))}}">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Float four columns side by side */
        .column {
            float: left;
            width: 50%;
            padding: 0 10px;
        }

        /* Remove extra left and right margins, due to padding */
        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive columns */
        @media screen and (max-width: 389px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 4px;
            }
        }

        @media screen and (max-width: 800px) and (min-width: 390px) {
            .column {
                width: 50%;
                display: block;
                margin-bottom: 4px;
            }
        }

        @media screen and (max-width: 800px) and (min-width: 541px) {
            .column {
                width: 33%;
                display: block;
                margin-bottom: 4px;
            }
        }


        @media screen and (min-width: 759px) {
            .column {
                width: 25%;
                display: block;
                margin-bottom: 4px;
            }
        }

        /* Style the counter cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
        }

        a.card {
            margin: 0 !important;
            min-width: 100%;
            /*max-width: 205px;*/
            min-height: 100%;
            /*max-height: 350px;*/
            display: inline-block;
            transition: all 0s;
            border-radius: 5px;
            align-self: start;
        }

        a.card .card-img-top {
            max-width: 86px !important;
            max-height: 194px !important;
            min-height: 100px !important;
        }
    </style>
</head>
<body>
@if(isset($collections))
    <div class="row" style="--bs-gutter-y: 15px;">
        @foreach($collections->chunk(6) as $chunk)
            @forelse($chunk as $col)
                {{--                @dd($col)--}}
                <div class="column">
                    <a href="{{route("frontend.collection",$col->slug)}}" class="card">
                        <div class="card-img-overlay"></div>
                        <img class="card-img-top"
                             src="{{ asset($col->cover_photo) }}"
                             alt="{{ ($col->cover_photo) }}">
                        <div class="card-body">
                            <div style="font-size: 21px;" class="card-title-h1">{{$col->slug}}</div>
                            <p class="card-content-p" style="color: red;font-size: 18px;}">{{$col->items_count}} Products</p>
                        </div>
                    </a>
                </div>
    @empty
    @endforelse
    @endforeach
@endif
</body>
</html>
@endsection
