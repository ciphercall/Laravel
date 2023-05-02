@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Global Collection
@endsection
@push('css')
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
    @if($collections->count())
        <div id="collection-container">
            @foreach($collections->chunk(4) as $chunk)
                <div class="categories_product_area mb-40" style="margin-top: 40px">
                    <div class="container">
                        <div class="categories_product_inner">
                            <div class="row">
                                @forelse ($chunk as $col)
                                    <div class="col-md-3">
                                        <div class="single_categories_products  collection-hover"
                                             style="padding-bottom: 10px;border: 1px solid rgba(0,0,0,0.08);">
                                            <div class="row text-center padding ">
                                                <div class="categories_product_content col-md-12"
                                                     style="text-align: center">
                                                    <a href="{{ route('frontend.collection',$col->slug)  }}">
                                                        <h4>
                                                            {{ $col->title??' ' }}
                                                        </h4>
                                                        <p>{{ $col->items_count??' ' }} Products</p>
                                                    </a>
                                                </div>

                                                <div class="col-md-12">
                                                    <a href="{{  route('frontend.collection',$col->slug) }}">
                                                        <div class="categories_product_thumb ">
                                                            <img src="{{ asset($col->cover_photo) }}"
                                                                 alt="{{ ($col->cover_photo) }}">
                                                        </div>
                                                    </a>
                                                </div>

{{--                                                <div class="col-md-4">--}}
{{--                                                    <a href="{{  route('frontend.collection',$col->slug) }}">--}}
{{--                                                        <div class="categories_product_thumb">--}}
{{--                                                            <img src="{{ asset($col->cover_photo_2) }}"--}}
{{--                                                                 alt="{{ ($col->cover_photo_2) }}">--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-md-4">--}}
{{--                                                    <a href="{{  route('frontend.collection',$col->slug) }}">--}}
{{--                                                        <div class="categories_product_thumb">--}}
{{--                                                            <img src="{{ asset($col->cover_photo_3) }}"--}}
{{--                                                                 alt="{{ ($col->cover_photo_2) }}">--}}
{{--                                                        </div>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

{{--        <div class="container"--}}
{{--             style="display: flex; justify-content: center; margin-top: -20px; margin-bottom: 20px;">--}}
{{--            <button class="load-more"--}}
{{--                    id="load-more-btn"--}}
{{--                    type="button"--}}
{{--                    data-page="{{request()->query('page') ?? 1}}">--}}
{{--                Load More--}}
{{--            </button>--}}
{{--        </div>--}}

    @endif
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            const collectionContainer = $('#collection-container');
            const loadMore = $('#load-more-btn');

            loadMore.on('click', function (e) {
                $(this).attr('disabled', true);
                const page = Number($(this).attr('data-page')) + 1;
                $.post('{{route('frontend.global_collections.load-more.ajax')}}',
                    {
                        page: page
                    },
                    function (res) {
                        const collections = res;
                        if (collections.length > 0) {
                            template(collections);
                            loadMore.attr('data-page', page);
                        } else {
                            loadMore.attr('data-page', page);
                            loadMore.css('display', 'none');
                        }
                    }
                )
            });

            function template(collections) {
                const rows = Math.ceil(collections.length / 4);
                let template = '';
                for (let i = 0; i < rows; i++) {
                    template += `<div class="categories_product_area mb-40">
                                    <div class="container">
                                        <div class="categories_product_inner">
                                            <div class="row">`;
                    for (let j = (i * 6); j < (i + 1) * 6; j++) {
                        if (typeof collections[j] !== 'undefined') {
                            template += `<div class="col-md-3">
                                <div class="single_categories_products  collection-hover" style="padding-bottom: 10px;border: 1px solid rgba(0,0,0,0.08);">
                                    <div class="row text-center padding ">
                                        <div class="categories_product_content col-md-12" style="text-align: center">
                                            <a href="${collections[j].url}">
                                                <h4>${collections[j].title}</h4>
                                                <p>${collections[j].items_count} Products</p>
                                            </a>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="${collections[j].url}">
                                                <div class="categories_product_thumb ">
                                                    <img src="${collections[j].cover_photo}" alt="">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="${collections[j].url}">
                                                <div class="categories_product_thumb">
                                                    <img src="${collections[j].cover_photo_2}" alt="">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="${collections[j].url}">
                                                <div class="categories_product_thumb">
                                                    <img src="${collections[j].cover_photo_3}" alt="">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        }
                    }
                    template += `</div></div></div></div>`;
                }

                collectionContainer.append(template);
                loadMore.attr('disabled', false);
            }
        });
    </script>
@endpush
