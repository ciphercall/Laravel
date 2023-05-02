<script>
        function loadMoreProducts(postData,bootstrapClass = "col-lg-3 col-md-4 col-sm-6") {
            $('#load-more').hide();
            $('.anaz_loader').show();

            let loadProductURL = "{{{ route('load.products') }}}"
                let url = "{{{ url('/') }}}"
                $.ajax({
                    url: loadProductURL,
                    method: 'POST',
                    data: postData,
                    success: function (data) {
                        var dataToAttach = "";
                        data.forEach(element => {
                            let priceHTML = ""
                            let saleBannerHTML = ""
                            let name = ""
                            let ratingHTML = ""
                            let firstVarient = ""
                            let color = ""
                            let size = ""
                            if (element.salePriceAttached) {
                                saleBannerHTML += "<div class='label_product'><span class='label_sale'>Sale</span></div>";
                                priceHTML = "<span class='old_price'>TK "+element.priceAttached+"</span><span class='current_price'>TK "+element.salePriceAttached+"</span>";
                            }else{
                                priceHTML = "<span class='current_price'>TK "+element.priceAttached+"</span>";
                            }
                            if(element.name.length > 0){
                                name = element.name.substring(0,38)
                            }
                            if(element.rating > 0){
                                for(var i = 0; i < element.rating;i++){
                                    ratingHTML += "<li><span class='fa fa-star checked'></span></li>";
                                }
                            }
                            if(Array.isArray(element.variants) ){
                                if(element.variants[0].color_id != null){
                                    color = element.variants[0].color.name
                                }
                                if(element.variants[0].size_id != null){
                                    color = element.variants[0].size.name
                                }
                            }
                            let wishlistedClass = '';
                            if(element.isWishlisted){
                                wishlistedClass = 'fas fa-heart';
                            }else{
                                wishlistedClass = 'far fa-heart';
                            }

                            dataToAttach += "<div class='"+bootstrapClass+"'><article class='single_product'><div style='text-align: left; width: 100%'><a class='"+ wishlistedClass +"' style='font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;' onclick=heartChange(this,'"+String(element.slug)+"')></a></div><figure style='width: 100%;'><div class='product_thumb'><a class='primary_img' href='"+url+"/product/"+element.slug+"'><img src='"+url+'/'+element.thumb_feature_image+"'' alt="+element.name+"></a>"+saleBannerHTML+"</div><div class='product_content grid_content'><div class='product_content_inner'><h4 class='product_name'><a href='"+url+"/product/"+element.slug+"'>"+name+"</a></h4><div class='product_rating'><ul>"+ratingHTML+"</ul></div><div class='price_box'>"+priceHTML+"</div><div class='add_to_cart'><a href='#' data-item='"+element.slug+"' data-color='"+color+"' data-size='"+size+"'>Add to cart</a></div></div><div class='product_content list_content' style='width: 100%;'><h4 class='product_name'><a href='"+url+"/product/"+element.slug+"'>+name+</a></h4><div class='product_rating'><ul>+ratingHTML+</ul></div><div class='price_box'>+priceHTML+</div><div class='product_desc'><p>+element.short_description+</p></div><div class='add_to_cart'><a href='#' data-item='"+element.slug+"' data-color='"+color+"' data-size='"+size+"'>Add to cart</a></div></div></div></div></figure></article></div>"
                        });

                        $('.anaz_loader').hide();
                        $('#load-more').show();


                        $('#product-card-holder').append(dataToAttach);
                    },
                    error: function (error) {
                        console.error(error)
                    }
                })
        }
    </script>
