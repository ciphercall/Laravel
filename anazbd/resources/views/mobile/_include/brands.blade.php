<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"
        integrity="sha512-pXR0JHbYm9+EGib6xR/w+uYs/u2V84ofPrBpkgLYyKvhZYJtUUvKSy1pgi8tJZAacsPwgf1kbhI4zwgu8OKOqA=="
        crossorigin="anonymous"></script>

<style>
    .brand-container {
        min-width: 342px;
        min-height: 99px;
        /* margin-left: 7px; */
        /* margin-right: 7px; */
        padding: 0;
        max-width: 95%;
        margin-top: 12px;
        margin-bottom: 11px;
    }

    .child-container {
        width: 65px;
        height: 86px;
        background-color: white;
        box-shadow: 2px 2px 6px #888888;
        border-radius: 4px;
    }

    .brand-thumb {
        width: 60px;
        height: 60px;
        /*background-color: blueviolet;*/
    }

    .brand-name {
        /*background-color: red;*/
        width: 60px;
        height: 23px;
        text-align: center;
        font-size: 8px;
    }

    #brand-box div.col {
        padding: 0;
    }

    .brand-thumb img {
        width: 60px;
        height: 60px;
        /* background-color: blueviolet; */
        position: relative;
        left: -3%;
    }
</style>


<div class="container brand-container">
    <div class="row">
        <div class="col-4">
            <h6 class="pl-1">Brands</h6>
        </div>
        <div class="col-8">
            {{--            <a class="btn btn-sm" style="margin-bottom: 2px;position: relative;left: 69%;background: linear-gradient(to right, rgba(245,213,54,0.81) 0%, rgba(240,24,78,0.72) 100%);"><span style="font-size: .875rem;">View All</span></a>--}}
        </div>
    </div>
    <div class="row" id="brand-box" style="width: 100%;margin: 0;">
        {{--        <div class="col">--}}
        {{--            <div class="container child-container">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-12" style="padding: 0;">--}}
        {{--                        <div class="brand-thumb"><img src="" alt="thumboo"></div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-12" style="padding: 0;">--}}
        {{--                        <div class="brand-name"><strong>brand</strong></div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
</div>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.get('{{route("frontend.get-brands")}}')
            .done(function (res) {
                let randomItem = res[Math.floor(Math.random() * res.length)]
                console.log('this is our brand detail: ' + JSON.stringify(randomItem));

                // appending data
                // let data = '<div class="col"><div class="container child-container"><div class="row"><div class="col-12" style="padding: 0;"><div class="brand-thumb"><img src="" alt="brand thumb"></div></div></div><div class="row"><div class="col-12" style="padding: 0;"><div class="brand-name"><h6>brand</h6></div></div></div></div></div>';
                let baseUrl = "{{asset('/')}}";
                let slash = "/";
                for (let i = 0, h = (Math.floor(Math.random() * res.length)); i < 10; i++, h = (Math.floor(Math.random() * res.length))) {
                    // $('#brand-box').append('<h6>'+res[h].name+'<h6>');

                    //checking if image is available
                    let image = res[h].image;
                    if (image === null || image === "") {
                        baseUrl = "";
                        slash = "";
                        image = "https://drive.google.com/uc?export=download&id=1XaDf3lLjAOZKcp6F2MPBACJPDbPb7EGS";
                    }

                    $('#brand-box').append('<div class="col" style="margin-bottom: 5px;"><div class="container child-container"><div class="row"><div class="col-12" style="padding: 0;"><div class="brand-thumb"><img src="' + baseUrl + slash + image + '" alt="brand thumb"></div></div></div><div class="row"><div class="col-12" style="padding: 0;"><div class="brand-name"><strong>' + res[h].name.substring(0, 20) + '</strong></div></div></div></div></div>');
                }
            })
            .fail(function (xhr, status, error) {
                // error handling
                // console.log('xhr: '+xhr+' '+'status: '+status+' '+'error: '+error);
                // console.log('may day: '+JSON.parse(xhr.responseText).errors.mobile);
                // console.log('may day: '+JSON.stringify(xhr));
                // $('#otpStatus h3').html(JSON.parse(xhr.responseText).errors.mobile).css('color', 'red');

            });
    });
</script>
