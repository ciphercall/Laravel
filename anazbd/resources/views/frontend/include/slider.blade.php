<div class="slider_area slider3_carousel owl-carousel" style="width: 1002px;">
{{--     @dd($sliders) --}}
               @forelse ($sliders as $slider)
               <a class="stretched-link" href="{{ $slider->slug != "" ? $slider->slug : '#' }}">
{{--                <div class="single_slider d-flex align-items-center" data-bgimg="{{ asset($slider->image) }}"></div>--}}
                   <img class="single_slider d-flex align-items-center" data-bgimg="{{ asset($slider->image) }}" src="{{ asset($slider->image) }}" alt=""/>
                </a>
               @empty
{{--                <div class="single_slider d-flex align-items-center" data-bgimg="{{ asset('frontend') }}/assets/img/slider/slider17.jpg">--}}

{{--                </div>--}}
{{--                <div class="single_slider d-flex align-items-center" data-bgimg="{{ asset('frontend') }}/assets/img/slider/slider18.jpg">--}}

{{--                </div>--}}
                    <img class="single_slider d-flex align-items-center" data-bgimg="{{ asset('frontend') }}/assets/img/slider/slider17.jpg" src="{{ asset('frontend') }}/assets/img/slider/slider17.jpg" alt=""/>
                    <img class="single_slider d-flex align-items-center" data-bgimg="{{ asset('frontend') }}/assets/img/slider/slider18.jpg" src="{{ asset('frontend') }}/assets/img/slider/slider18.jpg" alt=""/>

                @endforelse



{{--    @for($i = 0;$i<count($sliders); $i++)--}}
{{--    <a class="stretched-link" href="{{ $sliders[$i]->slug != "" ? $sliders[$i]->slug : '#' }}">--}}
{{--        <img id='activeImg{{$i}}' class="single_slider d-flex align-items-center" data-bgimg="{{ asset($sliders[$i]->image) }}"--}}
{{--             src="{{ asset($sliders[$i]->image) }}" alt=""/>--}}
{{--    </a>--}}


{{--    @endfor--}}

</div>
