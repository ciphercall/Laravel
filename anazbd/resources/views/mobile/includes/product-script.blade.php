@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script>
        function heartChange(x,slug) {
            let authenticated = "{{ auth()->check() }}"
            let url = "{{{ url('/') }}}"

            if (authenticated){
                if (x.className == "far fa-heart") {
                    x.className = "fa fa-heart";
                    // add to wishlist
                    $.ajax({
                        url: url+'/wishlist/'+slug,
                        method: 'GET',
                        success: function(data){
                            // $('#wishtlistCount').value('')
                            $('.wishlist_count').html(data.wishcount);
                        },
                        error: function(error){
                            x.className = "far fa-heart";
                        }
                    })
                }else{
                    x.className = "far fa-heart";
                    console.log('deleting..')
                    // delete from wishlist
                    $.ajax({
                        url: url+'/wishlist/remove/'+slug,
                        method: 'GET',
                        success: function(data){
                            console.log(data)
                            $('.wishlist_count').html(data.wishcount);
                        },
                        error: function(error){
                            x.className = "fa fa-heart";
                        }
                    })
                }
            }

        }

        $(document).ready(function (){


            $(document).on('click','.add_to_cart a', function (e) {
                e.preventDefault();

                const item = $(this).data('item').toString().trim();
                const color = $(this).data('color').toString().trim();
                const size = $(this).data('size').toString().trim();

                if ("{{{auth('web')->check()}}}") {
                    updateCart(false, item, color, size);
                } else {
                    window.location.href = "{{ url('/login') }}"
                    return false;
                }
            });
            $(document).on('click','#add_to_cart_mobile',function(){
               const qty = $('.cart-quantity-input').val();
               const item = $(this).data('item').toString().trim();
                const color = $(this).data('color').toString().trim();
                const size = $(this).data('size').toString().trim();
                const limit = $(this).data('max');

                if ("{{{auth('web')->check()}}}") {
                    if(Number(limit) >= Number(qty) && Number(qty) > 0){
                        updateCart(false, item, color, size,qty);
                    }else{
                        swal({
                            buttons: false,
                            timer: 1000,
                            icon: 'error',
                            title: 'Failed.',
                            text: "Minimum Order Quantity is 1 and Maximum Valid quantity is "+limit,

                        });
                    }

                } else {
                    window.location.href = "{{ url('/login') }}"
                    return false;
                }
            });

            function updateCart(shouldReload = false, item, color, size, quantity = 1) {
                $.post("{{route('frontend.cart.store.ajax')}}",
                    {
                        item: item,
                        color: color,
                        size: size,
                        qty: quantity
                    },
                    function (res) {
                        if (res.status) {
                            swal({
                                icon: "success",
                                buttons: false,
                                timer: 1000
                              });
                            $('.cart_count').text(res.count);
                        }
                    });
            }
        });
    </script>
@endpush
