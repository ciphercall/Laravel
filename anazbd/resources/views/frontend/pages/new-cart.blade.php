@extends('frontend.layouts.master')
@section('title')
    Cart
@endsection
@push('css')
<link rel="stylesheet" href="{{asset('frontend/assets/css/cart.css').'?v='.config()->get('version')}}">
<link rel="stylesheet" href="{{asset('frontend/assets/css/cart-summary.css').'?v='.config()->get('version')}}">
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">--}}
    @livewireStyles
@endpush
@section('content')
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart_page_bg">
        <div class="container">
            <div class="row">
                @livewire('cart.cart-items')
                @livewire('cart.cart-summery',['class' => 'col-4'])
            </div>
        </div>
    </div>
@endsection
@push('js')
    @livewireScripts
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}

{{--    <script>--}}
{{--        window.addEventListener('alert', event => {--}}
{{--            toastr[event.detail.type](event.detail.message,event.detail.title ?? '');--}}
{{--            toastr.options = {--}}
{{--                "closeButton": true,--}}
{{--                "progressBar": true,--}}
{{--                'closeDuration': 300--}}
{{--            }--}}
{{--        });--}}
    <script>
        window.addEventListener('update_cart_count',event => {
            $('.cart_count').html((event.detail.count).toString());
        });

    </script>
@endpush
