<div class="page-header">
    @if(isset($route) && isset($fa) && isset($name))
        <div class="widget-toolbar">
            <a href="{{ $route }}"><i class="{{ $fa }}"></i> {{ $name }}</a>
        </div>
    @endif
    <h1>
        @yield('page-header')
    </h1>
</div>
