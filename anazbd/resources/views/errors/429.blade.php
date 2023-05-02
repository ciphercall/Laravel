@extends('frontend.layouts.master')

@section('title',"Oops...")
@section('content')
    <div class="row mt-5">
        <div class="col-lg-3"></div>
        <div class="col">
            <img style="height: 500px" src="{{ asset('frontend/assets/img/error/unauthorized.svg') }}" alt="Server Error">
        </div>
        <div class="col-lg-3"></div>
    </div>
    <div class="row p-4">
        <span class="col text-center text-muted d-5">Too Many Requests. Try again later.</span>
    </div>
@endsection

