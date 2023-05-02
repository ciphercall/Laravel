<footer class="footer-first">
    <div class="container padding">
        <div class="row text-center mt-3">
            <div class="col-md-2 p-2 footerlist">
                <h4>Customer care</h4>
                <ul>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                        @forelse(collect($quickpages ?? '')->where('section',1) as $quickpage)
                            <li><a href="{{ route('frontend.quickpage',$quickpage->slug) }}">{{ $quickpage->name }}</a></li>
                        @empty
                    @endforelse
                </ul>
            </div>
            <div class="col-md-2 p-2 footerlist">
                <h4>Anaz</h4>
                <ul>
                    @forelse(collect($quickpages ?? '')->where('section',2) as $quickpage)
                        <li><a href="{{ route('frontend.quickpage',$quickpage->slug) }}">{{ $quickpage->name }}</a></li>
                    @empty
                    @endforelse
                </ul>

            </div>

            <div class="col-md-2 p-2 footerlist">
                <h4>Earn With Anaz </h4>
                <ul>
                    @forelse(collect($quickpages ?? '')->where('section',3) as $quickpage)
                        <li><a href="{{ route('frontend.quickpage',$quickpage->slug) }}">{{ $quickpage->name }}</a></li>
                    @empty
                    @endforelse

                </ul>
            </div>


            <div class="col-md-6">
                <div class="row text-center padding">
                    <div class="col-md-4">
                        <img src="{{ asset('frontend') }}/assets/img/ssl-payment-qr.png" style=" width: 100%;">
                    </div>
                    <div class="col-md-6 ">
                        <img class="mt-2" src="{{ asset('frontend') }}/assets/img/downloadapp.png">
                        <div class="footer_social">
                            <ul>
                                {{-- @dd($socialLinks); --}}
                                <li><a class="facebook" href="{{ optional($socialLinks)->facebook }}" target="_blank"><i
                                            class="fab fa-facebook"></i></a></li>
                                <li><a class="twitter" href="{{ optional($socialLinks)->twitter }}" target="_blank"><i
                                            class="fab fa-twitter"></i></a></li>
                                <li><a class="instagram" href="{{ optional($socialLinks)->instagram }}" target="_blank"><i
                                            class="fab fa-instagram"></i></a></li>
                                <li><a class="linkedin" href="{{ optional($socialLinks)->youtube  }}" target="_blank"><i
                                            class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row padding">
            <div class="col-md-12 text-center">
                <img src="{{ asset('frontend') }}/assets/img/SSLCommerz.png" style="width: 100%;max-width: 100%;height: auto;">

            </div>
        </div>
    </div>
</footer>
<hr>
{{--  <footer class="footer-second">
    <div class="container padding">
        <div class="row padding p-3">
            <div class="col-md-12 mb-2">
                <p> {!! optional($info)->short_desc !!} </p>
                <p><strong>&copy;</strong> Copyright 2020, ANAZBD.COM. All rights reserved.</p>

            </div>
        </div>
    </div>
</footer>  --}}

<!--footer area end-->


<!-- JS -->

<!-- Plugins JS -->
<script src="{{ asset('frontend/assets/js/plugins.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>


<!-- Main JS -->
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>
<script src="{{asset('frontend/assets/lib/noty/noty.min.js')}}"></script>

<script>
    XMLHttpRequest.prototype.origOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function () {
        this.origOpen.apply(this, arguments);
        this.setRequestHeader('X-CSRF-TOKEN', $('meta[name=token]').attr("content"));
    };

    @if(session()->has('success'))
    new Noty({
        theme: 'metroui',
        timeout: 3000,
        type: 'success',
        layout: 'topRight',
        text: '{{session()->get('success')}}'
    }).show();
    @elseif(session()->has('error'))
    new Noty({
        theme: 'metroui',
        timeout: 3000,
        type: 'error',
        layout: 'topRight',
        text: '{{session()->get('error')}}'
    }).show();
    @elseif(session()->has('warning'))
    new Noty({
        theme: 'metroui',
        timeout: 3000,
        type: 'warning',
        layout: 'topRight',
        text: '{{session()->get('warning')}}'
    }).show();
    @endif
</script>
@include('notify::messages')
@notifyJs

@php
    session()->forget('quickpages');
    session()->forget('socialLinks');
    session()->forget('info');
@endphp
<!-- ================================= jquery-zoom-in and out========= -->
