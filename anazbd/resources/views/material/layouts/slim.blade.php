
    <!DOCTYPE html>
    <html lang="en" style="height: 713px;">

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


        </style>
    </head>

    <body class="" style="background-color: lightgrey;">
          <div class="container" style="margin-top:30px !important;">
            <div class="container-fluid">
              @yield('content')
            </div>
          </div>
          <footer class="footer" style="padding: 0px !important;">
            <div class="container-fluid">
              <nav class="float-left">
                <ul>
                  <li>
                    <a href="/aboutus">
                      About Us
                    </a>
                  </li>
                  <li>
                    <a href="/blog">
                      Blog
                    </a>
                  </li>
                  <li>
                    <a href="/quick-page/terms-and-conditions">
                      Terms & Conditions
                    </a>
                  </li>
                </ul>
              </nav>
              <div class="copyright float-right">
                &copy;
                <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="material-icons">favorite</i> by
                <a href="https://anazbd.com/" target="_blank">AnazBD Software Department</a>.
              </div>
            </div>
          </footer>
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
