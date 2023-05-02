@extends('delivery.layouts.master')
@section('title', 'Balance Withdraw')
@section('page-header')
    <i class="fa fa-plus"></i> Balance Withdraw
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
@endpush

@section('content')
    @include('delivery.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Withdraw Requests',
       'route' => route('delivery.withdrawal.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('delivery.withdrawal.store')}}">
        @csrf

            <div class="form-group">
                <label class="col-sm-2 bolder" for="method">Balance </label>
                <div class="col-sm-4">
                    <div class="">
                        <span class="text-success" style="font-weight: bold">{{$balance}} TK</span>
                    </div>
                </div>
            </div>

            <!-- Method -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="withdrawal_method">Method <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <div class="text-center">
                        <select class="chosen-select" id="withdrawal_method" name="withdrawal_method" data-placeholder="- Method -" required>
                            <option></option>
                            <option value="bKash" {{old('withdrawal_method') == 'bKash' ? 'selected' : ''}}>
                                bKash
                            </option>
                            <option value="Nagad" {{old('withdrawal_method') == 'Nagad' ? 'selected' : ''}}>
                                Nagad
                            </option>
                            <option value="Rocket" {{old('withdrawal_method') == 'Rocket' ? 'selected' : ''}}>
                                Rocket
                            </option>
                            <option value="Bank" {{old('withdrawal_method') == 'Bank' ? 'selected' : ''}}>
                                Bank
                            </option>
                            <option value="Other" {{old('withdrawal_method') == 'Other' ? 'selected' : ''}}>
                                Other
                            </option>
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('withdrawal_method') }}</strong>
                </div>
            </div>

            <!-- Mobile -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="mobile">Mobile <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           required
                           id="mobile"
                           name="mobile"
                           placeholder="01xxxxxxxxx"
                           value="{{old('mobile')}}"
                           pattern="^01[0-9]{9}$"
                           class="form-control input-sm text-center">
                    <strong class="red">{{ $errors->first('mobile') }}</strong>
                </div>
            </div>

            <!-- Amount -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="amount">Amount <sup class="red">*</sup></label>
                <div class="col-sm-4">
                    <input type="text"
                           required
                           id="amount"
                           name="amount"
                           placeholder="0"
                           value="{{old('amount')}}"
                           class="form-control input-sm text-center">
                    <strong class="red">{{ $errors->first('amount') }}</strong>
                </div>
            </div>

            <!-- Note -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="note">Note</label>
                <div class="col-sm-4">
                    <input type="text"
                           id="note"
                           name="note"
                           placeholder="Note"
                           value="{{old('note')}}"
                           class="form-control input-sm text-center">
                    <strong class="red">{{ $errors->first('note') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="fa fa-save"></i> Request
                    </button>

                    <a href="{{route('delivery.withdrawal.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        jQuery(function ($) {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true, search_contains: true});
                //resize the chosen on window resize
                $(window).on('resize.chosen', function () {
                    $('.chosen-select').each(function () {
                        let $this = $(this);
                        $this.next().css({'width': '100%'});
                        // $this.next().css({'width': $this.parent().width()});
                    })
                }).trigger('resize.chosen');
            }
        });
    </script>
@endpush
