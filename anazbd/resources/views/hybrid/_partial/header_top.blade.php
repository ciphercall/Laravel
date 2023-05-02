<div class="container h-100 d-flex align-items-center justify-content-between" style="max-width: 96%;">
    <!-- Navbar Toggler-->
    <a href="{{ route('hybrid.user.account.no-auth',az_hash($user->id)) }}" class="suha-navbar-toggler d-flex flex-wrap"><i class="fas fa-long-arrow-alt-left">&nbsp;Back</i></a>
    {{--  <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>  --}}
    <!-- Logo Wrapper-->
    <div class="logo-wrapper">
        {{--  <a href="{{ url('/') }}">
{{--            <span style="color: green">{{ $info->name??"Company Name" }}</span>--}}
            {{--  <img src="{{ asset('frontend') }}/assets/ficon.png" alt="{{ asset('frontend') }}/assets/ficon.png">  --}}
        {{--  </a>  --}}
    </div>
    <!-- Search Form-->
    <div class="top-search-form" style="width: 76%;">
        {{--  <form action="{{route('search')}}" method="GET">
            <input id="searchbox" class="form-control" name="search" type="text" placeholder="Enter your keyword" required style="max-width: 91%;">
            <button style="margin-left: 75%;" type="submit"><i class="fa fa-search"></i></button>
        </form>
        <div class="container-fluid" id="searchRes" style="display: none; border: 1px solid darkgrey; border-radius: 1px 1px 10px 10px;position: absolute;z-index: 2;background-color: rgba(255,255,255,0.9);width: 94.9%;">
                            
        </div>  --}}
    </div>

</div>
