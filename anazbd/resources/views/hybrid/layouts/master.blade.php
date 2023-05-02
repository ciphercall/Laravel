<!DOCTYPE html>
<html lang="en">
<head>
    @include('hybrid._partial.header')


    @stack('css')
    <style>
        body{
            min-height: 650px;
            background-image: linear-gradient(to left, rgba(255,255,255,1) 0%, rgba(255,255,255,0.71) 70%),url(https://drive.google.com/uc?export=download&id=1UpgAKr0NjgROAFJQ0zPwt2-ynfFmjc6X);
        }
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
            background-color: #eceff1;}
        .ui-menu-item {
            border: 1px solid #eceff1;
            border-radius: 0.25rem;}
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


        .no-padding-margin{
            padding-right: 0px;
            padding-left: 0px;
        }
    </style>
    {{--  @if(config('app.env') != 'local')
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
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=153142429964530&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
        @endif  --}}
  </head>
  <body>
  {{--  <div class="anaz_loader" style="display: none;position: fixed;z-index: 999999;height: 100%;width: 100%;background-color: rgba(0,0,0,0.5);top: 0%;">
      <img style="position: relative;top: 34%;left: 22%;height: 32%;width: auto;" src="https://drive.google.com/uc?export=download&id=1W4VGWV4oXT9DPY_k8qLImkFyNZGcCqqb"
           alt="">
  </div>  --}}

  {{--  <div class="hidden">
    </div>  --}}
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
        @include('hybrid._partial.header_top')
    </div>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <div class="suha-sidenav-wrapper" id="sidenavWrapper">
      <!-- Sidenav Profile-->
      <!-- Sidenav Nav-->
        {{--  @include('hybrid._include.Sidenav_Nav')  --}}
      <!-- Go Back Button-->
      <br>
      <br>
      {{--  <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>  --}}
    </div>

    <div class="page-content-wrapper">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif
        @yield('mobile')
        
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Footer Nav-->
    {{--  @include('hybrid._partial.footer_stacky')  --}}
    <!-- All JavaScript Files-->
    @include('hybrid._partial.footer')

<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

@stack('script')
@stack('js')
  </body>

</html>

