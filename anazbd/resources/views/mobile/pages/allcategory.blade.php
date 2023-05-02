@extends('mobile.layouts.master')
@section('mobile')
<div class="top-products-area py-3">
    <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="ml-1">All Products of - {{ $category->name }}</h6>
            <!-- Layout Options-->
            <div class="layout-options">
                <a class="active" href=""><i class="lni lni-grid-alt"></i></a><a href=""><i class="lni lni-radio-button"></i></a>
            </div>
        </div>
        @if(isset($items))
        @include('mobile._include.products')
    @endif

    </div>
{{-- <strong>{{ $items->links() }}</strong> --}}
    {{-- @include('frontend.include.paginate', ['data' => $items]) --}}
</div>
@push('script')
<script>

    $(window).on('scroll',loader)
    $(window).on('touchmove',loader)

    function loader(){
        if (Math.round($(window).scrollTop() + window.innerHeight) >= $(document).height()) {
            let data = {
                "_token":"{{ csrf_token() }}",
                'type':"category",
                "slug":"{{ $category->slug }}"
            }
            loadMoreProducts(data)
        }
    }


</script>
@include('mobile._include.loadMoreScript')
@include('mobile.includes.product-script')
@endpush
@endsection
