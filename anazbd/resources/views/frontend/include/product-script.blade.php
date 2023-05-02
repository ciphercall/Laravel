@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script>
        function heartChange(x, slug) {
            let authenticated = "{{ auth()->check() }}"
            let url = "{{{ url('/') }}}"

            if (authenticated) {
                if (x.className == "far fa-heart") {
                    x.className = "fa fa-heart";
                    // add to wishlist
                    $.ajax({
                        url: url + '/wishlist/' + slug,
                        method: 'GET',
                        success: function (data) {
                            // $('#wishtlistCount').value('')
                            $('.wishlist_count').html(data.wishcount);
                        },
                        error: function (error) {
                            x.className = "far fa-heart";
                        }
                    })
                } else {
                    x.className = "far fa-heart";
                    console.log('deleting..')
                    // delete from wishlist
                    $.ajax({
                        url: url + '/wishlist/remove/' + slug,
                        method: 'GET',
                        success: function (data) {
                            console.log(data)
                            $('.wishlist_count').html(data.wishcount);
                        },
                        error: function (error) {
                            x.className = "fa fa-heart";
                        }
                    })
                }
            } else {
                if (x.className == "far fa-heart") {
                    x.className = "fa fa-heart";
                    // add to wishlist
                    $.ajax({
                        url: url + '/wishlist/no_auth/' + slug,
                        method: 'GET',
                        success: function (data) {
                            // $('.wishlist_count').html(data.wishcount);
                            console.log(data);

                            // storing items to local storage.....begin
                            // localStorage.removeItem("itm_noauth");
                            if (localStorage.getItem("itm_noauth") != null) {
                                //trying with json
                                var v = data.slug;
                                var array=JSON.parse(localStorage.getItem("itm_noauth"));   //converting string to array format
                                array[array.length] = data;
                                var str_array = JSON.stringify(array);   //converting array to json format
                                localStorage.setItem("itm_noauth", str_array);


                                for (var i = 0; i < array.length; i++) {
                                    if (array[i].slug == v) {
                                        // obj[i].name = "Thomas";
                                        console.log("checking name from array: "+array[i].name);
                                        break;
                                    }
                                }

                            } else {
                            }
                            console.log("checking local storage: ",JSON.parse(localStorage.getItem("itm_noauth")));
                            // console.log("array: ", arr);

                            // storing items to local storage.....end

                        },
                        error: function (error) {
                            x.className = "far fa-heart";
                        }
                    })
                } else {
                    x.className = "far fa-heart";
                    console.log('deleting..')
                    // delete from wishlist
                    $.ajax({
                        url: url + '/wishlist/remove/' + slug,
                        method: 'GET',
                        success: function (data) {
                            console.log(data)
                            $('.wishlist_count').html(data.wishcount);
                        },
                        error: function (error) {
                            x.className = "fa fa-heart";
                        }
                    })
                }
            }

        }

        $(document).ready(function () {


            $(document).on('click', '.add_to_cart a', function (e) {
                e.preventDefault();

                const item = $(this).data('item').toString().trim();
                const color = $(this).data('color').toString().trim();
                const size = $(this).data('size').toString().trim();

                if ({{auth('web')->id() ?? 'false'}}) {
                    updateCart(false, item, color, size);
                } else {
                    //iframeDialog('{{route('frontend.user.login.iframe')}}');
                    //window.iframeSuccess = function (ctx) {
                    //    updateCart(true, item, color, size);
                    //}
                    window.location.href = "{{ url('/login') }}"
                    return false;
                }
            });

            function updateCart(shouldReload = false, item, color, size) {
                $.post('{{route('frontend.cart.store.ajax')}}',
                    {
                        item: item,
                        color: color,
                        size: size,
                        qty: 1
                    },
                    function (res) {
                        if (res.status) {
                            //$('.ui-dialog-content').dialog('close');
                            //iframeDialog('{{route('frontend.cart.show')}}?item='+res.item, shouldReload);
                            swal({
                                icon: "success",
                                buttons: false,
                                timer: 1000
                            });
                            $('.cart_count').text(res.count);
                        }
                    });
            }

            function iframeDialog(url, shouldReload = false) {
                const iframe = $(`<iframe src="${url}"
                                      frameborder="0"
                                      style="width:100%;height:100%;">
                              </iframe>`);

                const root = $("<div></div>");
                root.append(iframe).dialog({
                    autoOpen: true,
                    width: 810,
                    height: 550,
                    modal: true,
                    create: function (e, ui) {
                        $("body").css({overflow: 'hidden'});
                    },
                    beforeClose: function (e, ui) {
                        $("body").css({overflow: 'inherit'})
                    }
                });

                const closeDialog = $('<a href="#" class="fa fa-times" style="position: absolute; top: 10px; right: 20px; font-size: 18px"></a>');
                closeDialog.on('click', function (e) {
                    e.preventDefault();
                    $('.ui-dialog-content').dialog('close');
                    if (shouldReload)
                        window.location.reload(true);
                });
                root.append(closeDialog)

                const iframeBody = $('body', iframe[0].contentDocument);
                iframeBody.html('<div style="width: 100%; height: 100%; background: white"></div>');

                $('.ui-dialog-titlebar').hide();
                $('.ui-widget-content').css('border', 'none');
            }
        });
    </script>
@endpush
