
<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('material/assets/img/sidebar-1.jpg') }}">

    <div class="logo"><a href="{{ url('/seller') }}" class="simple-text logo-normal">
        AnazBD Seller Panel
      </a></div>
    <div class="sidebar-wrapper">
        @php
        $routeName = request()->route()->getName();
    @endphp

    <ul class="nav nav-list">
    </ul>
      <ul class="nav">

        <li class="nav-item {{$routeName === 'seller.dashboard.index' ? 'active open' : ''}}">
          <a class="nav-link" href="{{ route('seller.dashboard.index') }}">
            <i class="material-icons">dashboard</i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'seller.profile') === 0 ? 'active open' : ''}}">
          <a class="nav-link" href="#" id="pfl">
              <div class="row">
                  <div class="col-2">            <i class="material-icons">person</i>
                  </div>
                  <div class="col-7">            <p>Profile</p>
                  </div>
                  <div class="col-3"><i id="pfl_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="pfl_child" style="display: {{ strpos($routeName, 'seller.profile') === 0 ? 'block' : 'none'}};">
                <li class="nav-item {{ strpos($routeName, 'seller.profile.index') === 0 ? 'active open' : ''}}">
                    <a class="nav-link" href="{{route('seller.profile.index')}}">
                        <i class="material-icons">person</i>
                        Profile
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="nav-item {{ strpos($routeName, 'seller.profile.bank-info') === 0 ? 'active open' : ''}}">
                    <a class="nav-link" href="{{route('seller.profile.bank-info')}}">
                        <i class="material-icons">account_balance</i>
                        Bank Account
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>
        <li class="nav-item {{ strpos($routeName, 'seller.order') === 0 ? 'active open' : ''}}">
          <a class="nav-link" href="#" id="odr">
              <div class="row">
                  <div class="col-2">            <i class="material-icons">local_shipping</i>
                  </div>
                  <div class="col-7">            <p>Orders</p>
                  </div>
                  <div class="col-3"><i id="odr_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="odr_child" style="display: {{ strpos($routeName, 'seller.order') === 0 ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'seller.order.pending.') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{ route('seller.order.pending.index') }}">
                    <i class="material-icons">hourglass_top</i>
                    Pending
                </a>

            </li>
            <li class="nav-item {{ strpos($routeName, 'seller.order.delivered.') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{ route('seller.order.delivered.index') }}">
                    <i class="material-icons">hourglass_bottom</i>
                    Delivered
                </a>
            </li>
            <li class="nav-item {{ strpos($routeName, 'seller.order.cancelled.') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{ route('seller.order.cancelled.index') }}">
                    <i class="material-icons">hourglass_disabled</i>
                    Cancelled
                </a>
            </li>
        </ul>
        </li>
        {{--  <li class="nav-item {{ strpos($routeName, 'seller.transaction') === 0 || strpos($routeName, 'seller.withdrawal.') === 0 ? 'active open' : ''}}">
          <a class="nav-link" href="#" id="trns">
              <div class="row">
                  <div class="col-2">            <i class="material-icons">payments</i>
                  </div>
                  <div class="col-7">            <p>Transactions</p>
                  </div>
                  <div class="col-3"><i id="trns_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="trns_child" style="display: {{ strpos($routeName, 'seller.transaction') === 0 ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'seller.transaction.') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{ route('seller.transaction.index') }}">
                    <i class="material-icons">account_balance_wallet</i>
                    All Transactions
                </a>
            </li>
            <li class="nav-item {{ strpos($routeName, 'seller.withdrawal.') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{ route('seller.withdrawal.index') }}">
                    <i class="material-icons">request_quote</i>
                    Withdraw Requests
                </a>
                <b class="arrow"></b>
            </li>
        </ul>  --}}
        </li>
        <li class="nav-item {{ strpos($routeName, 'seller.product') === 0 ? 'active open' : ''}}">
          <a class="nav-link" href="#" id="itm">
              <div class="row">
                  <div class="col-2">            <i class="material-icons">category</i>
                  </div>
                  <div class="col-7">            <p>Items</p>
                  </div>
                  <div class="col-3"><i id="itm_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="itm_child" style="display: {{ strpos($routeName, 'seller.product') === 0 ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'seller.product.items') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('seller.product.items.index')}}">
                    <i class="material-icons">archive</i>
                    Items
                </a>
            </li>
              <li class="nav-item {{ strpos($routeName, 'seller.product.collection') === 0 ? 'active open' : ''}}">
                  <a class="nav-link" href="{{route('seller.product.collection.index')}}">
                      <i class="fa fa-th"></i>
                      Collections
                  </a>
              </li>
        </ul>
        </li>
        <li class="nav-item {{ strpos($routeName, 'seller.campaign') === 0 ? 'active open' : ''}}">
          <a class="nav-link" href="#" id="camp">
              <div class="row">
                  <div class="col-2">            <i class="material-icons">redeem</i>
                  </div>
                  <div class="col-7">            <p>Campaign</p>
                  </div>
                  <div class="col-3"><i id="camp_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="camp_child" style="display: {{ strpos($routeName, 'seller.campaign') === 0 ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'seller.campaign.flash_sale.') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('seller.campaign.flash_sale.index')}}">
                    <i class="material-icons">loyalty</i>
                    Flash Sale
                </a>
            </li>
        </ul>
        </li>
        <li class="nav-item {{ strpos($routeName, 'seller.questions') === 0 ? 'active open' : ''}}">
          <a class="nav-link" href="#" id="qa">
              <div class="row">
                  <div class="col-2">            <i class="material-icons">question_answer</i>
                  </div>
                  <div class="col-7">            <p>Questions</p>
                  </div>
                  <div class="col-3"><i id="qa_arrow" class="fas fa-arrow-circle-down"></i></div>
              </div>
          </a>
          <ul class="nav" id="qa_child" style="display: {{ strpos($routeName, 'seller.questions') === 0 ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'seller.questions.answered') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('seller.questions.answered')}}">
                    <i class="material-icons">done_all</i>
                    <p>Answered</p>
                </a>
            </li>
            <li class="nav-item {{ strpos($routeName, 'seller.questions.unanswered') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('seller.questions.unanswered')}}">
                    <i class="material-icons">help</i>
                    <p>Unanswered</p>
                </a>
            </li>
        </ul>
        </li>
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
