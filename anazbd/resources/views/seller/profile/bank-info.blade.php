@extends('material.layouts.master')
@section('title','Seller Profile')
@section('page-header')
    <i class="material-icons">account_balance</i> Bank Account
@stop

@section('content')
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-list',
       'name' => 'Seller Profile',
       'route' => route('backend.product.child_categories.index')
    ])  --}}
<?php
$id = \App\Models\BankAccount::first();

?>
    <div class="row">
    <div class="col-sm-9 col-md-9 col-lg-7  card">
        <div class="card-header card-header-primary">
            Banking Informations
        </div>
        <div class="card-body">
            <form class="form-horizontal"
              method="post"
              action="{{route('seller.bank-info', $id)}}"
              role="form"
              enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Name -->

            <div class="col form-group">
                <label class="" for="name">Account Title</label>

                <div class="">
                    <input type="text"
                           id="AccountTitle"
                           placeholder=" - Your Account Title -"
                           class="form-control input-sm"
                           name="account_title"
                           value="{{ $id ? $id->account_title : ''}}"
                    >
                    @error('account_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>


        <!-- Name -->
            <div class="col form-group">
                <label class="" for="proprietor_name">Account Number</label>

                <div class="">
                    <input type="text"
                           id="accountNumber"
                           placeholder=" - Example: 0000-XXXX-XXXX-0000 -"
                           class="form-control input-sm"
                           name="account_number"
                           {{-- required--}}
                           value="{{ $id ? $id->account_number : ''}}"
                    >
                    @error('account_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col form-group">
                <label class="" for="bank_name">Bank Name </label>

                <div class="">
                    <select class="form-control" name="bank_name" id="#">
                        @foreach($bankNames as $bName)
                        <option value="{{$bName->id}}">{{ $bName->name}}</option>
                        @endforeach
                    </select>
                    @error('bank_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Corporate address --}}
            <div class="col form-group">
                <label class="" for="crporate_address">Branch Name</label>

                <div class="">
                    <input type="text"
                           id="branchName"
                           placeholder=" - Example: Branch name of Main Bank -"
                           class="form-control input-sm"
                           name="barnch_name"
                           {{--                           required--}}
                           value="{{ $id ? $id->barnch_name : '' }}"
                    >
                    @error('branch_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
            
        <div class="row">
            {{-- Vat Registration number --}}
            <div class="col form-group">
                <label class="" for="vat_registration_number">Routing number </label>

                <div class="">
                    <input type="text"
                           id="routingNumber"
                           placeholder=" - Your Routing number -"
                           class="form-control input-sm"
                           name="routing_number"
                           {{--                           required--}}
                           value="{{$id ? $id->routing_number: ''}}"
                    >
                    @error('routing_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            {{-- owners NID numberr --}}
            <div class="col form-group">
                <label class="text-dark" for="nid_number"><i class="material-icons">backup</i> Cheque Copy</label>

                <div class="">
                    <input type="file"
                           id="nid_number"
                           class="form-control input-sm"
                           name="cheque_copy"
                           accept="image/*"
                           {{--                           required--}}
                           value="">
                    <span class="text-muted">Allow image file, PDF and MS word</span>
                    @error('cheque_copy')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
            <div class="col form-group">
                <label class=""></label>
                <div class="text-right">
                    <input type="submit" name="btn" class="btn btn-primary btn-lgs">
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="col-sm-9 col-md-6 col-lg-5">
        <div class="card">
            <div class="card-header-primary">
                Documents
            </div>
            <div class="card-body">
                <img src="{{ asset($id ? $id->cheque_copy : '') }}" width="100%" height="200px">
            </div>
            
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
