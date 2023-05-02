<aside class="sidebar_widget">
    <form action="" method="GET">
        @if(isset($categories) && $categories->count())
            <div class="widget_list widget_categories">
                <h3>Category</h3>
                <ul>
                    @foreach($categories as $category)
                        <li>
                            <input type="radio"
                                   name="category"
                                   id="category-{{$category->slug}}"
                                   value="{{$category->slug}}"
                                   class="category"
                                   style="margin-right: 4%"
                                {{request()->query('category') == $category->slug ? 'checked' : ''}}>
                            <label for="category-{{$category->slug}}">
                                {{$category->name}}

                                @php
                                    if (request()->query('category') == $category->slug)
                                      $GLOBALS['catName'] = $category->name;
                                @endphp
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($sub_categories) && $sub_categories->count())
            <div class="widget_list widget_categories">
                <h3>Sub Category</h3>
                <ul>
                    @foreach($sub_categories as $sub_category)
                        <li>
                            <input type="radio"
                                   name="sub_category"
                                   class="sub_category"
                                   id="sub_category-{{$sub_category->slug}}"
                                   value="{{$sub_category->slug}}"
                                   style="margin-right: 4%"
                                {{request()->query('sub_category') == $sub_category->slug ? 'checked' : ''}}>
                            <label for="sub_category-{{$sub_category->slug}}">
                                {{$sub_category->name}}

                                @php
                                    if (request()->query('sub_category') == $sub_category->slug)
                                      $GLOBALS['subCatName'] = $sub_category->name;
                                @endphp
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($child_categories) && $child_categories->count())
            <div class="widget_list widget_categories">
                <h3>Child Category</h3>
                <ul>
                    @foreach($child_categories as $child_category)
                        <li>
                            <input type="radio"
                                   name="child_category"
                                   class="child_category"
                                   id="child_category-{{$child_category->slug}}"
                                   value="{{$child_category->slug}}"
                                   style="margin-right: 4%"
                                {{request()->query('child_category') == $child_category->slug ? 'checked' : ''}}>
                            <label for="child_category-{{$child_category->slug}}">
                                {{$child_category->name}}

                                @php
                                    if (request()->query('child_category') == $child_category->slug)
                                      $GLOBALS['childCatName'] = $child_category->name;
                                @endphp
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($brands) && $brands->count())
            <div class="widget_list widget_categories">
                <h3>Brand</h3>
                <ul>
                    @foreach($brands as $brand)
                        <li>
                            <input type="radio"
                                   name="brand"
                                   id="brand-{{$brand->slug}}"
                                   value="{{$brand->slug}}"
                                   style="margin-right: 4%"
                                {{request()->query('brand') == $brand->slug ? 'checked' : ''}}>
                            <label for="brand-{{$brand->slug}}">
                                {{$brand->name}}

                                @php
                                    if (request()->query('brand') == $brand->slug)
                                      $GLOBALS['brandName'] = $brand->name;
                                @endphp
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($colors) && $colors->count())
            <div class="widget_list widget_categories">
                <h3>Color</h3>
                <ul>
                    @foreach($colors as $color)
                        <li>
                            <input type="radio"
                                   name="color"
                                   id="color-{{$color->name}}"
                                   value="{{$color->name}}"
                                   style="margin-right: 4%"
                                {{request()->query('color') == $color->name ? 'checked' : ''}}>
                            <label for="color-{{$color->name}}">{{$color->name}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($warranty_types) && $warranty_types->count())
            <div class="widget_list widget_categories">
                <h3>Warranty Type</h3>
                <ul>
                    @foreach($warranty_types as $warranty_type)
                        <li>
                            <input type="radio"
                                   name="warranty_type"
                                   id="warranty_type-{{$warranty_type->name}}"
                                   value="{{$warranty_type->name}}"
                                   style="margin-right: 4%"
                                {{request()->query('warranty_type') == $warranty_type->name ? 'checked' : ''}}>
                            <label for="warranty_type-{{$warranty_type->name}}">
                                {{$warranty_type->name}}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="widget_list tags_widget">
            <h3>Price</h3>
            <div class="tag_cloud">
                <input type="number"
                       name="min"
                       value="{{request()->query('min')}}"
                       placeholder="min"
                       min="1"
                       style="width: 30%;margin-left: 2%;border: 1px solid #a8a8a8;border-radius: 3px;">
                <input type="number"
                       name="max"
                       value="{{request()->query('max')}}"
                       placeholder="max"
                       min="1"
                       style="width: 30%;margin-left: 2%;border: 1px solid #a8a8a8;border-radius: 3px;">
                <button style="color: #fff;background-color: #da581f;border-color: #da581f;">
                    Submit
                </button>
            </div>
        </div>
    </form>
</aside>

@push('js')
    <script>
        $(document).ready(function () {
            $('input[type=radio]').on('click', function (e) {
                $(this).attr('checked', !$(this).attr('checked'));
                if ($(this).hasClass('category') && !$(this).attr('checked')) {
                    $('input.category').attr('checked', false);
                    $('input.child_category').attr('checked', false);
                }
                if ($(this).hasClass('sub_category') && !$(this).attr('checked')) {
                    $('input.child_category').attr('checked', false);
                }
                $(this).closest('form').submit();
            });


            const sortSelect = $('#sort-select');
            sortSelect.niceSelect();
            sortSelect.on('change', function (e) {
                const val = Number($(this).val());
                switch (val) {
                    case 0:
                        window.location.href = encodeURI("{{route($route,[$slug ?? '']+request()->except(['desc','asc'])+['desc'=>'time'])}}").replaceAll('&amp;', '&');
                        break;
                    case 1:
                        window.location.href = encodeURI("{{route($route,[$slug ?? '']+request()->except(['desc','asc'])+['asc'=>'time'])}}").replaceAll('&amp;', '&');
                        break;
                    case 2:
                        window.location.href = encodeURI("{{route($route,[$slug ?? '']+request()->except(['desc','asc'])+['asc'=>'price'])}}").replaceAll('&amp;', '&');
                        break;
                    case 3:
                        window.location.href = encodeURI("{{route($route,[$slug ?? '']+request()->except(['desc','asc'])+['desc'=>'price'])}}").replaceAll('&amp;', '&');
                        break;
                    case 4:
                        window.location.href = encodeURI("{{route($route,[$slug ?? '']+request()->except(['desc','asc'])+['asc'=>'name'])}}").replaceAll('&amp;', '&');
                        break;
                    case 5:
                        window.location.href = encodeURI("{{route($route,[$slug ?? '']+request()->except(['desc','asc'])+['desc'=>'name'])}}").replaceAll('&amp;', '&');
                        break;
                }
            });
        });
    </script>
@endpush
