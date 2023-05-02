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
              action="{{route('backend.withdrawal.update', $withdrawal->id)}}">
        @csrf

            @if($withdrawal->agent)
            <div class="form-group">
                <label class="col-sm-2 bolder" for="method">Agent </label>
                <div class="col-sm-4">
                    <div class="">
                        <span class="text-success" style="font-weight: bold">{{$withdrawal->agent->name}}</span>
                    </div>
                </div>
            </div>
            @elseif($withdrawal->seller)
                <div class="form-group">
                    <label class="col-sm-2 bolder" for="method">Shop </label>
                    <div class="col-sm-4">
                        <div class="">
                            <span class="text-success" style="font-weight: bold">{{$withdrawal->seller->shop_name}}</span>
                        </div>
                    </div>
                </div>
            @endif

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
                            <option value="bKash" {{$withdrawal->method == 'bKash' ? 'selected' : ''}}>
                                bKash
                            </option>
                            <option value="Nagad" {{$withdrawal->method == 'Nagad' ? 'selected' : ''}}>
                                Nagad
                            </option>
                            <option value="Rocket" {{$withdrawal->method == 'Rocket' ? 'selected' : ''}}>
                                Rocket
                            </option>
                            <option value="Bank" {{$withdrawal->method == 'Bank' ? 'selected' : ''}}>
                                Bank
                            </option>
                            <option value="Other" {{$withdrawal->method == 'Other' ? 'selected' : ''}}>
                                Other
                            </option>
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('withdrawal_method') }}</strong>
                </div>
            </div>

            <!-- Mobile -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="mobile">Mobile</label>
                <div class="col-sm-4">
                    <input type="text"
                           id="mobile"
                           name="mobile"
                           placeholder="0"
                           value="{{$withdrawal->mobile}}"
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
                           value="{{$withdrawal->amount}}"
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
                           value="{{$withdrawal->transaction_id}}"
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
                           value="{{$withdrawal->note}}"
                           class="form-control input-sm text-center">
                    <strong class="red">{{ $errors->first('note') }}</strong>
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label class="col-sm-2 bolder" for="status">Status <sup class="red">*</sup></label>

                <div class="col-sm-4">
                    <div class="text-center">
                        <select class="chosen-select" id="status" name="status" data-placeholder="- Status -" required>
                            <option></option>
                            <option value="1" {{ $withdrawal->status == null || $withdrawal->status == '1' ? 'selected' : ''}}>
                                Approve
                            </option>
                            <option value="0" {{ $withdrawal->status == '0' ? 'selected' : ''}}>
                                Disapprove
                            </option>
                        </select>
                    </div>
                    <strong class=" red">{{ $errors->first('status') }}</strong>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-4">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{route('backend.withdrawal.index')}}" class="btn btn-sm btn-gray">
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
