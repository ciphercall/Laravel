<script src="{{asset('mobile/js/jquery.min.js')}}"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js'></script>
{{--  <script src="{{asset('SlideToUnlock/js/slidetounlock.js')}}"></script>  --}}
<script src="{{asset('mobile/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('mobile/js/waypoints.min.js')}}"></script>
    <script src="{{asset('mobile/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('mobile/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('mobile/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('mobile/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('mobile/js/default/jquery.passwordstrength.js')}}"></script>
    <script src="{{asset('mobile/js/wow.min.js')}}"></script>
    <script src="{{asset('mobile/js/jarallax.min.js')}}"></script>
    <script src="{{asset('mobile/js/jarallax-video.min.js')}}"></script>
    <script src="{{asset('mobile/js/default/dark-mode-switch.js')}}"></script>
    <script src="{{asset('mobile/js/default/no-internet.js')}}"></script>
    <script src="{{asset('mobile/js/default/active.js')}}"></script>
    <script src="{{asset('mobile/js/pwa.js')}}"></script>
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

