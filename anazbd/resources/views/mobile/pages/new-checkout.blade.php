@extends('mobile.layouts.master')
@section('title')
    Checkout
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @livewireStyles
@endpush
@section('mobile')
    <!--Checkout page section-->
    <div class="checkout_page_bg">
        <div class="container">
            <div class="Checkout_section">
                <div class="checkout_form">

                    <div class="row">
                        <div class="col-12">
                            @livewire('address.create')
                        </div>
                    </div>
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
            }
        });
        window.addEventListener('redirectHome', event => {
            window.location.href = "{{ url('/') }}"
        });
    </script>
@endpush
