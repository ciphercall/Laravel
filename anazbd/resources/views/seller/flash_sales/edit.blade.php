@extends('material.layouts.master')
@section('title', 'Edit Flash Sale')
@section('page-header')
    <i class="material-icons">edit</i> Edit Flash Sale
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
    <style>
        .bootstrap-timepicker-widget table td input {
            width: 70px;
        }

        th, td {
            text-align: center;
            vertical-align: middle !important;
        }

        .chosen-container {
            text-align: center;
        }

        .flash-sale-info {
            color: #0098d4;
            font-weight: bold;
        }

        .flash-sale-danger {
            color: #d4002a;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
<div class="card">
    <div class="row card-header-primary">
        <div class="col">
            <h5>Edit Flash Sale</h5>
        </div>
        <div class="col text-right">
            <a href="{{route('seller.campaign.flash_sale.index')}}" class="btn btn-success">Flash Sale List</a>
        </div>
    </div>
    <div class="card-body">
            <form role="form"
                  method="post"
                  class="form-horizontal"
                  enctype="multipart/form-data"
                  action="{{route('seller.campaign.flash_sale.update', collect($sale_items)->first()->start_time)}}">
            @csrf
    
            <div class="row">
                <!-- Date -->
                <div class="col form-group">
                    <label for="date">
                        Date <sup class="text-danger">*</sup>
                    </label>
                    <div>
                        <input type="text"
                               id="date"
                               name="date"
                               placeholder="2020-12-01"
                               value="{{collect($sale_items)->first()->start_time->format('Y-m-d')}}"
                               style="width: 100%; text-align: center">
                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                    </div>
                </div>

                <!-- Date Till -->
                <div class="col form-group">
                    <label for="date">
                        Date <sup class="text-danger">*</sup>
                    </label>
                    <div>
                        <input type="text"
                               id="date"
                               name="date_till"
                               placeholder="2020-12-01"
                               value="{{collect($sale_items)->first()->end_time->format('Y-m-d')}}"
                               style="width: 100%; text-align: center">
                        <strong class="text-danger">{{ $errors->first('date_till') }}</strong>
                    </div>
                </div>
                <!-- Time -->
                <div class="col form-group">
                    <label for="time">
                        Time <sup class="text-danger">*</sup>
                    </label>
                    <div>
                        <select class="chosen-select"
                                id="time"
                                name="time"
                                data-placeholder="- Time -">
                            <option value=""></option>
                            @foreach($sales as $sale)
                                <option value="{{$sale->id}}"
                                        data-min-percentage="{{$sale->min_percentage}}"
                                        data-max-items="{{$sale->max_items_per_seller}}"
                                        {{$sale->id == collect($sale_items)->first()->flash_sale_id ? 'selected' : ''}}>
                                    {{$sale->start_time . ' - ' . $sale->end_time}}
                                </option>
                            @endforeach
                        </select>
                        <strong class="red">{{ $errors->first('time') }}</strong>
                    </div>
                </div>
            </div>
    
                <div class="form-group">
                    <div class="col-sm-12">
                        @php
                        $sale_items = collect($sale_items);
                        $min_percentage = collect($sales)->where('id', $sale_items->first()->flash_sale_id)->first()->min_percentage;
                        $max_items = collect($sales)->where('id', $sale_items->first()->flash_sale_id)->first()->max_items_per_seller;
                        $remaining = $max_items - $sale_items->count();
                        @endphp
                        <strong class="flash-sale-info">
                            {{$remaining > 0 ? ('Min Percentage: '.$min_percentage.'%, Max Items: '.$max_items.', Remaining: '.$remaining) : ''}}
                        </strong>
                        <strong class="flash-sale-danger">
                            {{$remaining <= 0 ? ('Min Percentage: '.$min_percentage.'%, Max Items: '.$max_items.', Remaining: 0') : ''}}
                        </strong>
                    </div>
                </div>
    
                <div class="form-group">
    
                        <table class="table table-bordered text-center" id="flash-table">
                            <thead>
                            <tr>
                                <th style="width: 10%">SL</th>
                                <th style="width: 30%">Item <sup class="red">*</sup></th>
    {{--                            <th style="width: 20%">Quantity <sup class="red">*</sup></th>--}}
                                <th style="width: 20%">Sale Percentage <sup class="red">*</sup></th>
                                <th style="width: 15%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--templatte--}}
                            @foreach($sale_items as $s_item)
                            <tr>
                                <td class="sl">{{$loop->iteration}}</td>
                                <td>
                                    <select class="chosen-select item"
                                            name="s_item[{{$s_item->id}}]"
                                            data-placeholder="- Item -">
                                        <option value=""></option>
                                        @foreach($items as $item)
                                            <option value="{{$item->id}}"
                                            {{$item->id == $s_item->item_id ? 'selected' : ''}}>
                                                {{$item->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
    {{--                            <td class="small-input">--}}
    {{--                                <input class="input-sm qty"--}}
    {{--                                       type="text"--}}
    {{--                                       name="s_qty[{{$s_item->id}}]"--}}
    {{--                                       required--}}
    {{--                                       placeholder="100"--}}
    {{--                                       style="width: 100%"--}}
    {{--                                       value="{{$s_item->stock}}">--}}
    {{--                            </td>--}}
                                <td class="small-input">
                                    <input class="input-sm percentage"
                                           name="s_percentage[{{$s_item->id}}]"
                                           type="text"
                                           required
                                           placeholder="10"
                                           style="width: 100%"
                                           value="{{$s_item->percentage}}">
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm btn-corner">
                                        <button type="button" onclick="genRow()"
                                                class="btn btn-sm btn-primary"><span
                                                class="bolder">+</span>
                                        </button>
                                        <button type="button" onclick="deleteRow(this)"
                                                class="btn btn-sm btn-danger"><span
                                                class="bolder">-</span></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
    
                <!-- Buttons -->
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <button id="add-button" class="btn btn-sm btn-success submit">
                            <i class="fa fa-save"></i> Update
                        </button>
    
                        <a href="{{route('seller.campaign.flash_sale.index')}}" class="btn btn-sm btn-gray">
                            <i class="fa fa-refresh"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
    </div>
</div>
    
@endsection

@push('js')
    <script src="{{asset('assets/js/bootstrap-timepicker.min.js')}}"></script>
    <script>
        let percentage = {{$min_percentage}};
        let maxItems = {{$max_items}};
        let remainingItems = maxItems - {{collect($sale_items)->count()}};
        let addButton, flash_table_body, date, time;

        $(document).ready(function () {
            chosenTrigger();

            addButton = $('#add-button');
            flash_table_body = $('#flash-table tbody');
            date = $('#date');
            time = $('#time');

            date.datepicker({
                format: 'yyyy-mm-dd',
                startDate: 'today',
            }).on('changeDate', function () {
                updateRemainingItems();
                checkInputs();
            });

            time.on('change', function () {
                const selectedOption = $(this).find('option:selected');
                percentage = Number(selectedOption.data('min-percentage'));
                maxItems = Number(selectedOption.data('max-items'));

                updateRemainingItems();
                checkInputs();
            });

            $('select.item').on('change', checkInputs);
            $('input.qty').on('input', checkInputs);
            $('input.percentage').on('input', checkInputs);
        });

        function shouldGenerateRow() {
            return checkInputs() && $('#flash-table tbody tr').length < maxItems;
        }

        function genRow() {
            if (!shouldGenerateRow()) return;

            const template = `<tr><td class="sl"></td>
    <td>
        <select class="chosen-select item"
                name="item[]"
                data-placeholder="- Item -">
            <option value=""></option>
        @foreach($items as $item)
            <option value="{{$item->id}}">{{$item->name}}</option>
        @endforeach
            </select>
        </td>
        <td class="small-input">
            <input class="input-sm percentage"
                   name="percentage[]"
                   type="text"
                   required
                   placeholder="10"
                   style="width: 100%"
                   value="">
        </td>
        <td>
            <div class="btn-group btn-group-sm btn-corner">
                <button type="button" onclick="genRow()"
                        class="btn btn-sm btn-primary"><span
                        class="bolder">+</span>
                </button>
                <button type="button" onclick="deleteRow(this)"
                        class="btn btn-sm btn-danger"><span
                        class="bolder">-</span></button>
            </div>
        </td>
    </tr>`;

            flash_table_body.append(template);
            let sl = 1;
            $('td.sl').each(function () {
                $(this).text(sl++)
            });
            $('select.item').on('change', checkInputs);
            // $('input.qty').on('input', checkInputs);
            $('input.percentage').on('input', checkInputs);

            chosenTrigger();
            checkInputs();
        }

        function deleteRow(el) {
            if (flash_table_body.find('tr').length !== 1) {
                $(el).closest('tr').remove();
                let sl = 1;
                $('td.sl').each(function () {
                    $(this).text(sl++)
                });
                remainingItems += 1;
                checkInputs();
            }
        }

        function chosenTrigger() {
            $('.chosen-select').chosen({
                width: '100%'
            });
        }

        function updateRemainingItems() {
            if (date.val() && time.val()) {
                $.get('{{route("seller.campaign.flash_sale.count",["date"=>"date","time"=>"time"])}}'
                        .replace('date', date.val())
                        .replace('time', time.val()),
                    function (res) {
                        if (res.count >= 0) {
                            remainingItems = clamp(maxItems - Number(res.count), 0, Infinity);
                        }

                        if (remainingItems > 0){
                            $('.flash-sale-info').text(`Min Percentage: ${percentage}%, Max Items: ${maxItems}, Remaining: ${remainingItems}`);
                            $('.flash-sale-danger').text(``);
                        }
                        else{
                            $('.flash-sale-info').text(``);
                            $('.flash-sale-danger').text(`Min Percentage: ${percentage}%, Max Items: ${maxItems}, Remaining: ${remainingItems}`);
                        }
                        checkInputs();
                    });
            }
        }

        function checkItems() {
            const items = [];
            let flag = true;
            $('select.item').each(function () {
                if ($(this).val().toString() === '' || items.includes(Number($(this).val()))) {
                    flag = false;
                    $(this).parent().find('.chosen-single').css('border', '1px solid orange');
                } else {
                    $(this).parent().find('.chosen-single').css('border', '1px solid #d5d5d5');
                    items.push(Number($(this).val()));
                }
            });
            return flag;
        }

        // function checkQuantities() {
        //     let flag = true;
        //     $('input.qty').each(function () {
        //         if ($(this).val().toString() === '') {
        //             flag = false;
        //             $(this).css('border', '1px solid orange');
        //         } else {
        //             $(this).css('border', '1px solid #d5d5d5');
        //         }
        //     });
        //     return flag;
        // }

        function checkPercentages() {
            let flag = true;
            $('input.percentage').each(function () {
                if ($(this).val().toString() === '' || Number($(this).val()) < percentage) {
                    flag = false;
                    $(this).css('border', '1px solid orange');
                } else {
                    $(this).val(clamp($(this).val(), 0, 100));
                    $(this).css('border', '1px solid #d5d5d5');
                }
            });
            return flag;
        }

        function checkDate() {
            if (date.val().toString() === '' || remainingItems < 0) {
                date.css('border', '1px solid orange');
                return false;
            } else {
                date.css('border', '1px solid #d5d5d5');
                return true;
            }
        }

        function checkTime() {
            if (time.val().toString() === '' || remainingItems < 0) {
                time.parent().find('.chosen-single').css('border', '1px solid orange');
                return false;
            } else {
                time.parent().find('.chosen-single').css('border', '1px solid #d5d5d5');
                return true;
            }
        }

        function checkInputs() {
            const validDate = checkDate();
            const validTime = checkTime();
            const validItems = checkItems();
            // const validQuantities = checkQuantities();
            const validPercentage = checkPercentages();
            if (validDate && validTime && validItems && validPercentage) {
                addButton.attr('disabled', false);
                return true;
            } else {
                addButton.attr('disabled', true);
                return false;
            }
        }

        function clamp(v, min, max){
            return Math.min(Math.max(v, min), max);
        }
    </script>
@endpush
