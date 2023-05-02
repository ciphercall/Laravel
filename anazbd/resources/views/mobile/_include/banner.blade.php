@if(!empty($banner->image))
<div class="banner">
    <div class="">
        <div class="row">
            <div class="col-md-12">
            <img src="{{ asset($banner->image) }}" alt="Banner Image" style="
                height: 140px;
                width: 100%;
                ">
            </div>
        </div>
    </div>
</div>
@endif
