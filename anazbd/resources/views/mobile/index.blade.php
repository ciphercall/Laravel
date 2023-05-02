@extends('mobile.layouts.master')
@section('mobile')
    <!-- Hero Slides-->
    <div class="hero-slides owl-carousel">
        <!-- Single Hero Slide-->
        @include('mobile._include.slider')
    </div>

    @include('mobile._include.banner')

    {{--    mobile offers--}}
    @include('mobile._include.offer')

    <!-- Flash Sale Slide-->
    @include('mobile._include.flash')


    {{--mobile brands--}}
{{--    @include('mobile._include.brands')--}}

    <!-- Product Catagories-->
{{--    @include('mobile._include.category')--}}
    {{-- anazmall --}}
    @include('mobile._include.anazmall')
    {{-- anazmall --}}
    @include('mobile._include.premiumsellers')
    {{-- collections --}}
    @include('mobile._include.collections')

    {{-- sellercategory --}}
    {{-- @include('mobile._include.sellercategory') --}}

    <!-- just for you -->
    @include('mobile._include.justforyou')

    @push('script')
        <script>

            $(document).ready(function () {
                {{--let chkReg = localStorage.getItem('newReg');--}}
                {{--if (chkReg === 'yes') {--}}
                {{--    let url = "{{ url('/account') }}"--}}
                {{--    window.location.replace(url);--}}
                {{--}--}}
            });

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
        @include('mobile._include.loadMoreScript')
        @include('mobile.includes.product-script')
    @endpush
@endsection
