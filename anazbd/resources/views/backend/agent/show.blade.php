@extends('backend.layouts.master')

@section('title','Agent-List')
@section('page-header')
    <i class="fa fa-list"></i> Agent List
@stop

@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
        .profile-info-name {
            text-align: right;
            padding: 4px 0px 6px 13px;
            font-weight: 400;
            color: #667e99;
            background-color: transparent;
            width: 20%;
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'List customer',
       'route' => route('backend.agent.index')
    ])

@php
    $agentallocatedarea     = collect($agent->AgentAllocatedArea);
    $allocatedpost_id       = $agentallocatedarea->implode('post_id', ', ');
    $extendcollection       = collect($agent->AgentExtendArea);
    $extendpost_id          = $extendcollection->implode('post_id', ', ');
@endphp

    <div class="col-xs-12 col-sm-9">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Username </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="username">{{ $agent->name }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Location/Address </div>

                <div class="profile-info-value">
                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                <span class="editable editable-click" id="country">{{ $agent->address }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Type </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="age">{{ $agent->type == 'personal'?"Personal" : "Business" }}</span>
                </div>
            </div>

            @if($agent->type == 'personal')
                <div class="profile-info-row">
                    <div class="profile-info-name"> Education Level</div>

                    <div class="profile-info-value">
                    <span class="editable editable-click" id="age">{{ $agent->education??' ' }}</span>
                    </div>
                </div>
            @else
                <div class="profile-info-row">
                    <div class="profile-info-name"> Contact Person </div>

                    <div class="profile-info-value">
                    <span class="editable editable-click" id="age">{{  $agent->contact_person??" " }}</span>
                    </div>
                </div>
            @endif

            <div class="profile-info-row">
                <div class="profile-info-name"> Phone </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="age">{{ $agent->phone }}</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="age">{{ $agent->delivery->email }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> NID Number </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="age">{{ $agent->nid_number }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Bank Name </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="age">{{ $agent->bank_name	 }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Bank Account Number </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="age">{{ $agent->bankaccountnumber	 }}</span>
                </div>
            </div>

        </div>
        <br>
        <br>
        <p><i class="menu-icon fa fa-area-chart"></i> Allocated Area </p>
        <hr>
        <div class="profile-user-info profile-user-info-striped">

            <div class="profile-info-row">
                <div class="profile-info-name"> Division </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="username">{{  $agent->AgentAllocatedArea->first()->division_id }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> City </div>
                <div class="profile-info-value">
                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                <span class="editable editable-click" id="country">{{ $agent->AgentAllocatedArea->first()->city_id  }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Area </div>
                    <div class="profile-info-value">
                    <span class="editable editable-click" id="age">{{ $allocatedpost_id }}</span>
                    </div>
            </div>
        </div>
        <br>
        <br>
        <p><i class="menu-icon fa fa-area-chart"></i> Extend Area </p>
        <hr>
        <div class="profile-user-info profile-user-info-striped">

            <div class="profile-info-row">
                <div class="profile-info-name"> Division </div>

                <div class="profile-info-value">
                <span class="editable editable-click" id="username">{{ $agent->AgentExtendArea->first()->division_id  }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> City </div>

                <div class="profile-info-value">
                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                <span class="editable editable-click" id="country">{{ $agent->AgentExtendArea->first()->city_id }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Area </div>

                    <div class="profile-info-value">
                    <span class="editable editable-click" id="age">{{ $extendpost_id }}</span>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-3 center">
        <div>
            <span class="profile-picture">
            <img id="avatar" class="editable img-responsive editable-click editable-empty" alt="Alex's Avatar" src="{{ asset($agent->logo)}}" width="200px" height="200px">
        </span>

            <div class="space-4"></div>

            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                <div class="inline position-relative">
                    <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                        <i class="ace-icon fa fa-circle light-green"></i> &nbsp;
                    <span class="white">{{ $agent->name }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="space-6"></div>

        <div class="hr hr12 dotted"></div>
    </div>
    {{-- @include('backend.partials._paginate', ['data' => $customers]) --}}
@endsection


