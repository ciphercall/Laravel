@extends('mobile.layouts.master')
@section('mobile')
    @if(isset($items))
        @include('mobile._include.products')
    @endif
@endsection
@push('script')
<script>

    $(window).on('scroll',loader)
    $(window).on('touchmove',loader)

    function loader(){
        if (Math.round($(window).scrollTop() + window.innerHeight) >= $(document).height()) {
            let data = {
                "_token": "{{ csrf_token() }}",
                "type": "discounts",
            }
            loadMoreProducts(data)
        }
    }


</script>
@include('mobile._include.loadMoreScript')
@include('mobile.includes.product-script')
@endpush

