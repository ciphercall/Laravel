@extends('frontend.layouts.master')

@section('title',"Oops...")
@section('content')
    <div class="row mt-5">
        <div class="col-lg-3"></div>
        <div class="col">
            <img class="img-fluid" style="height: 600px" src="{{ asset('frontend/assets/img/error/500.svg') }}" alt="Server Error">
        </div>
        <div class="col-lg-3"></div>
    </div>
    <div class="row p-4">
        <span class="col text-center text-muted d-5">Something went wrong. Please Try again later.</span>
    </div>
@endsection

