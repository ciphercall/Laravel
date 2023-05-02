<meta charset="utf-8">
@php
    $version = config()->get('version');
@endphp

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Anaz -@yield('title')</title>
    <meta name="name" content="{{ $info->meta_key??' ' }}">
    <meta name="description" content="{{ $info->meta_desc??' ' }}"/>

    <meta property="og:url" content="anazbd.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $info->meta_key??' ' }}" />
    <meta property="og:description" content="{{ $info->meta_desc??' ' }}" />
    <meta property="fb:app_id" content="170436711490488" />
    <meta property="og:image" content="{{asset('frontend/assets/anazcom-2.png')}}">
    <meta property="og:image:url" content="{{asset('frontend/assets/anazcom-2.png')}}">
    <meta property="og:image:type" content="image/png">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" content="{{csrf_token()}}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/ficon.png">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css').'?v='.$version }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css').'?v='.$version }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style2.css').'?v='.$version }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css').'?v='.$version }}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/themes/metroui.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/noty.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css').'?v='.$version}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
      crossorigin="anonymous"/>
    @notifyCss
