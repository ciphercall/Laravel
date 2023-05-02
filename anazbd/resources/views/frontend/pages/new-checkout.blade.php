@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Checkout
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @livewireStyles
@endpush
@section('content')
    @include('frontend.loader.az-loader')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--Checkout page section-->
    <div class="checkout_page_bg">
        <div class="container">

            <div class="Checkout_section">
                <div class="checkout_form">
                    @livewire('address.create')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        window.addEventListener('alert', event => {
            toastr[event.detail.type](event.detail.message,event.detail.title ?? '');
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                'closeDuration': 300
            }
        });

        window.addEventListener('addressUpdated', event => {
            toastr[event.detail.type](event.detail.message,event.detail.title ?? '');
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
            }
        });

        window.addEventListener('redirectHome', event => {
            window.location.href = "{{ url('/') }}"
        });
    </script>
@endpush
