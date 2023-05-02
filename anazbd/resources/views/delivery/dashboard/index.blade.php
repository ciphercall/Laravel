@extends('delivery.layouts.master')
@section('page-header')
    <i class="fa fa-home"></i> Dashboard
@endsection
@section('title', 'Home')

@section('content')
    {{--  Heading  --}}
    <div class="page-header">
        <h1>
            @yield('page-header')
        </h1>
    </div>

    {{--  Content  --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                Delivery Dashboard
            </div>
        </div>
    </div>
@endsection
