@extends('frontend.layouts.master')

@section('title',"Oops...")
@section('content')
    <div class="row mt-5">
        <div class="col-lg-3"></div>
        <div class="col">
            <img style="height: 500px" src="{{ asset('frontend/assets/img/error/missing.svg') }}" alt="Server Error">
        </div>
        <div class="col-lg-3"></div>
    </div>
    <div class="row p-4">
        <span class="col text-center text-muted d-5">Session Expired. Please Reload.</span>
    </div>
@endsection

