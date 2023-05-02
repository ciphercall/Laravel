@php
if (!isset($top))
    $top = '50%';
if (!isset($left))
    $left = '50%';
@endphp

@push('css')
    <style>
        body.az-loader {
            position: relative;
        }

        .az-loader-div {
            display: none;
        }

        .az-loader .az-loader-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            z-index: 9998;
        }

        .az-loader .az-loader-div {
            position: fixed;
            z-index: 9999;
            display: block !important;
        }

        .az-loader .az-circle {
            border: 3px solid #f8681a;
            width: 50px;
            height: 50px;
            position: fixed;
            top: {{$top}};
            left: {{$left}};
            transform: translate(-50%, -50%);
            border-radius: 50%;
            border-left-color: transparent;
            border-right-color: transparent;
            animation: rotate 2s cubic-bezier(0.26, 1.36, 0.74, -0.29) infinite;
        }

        .az-loader .az-circle-2 {
            border: 3px solid #d6336c;
            width: 60px;
            height: 60px;
            position: fixed;
            top: {{$top}};
            left: {{$left}};
            transform: translate(-50%, -50%);
            border-left-color: transparent;
            border-right-color: transparent;
            animation: rotate2 2s cubic-bezier(0.26, 1.36, 0.74, -0.29) infinite;
        }

        .az-loader .az-circle-3 {
            border: 3px solid #ed4d42;
            width: 70px;
            height: 70px;
            position: fixed;
            top: {{$top}};
            left: {{$left}};
            transform: translate(-50%, -50%);
            border-left-color: transparent;
            border-right-color: transparent;
            animation: rotate 2s cubic-bezier(0.26, 1.36, 0.74, -0.29) infinite;
        }

        .az-loader .az-circle-4 {
            border: 3px solid #035486;
            width: 80px;
            height: 80px;
            position: fixed;
            top: {{$top}};
            left: {{$left}};
            transform: translate(-50%, -50%);
            border-left-color: transparent;
            border-right-color: transparent;
            animation: rotate2 2s cubic-bezier(0.26, 1.36, 0.74, -0.29) infinite;
        }

        @keyframes rotate {
            0% {
                transform: translate(-50%, -50%) rotateZ(-360deg)
            }
            100% {
                transform: translate(-50%, -50%) rotateZ(0deg)
            }
        }

        @keyframes rotate2 {
            0% {
                transform: translate(-50%, -50%) rotateZ(360deg)
            }
            100% {
                transform: translate(-50%, -50%) rotateZ(0deg)
            }
        }
    </style>
@endpush

<div class="az-loader-bg"></div>
<div class="az-loader-div">
    <div class="az-circle"></div>
    <div class="az-circle az-circle-2"></div>
    <div class="az-circle az-circle-3"></div>
    <div class="az-circle az-circle-4"></div>
</div>

@push('js')
    <script>
        function toggleAZLoader() {
            $('body').toggleClass('az-loader');
        }
    </script>
@endpush
