@extends('material.layouts.master')
@section('title', 'Balance Withdraw')
@section('page_header')
    <i class="fa fa-plus"></i> Balance Withdraw
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-9 col-md-6 col-lg-6">
            
    <div class="card">
        <div class="card-header-primary">
            Withdraw Form
        </div>
        <div class="card-body">
            <div class="">
                <form role="form"
                      method="post"
                      class="form-horizontal"
                      enctype="multipart/form-data"
                      action="{{route('seller.withdrawal.store')}}">
                @csrf
        
                    <div class="form-group">
                        <label class=" bolder" for="method">Balance </label>
                        <div class="">
                            <div class="">
                                <span class="text-success" style="font-weight: bold">{{$balance}} TK</span>
                            </div>
                        </div>
                    </div>
        
                    <!-- Method -->
                    <div class="form-group">
                        <label class=" bolder" for="withdrawal_method">Method <sup class="red">*</sup></label>
        
                        <div class="">
                            <div class="text-center">
                                <select class="chosen-select w-100" id="withdrawal_method" name="withdrawal_method" data-placeholder="- Method -" required>
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
                        <label class=" bolder" for="mobile">Mobile <sup class="red">*</sup></label>
                        <div class="">
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
                        <label class=" bolder" for="amount">Amount <sup class="red">*</sup></label>
                        <div class=""">
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
                        <label class=" bolder" for="note">Note</label>
                        <div class="">
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
                        <div class="row justify-content-between">
                            <a href="{{route('seller.withdrawal.index')}}" class="col-3 btn btn-sm btn-gray">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button class="col-3 btn btn-sm btn-success" type="submit">
                                <i class="fa fa-save"></i> Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
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
