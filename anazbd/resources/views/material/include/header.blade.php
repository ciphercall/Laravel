    <meta charset="utf-8" />
    {{--  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material/assets/img/apple-icon.png') }}">  --}}
      <link rel="icon" type="image/png" href="{{ asset('frontend/assets/ficon.png') }}">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>
        AnazBD - @yield('title')
      </title>
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />        <!-- CSS Files -->
    <link href="{{ asset('/material/assets/css/material-dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

{{--    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />--}}
        <!-- CSS Just for demo purpose, don't include it in your project -->
            {{--  <link href="{{ asset('/material/assets/demo/demo.css') }}" rel="stylesheet" />  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ace-skins.min.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ace-rtl.min.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ace-ie.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/ace-part2.min.css') }}" />
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.css') }}" />--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" />
            <link rel="stylesheet" type="text/css" type="text/css" href="{{asset('assets/css/sweetalert2.min.css')}}">

            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen.min.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app_tmp.css') }}"/>
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
     @stack('css')
