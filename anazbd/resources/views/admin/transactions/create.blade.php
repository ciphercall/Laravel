@extends('admin.layout.master')
@section('title','Transaction Create')
@section('page_header')
    <i class="material-icons">receipt</i> Transaction Create
@endsection
@push('css')
    <style>
        .hidden {

            {{--display: {{$order->id == null ? 'none' : 'block'}};--}}
                 display: block;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="card rounded col-sm-12" style="background-color: rgb(13,21,91);">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group" data-url="{{url('admin/transactions/createAjax')}}" id="trnsCrPst">
                            <label for="exampleFormControlSelect1">Select Order no</label>
                            <select class="form-control chosen-select" name="order_no" id="order_no">
                                <option>Select Order</option>
                                @forelse ($order as $item)
                                    <option value="{{$item->id}}">{{ $item->no }}</option>
                                @empty
                                    <option>No Orders Available</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row hidden" id="items-div">
                    <div class="col-12 justify-content-center p-2 border border-primary rounded" style="color: white;background: rgba(255,255,255, 0.3);">
                        <h4>Seller and Orders</h4>
                    </div>
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody id="items">
                        <tr class="row" id="sellerRow" style="margin: 6px 0 0 0;">
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
{{--            <div id="transBtnDiv" class="col-12" style="display: none; border: 1px solid grey;text-align: center;width: 98.7%;margin-left: 5px;border-radius: 3px;min-height: 54px;margin-bottom: 8px;margin-top: -22px;background-color: lightsalmon;">--}}
{{--                <div class="col-text-center" style="margin-top: 6px;">--}}
{{--                    <input id="btnTrans" type="button" class="btn btn-sm btn-info" value="Create Transaction"/>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
{{--        <div class="card rounded col-sm-5">--}}
{{--            <div class="card-body" style="max-height: 31%;margin-top: 104px;">--}}
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <div class="row hidden" id="items-div">--}}
{{--                    <div class="col-12 justify-content-center p-2 border border-primary rounded" style="background-color: rgb(156,39,176); color: white;">--}}
{{--                        <h4>Create Transaction</h4>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div id="transBtnDiv" class="col-12" style="border: 1px solid grey;text-align: center;width: 97.9%;margin-left: 5px;border-radius: 3px;min-height: 150px;max-height: 35%;margin-bottom: 8px;margin-top: -22px;background-color: lightsalmon;display: none;">--}}
{{--                <div class="col-text-center" style="margin-top: 10%;">--}}
{{--                    <input id="btnTrans" type="button" class="btn btn-sm btn-info" value="Create Transaction" style="min-height: 54px;min-width: 231px;font-size: 20px;"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
@push('js')
    <script>
        $('#order_no').on('change', function () {
            var val = $("#order_no").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post($("#trnsCrPst").data('url'), {
                id: val
            })
                .done(function (res) {
                    if (res.length === 0){
                        $('#transBtnDiv').hide();
                    }
                    console.log(res);
                    $('#sellerRow div').remove();
                    for (var i = 0; i < res.length; i++) {
                        var result = res[i].seller.name;
                        var template = `<div style="border: 1px solid grey;margin: 1px 0 5px 0;padding: 0px 7px 0px 7px;border-radius: 3px;text-align: center;color: white;background: rgba(255,255,255, 0.3);" class="col-12"><h5 style="font-size: 27px;">` + result + `</h5>
                        <div class="row" style="margin-bottom: 7px;">
                        <div class="col-8">
                        <div id="seller` + i + `" style="margin-bottom: 5px;">
                        </div>
                         <div class="row" style="border: 1px solid grey;margin: 1px 1px 1px 1px;;min-height: 50px;">
                         <div id="sellerTotal` + i + `" class="col-12" style="text-align: right;border-right: 1px solid grey;text-align: center;font-size: 21px;text-align: right;background-color: lightslategray;color: white;">
                         </div>
                         </div>
                        </div>
                        <div class="col -4">
                        <div class="col-text-center" style="border: 1px solid grey;height: 100%;border-radius: 2px;background-color: rgba(255,160,122,0.2);">
                        <a class="row" style="min-height: 40%;">
                        <div class="col" style="max-height: 52px;font-size: 23px;font-family: cursive;">
                        Make a Transaction
                        </div>
                        </a>
<form action=""></form>
                            <input id="btnTrans` + i + `" type="button" class="btn btn-sm btn-info" value="Create Transaction" style="font-size: 20px;position: relative;box-shadow: 8px 7px 0px 2px #888888;min-width: 328px;"/>
                        </div>
                        </div>
                        </div>
                        </div>`;
                        $('#sellerRow').append(template);
                        for (var j = 0; j < res[i].items.length; j++) {

                            var bkColor = "";
                            var  sts = "";
                            $('#sellerTotal'+i).text("Total: "+res[i].total);
                            if (res[i].items[j].chalan === 0) {
                                bkColor = "lightpink";
                                sts = "Not Delivered";
                                $('#btnTrans'+i).val("Can't Create Transaction").attr('disabled','');
                            } else {
                                bkColor = "lightgreen";
                                sts = "Delivered";
                                $('#btnTrans'+i).val("Create Transaction").attr('disabled',false);
                            }

                            $("#seller" + i).append(`<div class="row" style="border: 1px solid grey;margin: 1px 1px 1px 1px;min-height: 50px;background: rgba(255,255,255, 0.3);">
                                                        <div class="col-9" style="border-right: 1px solid grey;text-align: center;">
                                                        <a style="font-size: 20px;">` + res[i].items[j].product.name + `</a>
                                                        </div>
                                                        <div class="col-3" style="border-right: 1px solid grey;text-align: center;font-size: 20px;">
                                                         `+sts+`
                                                        </div>
                                                        </div>`);
                        }
                        $('#transBtnDiv').show();
                    }
                })
                .fail(function (xhr, status, error) {
                    // error handling
                    // console.log('xhr: '+xhr+' '+'status: '+status+' '+'error: '+error);
                });

        });
    </script>
@endpush
