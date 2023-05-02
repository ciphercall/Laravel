<!doctype html>
<html class="no-js" lang="en">

{{--  @if((new \Jenssegers\Agent\Agent())->isDesktop())  --}}


    <head>
        @include('frontend/include/header')
        @stack('css')
        <style>
            /* body .ui-autocomplete .ui-menu-item .ui-corner-all {
                background-color: white;
            } */
            /* .ui-menu-item .ui-menu-item-wrapper:hover
            {
                border: none !important;
                background-color: white;
            } */
            .ui-autocomplete {
                width: 100px;
                border-radius: 0.25rem;
                background-color: #eceff1;
            }

            .ui-menu-item {
                border: 1px solid #eceff1;
                border-radius: 0.25rem;
            }

            .ui-state-active,
            .ui-widget-content .ui-state-active,
            .ui-widget-header .ui-state-active,
            a.ui-button:active,
            .ui-button:active,
            .ui-button.ui-state-active:hover {
                background-color: #eceff1;
                border-color: #eceff1;
                color: #0d47a1;
            }


            .no-padding-margin {
                padding-right: 0px;
                padding-left: 0px;
            }

            #searchRes div.row:hover {
                background: linear-gradient(to right, rgba(255, 175, 75, 0.57) 0%, rgba(10, 247, 255, 0.55) 100%);
            }

            #searchResSticky div.row:hover {
                background: linear-gradient(to right, rgba(255, 175, 75, 0.57) 0%, rgba(10, 247, 255, 0.55) 100%);
            }

            html, body {
                margin:0;
                padding:0;
                width:100%;
                height:100%;
                overflow: auto;
            }
        </style>
        @if(config('app.env') != 'local')
        <!-- Facebook Pixel Code -->
            <script>
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                    n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s)}(window, document,'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '153142429964530');
                fbq('track', 'PageView');
            </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=153142429964530&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Facebook Pixel Code -->
        @endif
    </head>

    <body>
    <div class="anaz_loader" style="display: none;position: absolute;z-index: 999999;height: 100%;width: 100%;background-color: rgba(0,0,0,0.5);">
        <img style="position: relative;top: 34%;left: 44%;" src="https://drive.google.com/uc?export=download&id=1W4VGWV4oXT9DPY_k8qLImkFyNZGcCqqb"
             alt="">
    </div>

    <!--header area start-->
    <header>

        @include('frontend.include.header_top')

    </header>
    <!--header area end-->

    @yield('content')

    <!--footer area start-->

<!--footer area start-->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            xfbml: true,
            version: 'v9.0'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat"
     attribution=install_email
     page_id="105379738047674">
</div>

@include('frontend.include.footer')
@stack('js')

<script>
    $(document).ready(function () {
        // $(document).on('click', function (event) {
        //     alert(event.target.id);
        // });

        {{--var loggedIn = localStorage.getItem('order_redirect');--}}
        {{--if (loggedIn === 'true') {--}}
        {{--    localStorage.setItem('order_redirect', 'false');--}}
        {{--    location.replace(`{{url('/')}}` + `/upload-and-order`);--}}
        {{--}--}}

        var chkNewReg = localStorage.getItem('newReg');
        if (chkNewReg === 'yes') {
            $('#logOutOpt').hide();
        }

        $(document).on('focusout', "#searchbox", function () {
            $("#searchRes").fadeOut();
        });
        $(document).on('focusout', "#searchboxSticky", function () {
            $("#searchRes").fadeOut();
        });


        $(document).on('keyup', "#searchbox", function () {
            var boxVal = $("#searchbox").val();
            if (boxVal === null || boxVal === "") {
                $("#searchRes").fadeOut();
            }
            $.ajax({
                method: 'POST',
                url: "{{ route('search.autocomplete') }}",
                data: {
                    search: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    let html = "";
                    $.each(data, function (index, data) {
                        let url = "{{ url('/search') }}/?search=" + data.name;
                        let row = "<a href='" + url + "'><div class='row'><div class='col-12'>" + data.name + "</div></div></a>";
                        html += row;
                    });
                    $("#searchRes").html(html);
                    $("#searchRes").fadeIn();
                }
            });
        });

        $(document).on('keyup', "#searchboxSticky", function () {
            var boxValSticky = $("#searchResSticky").val();
            if (boxValSticky === null || boxValSticky === "") {
                $("#searchResSticky").fadeOut();
            }
            if ($(this).val().length >= 2) {
                $.ajax({
                    method: 'POST',
                    url: "{{ route('search.autocomplete') }}",
                    data: {
                        search: $(this).val()
                    },
                    dataType: "json",
                    success: function (data) {
                        let html = "";
                        $.each(data, function (index, data) {
                            let url = "{{ url('/search') }}/?search=" + data.name;
                            let row = "<a href='" + url + "'><div class='row'><div class='col-12'>" + data.name + "</div></div></a>";
                            html += row;
                        });
                        $("#searchResSticky").html(html);
                        $("#searchResSticky").fadeIn();
                    }
                });
            }
        });
    });
</script>
{{-- @else
    @include('mobile.index') --}}
{{--  @endif  --}}
</body>

</html>
