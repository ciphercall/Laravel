
    <!DOCTYPE html>
    <html lang="en">

    <head>
      @include('material.include.header')
        <style>
            .maximize {
                margin-top: 0;
                margin-bottom: 0;
                margin-left: 15px;
                /* margin-bottom: -12px; */
                position: relative;
            }
            .bmd-form-group [class^='bmd-label'], .bmd-form-group [class*=' bmd-label'] {
                position: initial;
                pointer-events: none;
                transition: 0.3s ease all;
            }
            .page-link:not(:disabled):not(.disabled){
              color: #a640b8;
            }
            .page-item.active .page-link
            {
                background-color: #a640b8;
                color: #ffffff;
            }

/*this is added to hide the default page header*/
            .page-header{
                visibility: hidden;
                min-height: 0;
            }


        </style>
    </head>

    <body class="">
      <div class="wrapper ">
        @include('material.include.sidebar')
        <div class="main-panel">
          <!-- Navbar -->
          @auth('seller')
            @include('material.include.navbar-seller')
          @else
            @include('material.include.navbar')
          @endauth


          <!-- End Navbar -->
          <div class="content" style="margin-top:30px !important;">
            <div class="container-fluid">
              @yield('content')
            </div>
          </div>
          @include('material.include.footer')
        </div>
      </div>
      @include('material.include.scripts')
    </body>
    <script>


        // navigation toggler
        $(document).ready(function () {
            $(document).on('click',function (event) {
                var x = $(event.target);
                if(x.hasClass("navbar-toggler")==false && x.hasClass("navbar-toggler-icon")==false && !x.parents('div.sidebar').length){
                    $('.sidebar').css('right','0');

                }else{
                    $('.sidebar').css('right','238px');
                }
            })
        });
    </script>


    </html>
