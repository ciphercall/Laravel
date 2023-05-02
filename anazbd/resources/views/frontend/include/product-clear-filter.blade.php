@if(request()->query('category') || request()->query('sub_category') || request()->query('child_category') || request()->query('brand') || request()->query('color') || request()->query('warranty_type') || request()->query('min') || request()->query('max'))
    <div class="row mb-20">
        <div class="col-12" style="display: flex; align-items: start">
            <span style="width: 100px; margin-top: 10px">Filtered By:</span>
            <div style="display: flex; flex-wrap: wrap">
                @if(request()->query('category'))
                    <span class="filter-item">
                        Category: {{$GLOBALS['catName']}}
                        <a href="{{route($route,[$slug ?? '']+request()->except(['category', 'sub_category', 'child_category']))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('sub_category'))
                    <span class="filter-item">
                        Sub Category: {{$GLOBALS['subCatName']}}
                        <a href="{{route($route,[$slug ?? '']+request()->except(['sub_category', 'child_category']))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('child_category'))
                    <span class="filter-item">
                        Child Category: {{$GLOBALS['childCatName']}}
                        <a href="{{route($route,[$slug ?? '']+request()->except('child_category'))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('brand'))
                    <span class="filter-item">
                        Brand: {{$GLOBALS['brandName']}}
                        <a href="{{route($route,[$slug ?? '']+request()->except('brand'))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('color'))
                    <span class="filter-item">
                        Color: {{request()->query('color')}}
                        <a href="{{route($route,[$slug ?? '']+request()->except('color'))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('warranty_type'))
                    <span class="filter-item">
                        Warranty Type: {{request()->query('warranty_type')}}
                        <a href="{{route($route,[$slug ?? '']+request()->except('warranty_type'))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('min'))
                    <span class="filter-item">
                        Min Price: {{request()->query('min')}}
                        <a href="{{route($route,[$slug ?? '']+request()->except('min'))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif

                @if(request()->query('max'))
                    <span class="filter-item">
                        Max Price: {{request()->query('max')}}
                        <a href="{{route($route,[$slug ?? '']+request()->except('max'))}}">
                            <i class="fa fa-times"></i>
                        </a>
                    </span>
                @endif
            </div>
        </div>
    </div>
@endif
