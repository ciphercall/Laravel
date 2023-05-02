@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    All Shops
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css').'?v='.(config()->get('version'))}}">
    <style>
        #load-more-btn {
            padding: 6px 100px;
            border: 1px solid #999;
            background: #eee;
            text-transform: uppercase;
        }

        #load-more-btn:hover {
            color: white;
            background: #f7a519;
            border: 1px solid #eee;
        }

        #load-more-btn:disabled {
            color: initial;
            background: #eee;
            border: 1px solid #999;
            cursor: default;
        }
    </style>
@endpush

@section('content')
    @if(isset($sellers))
        <div class="categories_product_area mb-55">
            <div class="container" id="shops-container">
                @foreach($sellers->chunk(12) as $chunk)
                    <div class="card-deck" style="margin-top: 40px">
                        @foreach($chunk as $seller)
                            <a href="{{route('frontend.seller.shop.show', $seller->slug)}}" class="card" style="min-height: 287px;">
{{--                                <div class="card-img-overlay"></div>--}}
                                <img class="card-img-top"
                                     src="{{asset($seller->profile->product_image ?? '') }}"
                                     alt="" style="opacity: .3;">
                                <div class="card-img-on-top" style="position: absolute;bottom: 114px;height: 150px;width: 169px;left: 15px;">
                                    <img class="card-image-anaz-mall" style="width: 100%;height: 100%;"
                                         src="{{asset($seller->profile->logo ?? '')}}"
                                         alt="Card image cap">
                                </div>
                                <div class="card-body" style="background-image: url('https://www.bravenewmind.org/wp-content/uploads/2019/01/wavepattern.png');background-repeat: no-repeat;background-size: cover;">
                                    <div class="card-title-h1" style="text-align: center;font-size: 19px;font-family: fantasy;">{{Str::limit($seller->shop_name, 12)}}</div>
                                    <p class="card-content-p">{{$seller->slogan ?? ''}}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="container" style="display: flex; justify-content: center; margin-top: -20px; margin-bottom: 20px;">
            <button class="load-more"
                    id="load-more-btn"
                    type="button"
                    data-page="{{request()->query('page') ?? 1}}">
                Load More
            </button>
        </div>
    @endif
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            const shopsContainer = $('#shops-container');
            const loadMore = $('#load-more-btn');

            loadMore.on('click', function (e) {
                $(this).attr('disabled', true);
                const page = Number($(this).attr('data-page')) + 1;
                $.post('{{route("frontend.seller.shop.load-more.ajax")}}',
                    {
                        page: page,
                        shopType: 'anazMallShops'
                    },
                    function (res) {
                        const shops = res;
                        if (shops.length > 0) {
                            template(shops);
                            loadMore.attr('data-page', page);
                        } else {
                            loadMore.attr('data-page', page);
                            loadMore.css('display', 'none');
                        }
                    }
                )
            });

            // function template(shops) {
            //     const rows = Math.ceil(shops.length / 6);
            //     let template = '';
            //     for (let i = 0; i < rows; i++) {
            //         template += `<div class="card-deck" style="margin-top: 20px">`;
            //         for (let j = (i * 6); j < (i + 1) * 6; j++) {
            //             if (typeof shops[j] !== 'undefined') {
            //                 template += `<a href="/shop/${shops[j].slug}" class="card">
            //             <div class="card-img-overlay"></div>
            //             <img class="card-img-top"
            //                  src="${shops[j].shop_image}"
            //                  alt="">
            //                 <div class="card-img-on-top">
            //                     <img class="card-image-anaz-mall"
            //                          src="${shops[j].image}"
            //                          alt="Card image cap">
            //                 </div>
            //                 <div class="card-body">
            //                     <div class="card-title-h1">${shops[j].shop_name}</div>
            //                     <p class="card-content-p">${typeof shops[j].slogan === 'undefined' ? '' : shops[j].slogan}</p>
            //                 </div>
            //         </a>`;
            //             }
            //         }
            //         template += `</div>`;
            //     }
            //
            //     shopsContainer.append(template);
            //     loadMore.attr('disabled', false);
            // }
            function template(shops) {
                const rows = Math.ceil(shops.length / 6);
                let template = '';
                for (let i = 0; i < rows; i++) {
                    template += `<div class="card-deck" style="margin-top: 40px">`;
                    for (let j = (i * 6); j < (i + 1) * 6; j++) {
                        if (typeof shops[j] !== 'undefined') {
                    //         template += `<a href="/shop/${shops[j].slug}" class="card">
                    //     <div class="card-img-overlay"></div>
                    //     <img class="card-img-top"
                    //          src="${shops[j].shop_image}"
                    //          alt="">
                    //         <div class="card-img-on-top">
                    //             <img class="card-image-anaz-mall"
                    //                  src="${shops[j].image}"
                    //                  alt="Card image cap">
                    //         </div>
                    //         <div class="card-body">
                    //             <div class="card-title-h1">${shops[j].shop_name}</div>
                    //             <p class="card-content-p">${typeof shops[j].slogan === 'undefined' ? '' : shops[j].slogan}</p>
                    //         </div>
                    // </a>`;
                            template += `<a href="/shops/${shops[j].slug}" class="card" style="min-height: 287px;">
{{--                                <div class="card-img-overlay"></div>--}}
                            <img class="card-img-top"
                                 src="${shops[j].shop_image}"
                                     alt="" style="opacity: .3;">
                                <div class="card-img-on-top" style="position: absolute;bottom: 114px;height: 150px;width: 169px;left: 15px;">
                                    <img class="card-image-anaz-mall" style="width: 100%;height: 100%;"
                                         src="${shops[j].image}"
                                         alt="Card image cap">
                                </div>
                                <div class="card-body" style="background-image: url('https://www.bravenewmind.org/wp-content/uploads/2019/01/wavepattern.png');background-repeat: no-repeat;background-size: cover;">
                                    <div class="card-title-h1" style="text-align: center;font-size: 19px;font-family: fantasy;">${shops[j].shop_name}</div>
                                    <p class="card-content-p">${typeof shops[j].slogan === 'undefined' ? '' : shops[j].slogan}</p>
                                </div>
                            </a>`;
                        }
                    }
                    template += `</div>`;
                }

                shopsContainer.append(template);
                loadMore.attr('disabled', false);
            }
        });
    </script>
@endpush
