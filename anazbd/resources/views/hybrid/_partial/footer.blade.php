<script src="{{asset('mobile/js/jquery.min.js')}}"></script>
<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js'></script>
{{--  <script src="{{asset('SlideToUnlock/js/slidetounlock.js')}}"></script>  --}}
<script src="{{asset('mobile/js/bootstrap.bundle.min.js')}}"></script>
    {{--  <script src="{{asset('mobile/js/waypoints.min.js')}}"></script>
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
    <script src="{{asset('frontend/assets/lib/noty/noty.min.js')}}"></script>  --}}
    <script>
        XMLHttpRequest.prototype.origOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function () {
            this.origOpen.apply(this, arguments);
            this.setRequestHeader('X-CSRF-TOKEN', $('meta[name=token]').attr("content"));
        };
        </script>
        {{--  @include('notify::messages')
        @notifyJs  --}}

