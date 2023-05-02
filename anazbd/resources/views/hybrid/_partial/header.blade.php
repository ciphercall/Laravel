<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Anaz -@yield('title')</title>
<meta name="name" content="{{ $info->meta_key??' ' }}">
<meta name="description" content="{{ $info->meta_desc??' ' }}"/>
<meta name="token" content="{{csrf_token()}}">
    <!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/ficon.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Stylesheet-->
<link rel="stylesheet" href="{{asset('mobile/style.css')}}">
{{--<link rel="stylesheet" href="{{asset('mobile/style.css')}}">--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

{{--<!-- Plugins CSS -->--}}
{{--<link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css')}}">--}}

{{--<!-- Main Style CSS -->--}}
{{--<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">--}}
{{--<link rel="stylesheet" href="{{ asset('frontend/assets/css/style2.css')}}">--}}
{{--<link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css')}}">--}}
{{--<link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/themes/metroui.css')}}">--}}
{{--<link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/noty.css')}}">--}}
{{--<link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css')}}">--}}
{{--@notifyCss--}}
