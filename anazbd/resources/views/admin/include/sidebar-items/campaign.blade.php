<li class="nav-item {{(strpos($routeName, 'admin.campaign.coupons') === 0) || (strpos($routeName, 'backend.campaign') === 0) ? 'active open' : ''}}">
    <a class="nav-link" href="#" id="pfl">
        <div class="row">
            <div class="col-2">            <i class="material-icons">person</i>
            </div>
            <div class="col-7">            <p>Campaigns</p>
            </div>
            <div class="col-3"><i id="pfl_arrow" class="fas fa-arrow-circle-down"></i></div>
        </div>
    </a>
    <ul class="nav" id="pfl_child" style="display: {{ (strpos($routeName, 'admin.campaign.coupons') === 0) || (strpos($routeName, 'backend.campaign') === 0) ? 'block' : 'none'}};">
          @can('view_coupons')
            <li class="nav-item {{ strpos($routeName, 'admin.campaign.coupons') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.campaign.coupons.index')}}">
                    <i class="material-icons">confirmation_number</i>
                    <p>Coupons</p>
                </a>
            </li>
          @endcan
          @can('manage_flash_sale')
            <li class="nav-item {{ strpos($routeName, 'backend.campaign.flash_sale') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('backend.campaign.flash_sale.index')}}">
                    <i class="material-icons">local_offer</i>
                    <p>Flash Sale</p>
                </a>
            </li>
          @endcan
          <li class="nav-item {{ strpos($routeName, 'admin.campaign.offer') === 0 ? 'active open' : ''}}">
              <a class="nav-link" href="{{route('admin.campaign.offer.create')}}">
                  <i class="material-icons">content_cut</i>
                  <p>Offers</p>
              </a>
          </li>
      </ul>
  </li>