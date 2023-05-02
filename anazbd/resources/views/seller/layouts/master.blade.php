<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>Seller - @yield('title')</title>

    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/icon.png" type="image/png">

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}"/>

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css') }}"/>

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet"
          id="main-ace-style"/>

<!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset('assets/css/ace-part2.min.css') }}" class="ace-main-stylesheet" />
    <![endif]-->

    <link rel="stylesheet" href="{{ asset('assets/css/ace-skins.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}"/>

<!--[if lte IE 9]>
    <link rel="stylesheet" href="{{ asset('assets/css/ace-ie.min.css') }}" />
    <![endif]-->


    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.gritter.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.custom.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/colorbox.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app_temp.css') }}"/>

    <!-- page specific styles -->
    @stack('css')
</head>

<body class="no-skin" style="font-family: monospace;">

@include('seller.partials._header')

<div class="main-container ace-save-state" id="main-container">

    @include('seller.partials._sidebar')

    <div class="main-content">
        <div class="main-content-inner">
            {{--            @include('backend.partials._breadcrumbs')--}}

            <div class="page-content">
                @yield('content', 'Default Content')
            </div>
        </div>
    </div>

    @include('seller.partials._footer')
</div>

{{-- JQUERY --}}
<script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.colorbox.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.inputlimiter.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.knob.min.js') }}"></script>
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>" + "<" + "/script>");
</script>

{{-- ACE --}}
<script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
<script src="{{ asset('assets/js/ace.min.js') }}"></script>
<!-- ace settings handler -->
<script src="{{ asset('assets/js/ace-extra.min.js') }}"></script>

<!--[if lte IE 8]>
    <script src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets/js/respond.min.js') }}"></script>
    <![endif]-->
    @include('notify::messages')
<script type="text/javascript">
    try {
        ace.settings.loadState('main-container')
    } catch (e) {
    }

    $('input[type=file].single-file').ace_file_input({
        style: 'well',
        no_file: 'Click to choose or drag & drop',
        droppable: true,
        thumbnail: 'fit'
    });

    $('input[type=file].multiple-file').ace_file_input({
        style: 'well',
        no_file: 'Click to choose or drag & drop',
        droppable: true,
        thumbnail: 'small'
    });
</script>

{{-- Bootstrap --}}
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-tag.min.js') }}"></script>

{{-- Sweet Alert--}}
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
    @if(session()->get('message'))
    swal.fire({
        title: "Success",
        html: "<b>{{ session()->get('message') }}</b>",
        type: "success",
        timer: 1000
    });

    @elseif(session()->get('message-number'))
    swal.fire({
        title: "Success",
        html: "<b>{!! session()->get('message-number') !!}</b>",
        // type: "success",
        timer: 30000
    });

    @elseif(session()->get('error'))
    swal.fire({
        title: "Error",
        html: "<b>{{ session()->get('error') }}</b>",
        type: "error",
        timer: 1000
    });
    @endif

    $('.success').fadeIn('slow').delay(10000).fadeOut('slow');

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': '{{@csrf_token()}}' }
    });
</script>

{{-- ETC --}}
<script src="{{ asset('assets/js/spinbox.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/autosize.min.js') }}"></script>

@stack('js')
</body>
</html>
