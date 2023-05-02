
<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('material/assets/img/sidebar-1.jpg') }}">

    <div class="logo"><a href="{{ url('/admin') }}" class="simple-text logo-normal">
        AnazBD Admin Panel
      </a></div>
    <div class="sidebar-wrapper">
        @php
        $routeName = request()->route()->getName();
    @endphp

    <ul class="nav nav-list">
    </ul>
      <ul class="nav">

        <li class="nav-item {{$routeName === 'admin.dashboard.index' ? 'active open' : ''}}">
          <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
          </a>
        </li>
        @can('view_orders')
          @include('admin.include.sidebar-items.order')
        @endcan
        @can('view_transactions')
          <li class="nav-item {{ strpos($routeName, 'admin.transactions') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{ route('admin.transactions') }}" id="orders">
                <div class="row">
                    <div class="col-2">            <i class="material-icons">analytics</i>
                    </div>
                    <div class="col-7">            <p>Transactions</p>
                    </div>
                </div>
            </a>
          </li>
          <li class="nav-item {{ strpos($routeName, 'admin.transaction.point') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{ route('admin.transaction.point') }}" id="orders">
                <div class="row">
                    <div class="col-2">            <i class="material-icons">attach_money</i>
                    </div>
                    <div class="col-7">            <p>Point Transactions</p>
                    </div>
                </div>
            </a>
          </li>
        @endcan
          
        
          @can('view_products')
           @include('admin.include.sidebar-items.product')
          @endcan

          @can('view_cart','view_wishlist')
            @include('admin.include.sidebar-items.cart_wishlist')
          @endcan

          @can('view_all_users')
            @include('admin.include.sidebar-items.users')
          @endcan

          @can('view_campaigns')
            @include('admin.include.sidebar-items.campaign')
          @endcan
          @can('manage_econfig')
          <li class="nav-item {{ (strpos($routeName, 'admin.econfig') === 0 ? 'active open' : '') }}">
            <a class="nav-link" href="#" id="econfig">
                <div class="row">
                    <div class="col-2"><i class="material-icons">engineering</i>
                    </div>
                    <div class="col-7"><p>Econfig</p>
                    </div>
                    <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>
                </div>
            </a>
            <ul class="nav" id="econfig_child" style="display: {{ (strpos($routeName, 'admin.site.setting.index') === 0 || strpos($routeName, 'admin.notification.index') === 0) ? 'block' : 'none'}};">
                <li class="nav-item {{ strpos($routeName, 'backend.econfig.delivery-size.index') === 0 ? 'active open' : ''}}">
                  <a class="nav-link" href="{{route('backend.econfig.delivery-size.index')}}">
                      <i class="material-icons">inventory_2</i>
                      <p>Delivery Size</p>
                  </a>
                </li>
            </ul>
          </li>
          @endcan
        @can('manage_social_links')
        <li class="nav-item {{ (strpos($routeName, 'backend.social') === 0 ? 'active open' : '') }}">
          <a class="nav-link" href="#" id="social">
              <div class="row">
                  <div class="col-2"><i class="material-icons">facebook</i>
                  </div>
                  <div class="col-7"><p>Social</p>
                  </div>
                  <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="social_child" style="display: {{ strpos($routeName, 'backend.social') === 0 ? 'block' : 'none'}};">
              <li class="nav-item {{ strpos($routeName, 'backend.social') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('backend.social.index')}}">
                    <i class="material-icons">public</i>
                    <p>Social Links</p>
                </a>
              </li>
          </ul>
        </li>
        @endcan

        @can('manage_blog')
          <li class="nav-item {{ (strpos($routeName, 'backend.blog') === 0 ? 'active open' : '') }}">
            <a class="nav-link" href="{{ route('backend.blog.index') }}">
                <div class="row">
                    <div class="col-2"><i class="material-icons">web</i>
                    </div>
                    <div class="col-7"><p>Blog</p>
                    </div>
                    {{--  <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>  --}}
                </div>
            </a>
          </li>
        @endcan
        @can('manage_comment')
        <li class="nav-item {{ (strpos($routeName, 'backend.comment') === 0 ? 'active open' : '') }}">
          <a class="nav-link" href="#" id="comment">
              <div class="row">
                  <div class="col-2"><i class="material-icons">reviews</i>
                  </div>
                  <div class="col-7"><p>Comment</p>
                  </div>
                  <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="comment_child" style="display: {{ strpos($routeName, 'backend.comment') === 0 ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'backend.comment') === 0 ? 'active open' : ''}}">
              <a class="nav-link" href="{{route('backend.comment.unpublished')}}">
                  <i class="material-icons">pending_actions</i>
                  <p>Unpublished</p>
              </a>
            </li>
            <li class="nav-item {{ strpos($routeName, 'backend.comment') === 0 ? 'active open' : ''}}">
              <a class="nav-link" href="{{route('backend.comment.published')}}">
                  <i class="material-icons">check_box</i>
                  <p>Published</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan
        @can('manage_question_answer')
          <li class="nav-item {{ (strpos($routeName, 'backend.questions') === 0 ? 'active open' : '') }}">
            <a class="nav-link" href="{{ route('backend.questions.all') }}">
                <div class="row">
                    <div class="col-2"><i class="material-icons">question_answer</i>
                    </div>
                    <div class="col-7"><p>Questions</p>
                    </div>
                    {{--  <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>  --}}
                </div>
            </a>
          </li>
        @endcan
          @include('admin.include.sidebar-items.config')

          @can('manage_sms_email_config')
          <li class="nav-item {{ (strpos($routeName, 'backend.sms_config') === 0 ? 'active open' : '') }}">
            <a class="nav-link" href="{{ route('backend.sms_config.get') }}">
                <div class="row">
                    <div class="col-2"><i class="material-icons">email</i>
                    </div>
                    <div class="col-7"><p>SMS & Email Config</p>
                    </div>
                    {{--  <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>  --}}
                </div>
            </a>
          </li>
          @endcan

          @can('manage_area_division')
            <li class="nav-item {{ (strpos($routeName, 'backend.area') === 0 ? 'active open' : '') }}">
              <a class="nav-link" href="#" id="area">
                  <div class="row">
                      <div class="col-2"><i class="material-icons">explore</i>
                      </div>
                      <div class="col-7"><p>Area-Division</p>
                      </div>
                      <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>
                  </div>
              </a>
              <ul class="nav" id="area_child" style="display: {{ strpos($routeName, 'backend.area') === 0 ? 'block' : 'none'}};">
                <li class="nav-item {{ strpos($routeName, 'backend.area.index') === 0 ? 'active open' : ''}}">
                  <a class="nav-link" href="{{route('backend.area.index')}}">
                      <i class="material-icons">map</i>
                      <p>Division</p>
                  </a>
                </li>
                <li class="nav-item {{ strpos($routeName, 'backend.area.city') === 0 ? 'active open' : ''}}">
                  <a class="nav-link" href="{{route('backend.area.city.index')}}">
                      <i class="material-icons">map</i>
                      <p>City</p>
                  </a>
                </li>
                <li class="nav-item {{ strpos($routeName, 'backend.area.post_code') === 0 ? 'active open' : ''}}">
                  <a class="nav-link" href="{{route('backend.area.post_code.index')}}">
                      <i class="material-icons">map</i>
                      <p>Areas</p>
                  </a>
                </li>
              </ul>
            </li>
          @endcan
      </ul>
    </div>
  </div>
@push('js')
    <script>
        $(document).ready(function () {
            $('.nav-link').on('click', function () {
                $('#'+this.id+'_child').delay(250).fadeToggle();
                if($('#'+this.id+'_arrow').hasClass('fas fa-arrow-circle-down')){
                    $('#'+this.id+'_arrow').removeClass('fa-arrow-circle-down');
                    $('#'+this.id+'_arrow').addClass('fa-arrow-circle-up');
                }else{
                    $('#'+this.id+'_arrow').removeClass('fa-arrow-circle-up');
                    $('#'+this.id+'_arrow').addClass('fa-arrow-circle-down');

                }
            })
        });
    </script>
@endpush
