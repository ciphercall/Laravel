@if($sliders)
@foreach ($sliders as $slider)
    <a href="{{route('frontend.flash_sale')}}">
        <div class="single-hero-slide" style="background-image: url({{url($slider->image)}});background-repeat: no-repeat;background-size: 100% 100%;">
            <div class="slide-content h-100 d-flex align-items-center">
                <div class="container">
                    {{-- <h4 class="text-white mb-0" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Light Candle</h4> --}}
                    {{-- <p class="text-white" data-animation="fadeInUp" data-delay="400ms" data-wow-duration="1000ms">Now only $22</p><a class="btn btn-success btn-sm" href="#" data-animation="fadeInUp" data-delay="500ms" data-wow-duration="1000ms">Buy Now</a> --}}
                </div>
            </div>
        </div>
    </a>
@endforeach
@endif
