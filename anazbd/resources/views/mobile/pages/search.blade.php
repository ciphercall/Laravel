@extends('mobile.layouts.master')
@section('title')
    searching : {{ $query }}
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"
            integrity="sha512-pXR0JHbYm9+EGib6xR/w+uYs/u2V84ofPrBpkgLYyKvhZYJtUUvKSy1pgi8tJZAacsPwgf1kbhI4zwgu8OKOqA=="
            crossorigin="anonymous"></script>
@endpush
@section('mobile')
<div class="top-products-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between">
        <h6 class="ml-1">You are searching : {{ $query }}</h6>
            <!-- Layout Options-->
            {{-- <div class="layout-options"> --}}
                {{-- <a class="active" href=""> --}}
                    {{-- <i class="lni lni-grid-alt"></i></a><a href=""> --}}
                    {{-- <i class="lni lni-radio-button"></i></a> --}}
            {{-- </div> --}}
        </div>
        @include('mobile._include.products')
    </div>
</div>

@endsection
@push('script')
{{--    @include('frontend.include.product-script')--}}
    @include('mobile.includes.product-script')

    <script>


        let currentPage = "{{ $items->currentPage() }}";
        let lastPage = "{{ $items->lastPage() }}";
        let url2 = "{{ url('/') }}/search?page=";
        let nextPage = parseInt(currentPage) + 1;






        $(window).on('scroll', loader);
        $(window).on('touchmove', loader);

        function loader() {
            if (Math.round($(window).scrollTop() + window.innerHeight) >= $(document).height()) {
                console.log('product fetching')
                let data = {
                    "_token": "{{ csrf_token() }}"
                }
                loadMoreProducts(data);
            }
        }


    </script>
    @include('mobile._include.loadMoreMobileScript')
    {{--  @include('mobile.includes.product-script')  --}}

@endpush
