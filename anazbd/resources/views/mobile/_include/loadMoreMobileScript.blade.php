<script>
    function loadMoreProducts(postData) {
        // $('#load-more').hide();
        $('.anaz_loader').show();

        let loadProductURL = "{{{ route('load.products') }}}"
            let url = "{{{ url('/') }}}"


            console.log('cp '+currentPage+' '+'lp '+lastPage);



            {{--  if (currentPage < lastPage){  --}}
                if (currentPage < lastPage){
                    $.ajax({
                    url: url2+nextPage,
                    method: 'GET',
                    data: postData,
                    success: function (data) {
                        nextPage++;
                        currentPage++;
                        var dataToAttach = "";
                        data.data.forEach(element => {
                            var color, size, onclick, ratingHTML = "<div class='product-rating'>", name = String(element.name);
                            if(element.variants[0].color === null){
                                color = 0;
                            }else{
                                color = element.variants[0].color;
                            }
                            if(element.variants[0].size === null){
                                size = 0;
                            }else{
                                size = element.variants[0].size;
                            }
                            onclick = "heartChange(this,"+'"'+element.slug+'"'+")";
                            let priceHTML = ""
                            if (element.salePercentageAttached) {
                                priceHTML = "<p class='sale-price'>&#2547; "+element.salePriceAttached+"<span>&#2547;"+element.priceAttached+"</span></p>";
                            }else{
                                priceHTML = "<p class='sale-price'>&#2547;"+element.original_price+"</p>";
                            }
                            if(element.rating > 0){
                                for(var i = 0; i < element.rating; i++){
                                    ratingHTML += "<i class='lni lni-star-filled'></i>"
                                }
                            }
                            ratingHTML += "</div>";

                            // dataToAttach += "<div class='col-6 col-md-4 col-lg-3'><div class='card top-product-card'><div class='card-body'><span class='badge badge-success'>Sale</span><a class='wishlist-btn' href='#'><i class='lni lni-heart'></i></a><a class='product-thumbnail d-block' href='"+url+"/product/"+element.slug+"'><img style='height: 200px;width: auto;' class='mb-2' src='"+url+'/'+element.feature_image+"' alt='"+url+'/'+element.feature_image+"' /></a><a class='product-title d-block' href=''"+url+"/product/"+element.slug+"''>"+element.name+"</a>"+priceHTML+"<a class='btn btn-success btn-sm add2cart-notify' href='#'><i class='lni lni-plus'></i></a></div></div></div>";
                            dataToAttach += "<div class='col-6 col-md-4 col-lg-3' style='margin-top: 0;padding: 0;'><div class='card top-product-card'><div class='card-body'><span class='badge badge-success'>Sale</span><div style='text-align: left; width: 100%'><a class='" + (element.isWishlisted ? "fas fa-heart" : "far fa-heart") + "' style='font-size: 25px; color: #a52a2a; margin-left: 81%; margin-top: 5%;' onclick='"+onclick+"'></a></div><a class='product-thumbnail d-block' href='"+url+"/product/"+element.slug+"'><img style='height: 200px;width: auto;' class='mb-2' src='"+url+'/'+element.feature_image+"' alt='"+url+'/'+element.feature_image+"' /></a><a class='product-title d-block' href='"+url+"/product/"+element.slug+"'>"+name.substring(0,22)+"..</a>"+priceHTML+ratingHTML+"<div class='add_to_cart'><a class='btn btn-success btn-sm add2cart-notify' href='#' data-item='"+element.slug+"' data-color='"+color+"' data-size='"+size+"'><i class='lni lni-plus'></i></a></div></div></div></div>";

                        });
                        $('.anaz_loader').hide();
                        // $('#load-more').show();

                        $('#product-card-holder').append(dataToAttach);
                    },
                    error: function (error) {
                        console.error(error)
                    }
                })
            }else{
                console.log('this is the last page!');
                $('.anaz_loader').hide();
            }





    }
</script>
