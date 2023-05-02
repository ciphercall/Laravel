@extends('mobile.layouts.master')
@push('css')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/ficon.png">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">--}}

    @livewireStyles
    <style>
        .increaseBtn{
            width: 29px;
            height: auto;
            border-radius: 50%;
            border: 0;
            box-shadow: 2px 3px 8px #888888;
        }
    </style>
@endpush
@section('mobile')
    <div class="cart_page_bg" style="padding: 12px 0px 0px 0px;">
        <div class="container">

            <div class="row">
                    @livewire('cart.cart-items')

                <div class="" style="padding-right: 0px;padding-left: 0px;">
                    @livewire('cart.cart-summery', ['class' => 'col-12'])
                </div>
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
{{--            }--}}
{{--        });--}}
    <script>
        window.addEventListener('update_cart_count',event => {
            $('.cart_count').html((event.detail.count).toString());
        });
    </script>
@endpush




