@extends('backend.layouts.master')
@section('title', 'Balance Withdraw')
@section('page-header')
    <i class="fa fa-plus"></i> Balance Withdraw
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
@endpush

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Withdraw Requests',
       'route' => route('backend.withdrawal.index')
    ])

    <div class="col-sm-9">
        <form role="form"
              method="post"
              class="form-horizontal"
              enctype="multipart/form-data"
              action="{{route('backend.withdrawal.store')}}">
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
                <label class="col-sm-2 bolder" for="method">Method <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <div class="text-center">
                        <select class="chosen-select" id="method" name="method" data-placeholder="- Method -" required>
                            <option></option>
                            <option value="bKash" {{old('method') == 'bKash' ? 'selected' : ''}}>
                                bKash
                            </option>
                            <option value="Nagad" {{old('method') == 'Nagad' ? 'selected' : ''}}>
                                Nagad
                            </option>
                            <option value="Rocket" {{old('method') == 'Rocket' ? 'selected' : ''}}>
                                Rocket
                            </option>
                            <option value="Bank" {{old('method') == 'Bank' ? 'selected' : ''}}>
                                Bank
                            </option>
                            <option value="Other" {{old('method') == 'Other' ? 'selected' : ''}}>
                                Other
                            </option>
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('method') }}</strong>
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

            <!-- Transaction ID -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="transaction_id">Transaction ID</label>
                <div class="col-sm-4">
                    <input type="text"
                           id="transaction_id"
                           name="transaction_id"
                           placeholder="Transaction ID"
                           value="{{old('transaction_id')}}"
                           class="form-control input-sm text-center">
                    <strong class="red">{{ $errors->first('transaction_id') }}</strong>
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
                        <i class="fa fa-save"></i> Create
                    </button>

                    <a href="{{route('backend.withdrawal.index')}}" class="btn btn-sm btn-gray">
                        <i class="fa fa-refresh"></i> Cancel
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
