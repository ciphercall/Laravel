        <div class="row" style="padding-top: 21px;">
            <div class="col-lg-12 col-md-12">
                <figure class="single_banner">
                    <div class="banner_thumb" style="height: 332px;border-radius: 15px;background-image: url('https://drive.google.com/uc?export=download&id=1rnKvgWTG-PV2aeMfLCJ2NfC3dXKtMrR6')">
                        @if (!empty($banner->image))
                            <a href="{{ $banner->slug ?? '#' }}">
                                <img loading="lazy" src="{{  asset($banner->image) }}" alt="{{ $banner->image  }}" style="width: 74%;height: 284px;max-width: 1920px;left: 14%;top: 7%;position: relative;border-radius: 16px;">
                            </a>
                        @endif
                    </div>
                </figure>
            </div>
        </div>
