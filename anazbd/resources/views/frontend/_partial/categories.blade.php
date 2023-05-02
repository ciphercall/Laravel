

        <div class="categories_product_area mb-55">
            <div class="container padding" style="    min-width: 1430px;
">
                <div class="row text-center padding">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                        <div class="section_title" style="width: 100%;text-align: left;">
                            <h2 style="white-space: nowrap;overflow: hidden;text-align: left;margin-left: 0">
                                Categories
                            </h2>
                            <a style="margin-left: 80%">
                                <div class="wrap3">
                                    <!-- <div class="search">
                                        <input type="text" class="searchTerm" placeholder="What are you looking for?"
                                               style="height: 36px;"/>
                                        <button type="submit" class="searchButton">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div> -->
                                </div>
                            </a>

                        </div>
                        {{--  <div class="card-header"
                             style="background: white; display: flex; justify-content: space-between; align-items: center;">
                                <span class="area_name" style="font-weight: 500;">
                                    <span id="demo" style="color: orange;"></span>
                                </span>
                            <a href="#"
                               style="color: #ff7700; float: right; display: inline-block; border: 1px solid #ff7700; padding: 2px 10px; margin-right: 1%;">
                                SHOP MORE
                            </a>
                        </div>  --}}

                        <div class="categories_product_inner">
                            <div class="col-md-12">
                                @foreach(collect($categories)->chunk(7) as $chunk1)

                                <div class="row padding" style="padding: 7px 7px 7px 7px;">
                                    @foreach(collect($chunk1)->chunk(7) as $chunk2)
                                    <div class="col-md-12">
                                        <div class="row padding owl-carousel carou_kaka2">
                                            @foreach($chunk2 as $category)
                                            <div class="col-md-3">
                                                 <div class="justify-content-center">
                                                    <div class="categories_product_thumb2" style="background-image: url('https://drive.google.com/uc?export=download&id=10F8KCDVIhU21oFl4TO8_hoIvwQeLzVld'); background-size: 100% 100%; background-repeat: no-repeat; width: 161px !important;border: 1px solid darkgray;border-radius: 16px;margin: 3px;box-shadow: 3px 4px 3px 0px #d7def4;">
                                                        <a class="collection_product_image stretched-link" href="{{route('frontend.category', $category->slug)}}">
                                                            @if(file_exists('public/'.$category->image))
                                                                <img loading="lazy" src="{{ asset($category->image)}}" alt="{{asset($category->image)}}" style="height: 92px;width: 120px;box-shadow: 0px 1px 16px 3px #d7def4;">
                                                            @else
                                                                <img loading="lazy" src="{{ asset('defaults/click-me.png')}}" alt="No Image Found" style="height: 92px;width: 120px;box-shadow: 0px 1px 16px 3px #d7def4;">
                                                            @endif
                                                            <div style="position: relative;top: 6px;left: -20px;width: 133%;height: 33px;border-top: 1px solid darkslategrey;border-radius: 18px;background-color: darkgray;">
                                                                <p class="collection_product_name" style="white-space:normal;position: relative;top: -24px;text-align: center;">{{ Str::limit($category->name, 12)}}</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('js')
            <script>
                var owl2 = $('.carou_kaka2');
                owl2.owlCarousel({
                    items: 7,
                    loop: true,
                    margin: 10,
                    autoplay: false,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true
                });
            </script>
        @endpush
