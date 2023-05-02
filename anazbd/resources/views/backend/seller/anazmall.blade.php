@extends('backend.layouts.master')
@section('title','AnazMall Seller-List')
@section('page-header')
    <i class="fa fa-list"></i> Anazmall Seller List
@stop
@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .swal2-content {
            padding-top: 15px !important;
            padding-bottom: 10px !important;
        }
    </style>
    <link rel="stylesheet" href="{{asset('assets/css/custom.chosen.min.css')}}">
@endpush

@section('content')
    @include('backend.components.page_header')

    <div class="row">

        <div class="col-md-7">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th class="bg-dark">SL</th>
                    <th class="bg-dark">Name</th>
                    <th class="bg-dark">Actions</th>
                </tr>
                @php
                    $i = 0;
                @endphp
                @foreach($anazmall_sellers as $key => $seller)
                    @php $i++; @endphp
                    <tr>
                        <td style="width: 50px !important;">
                            {{ $key+1 }}
                        </td>
                        <td class="seller-name"
                            data-id="{{$seller->id}}"
                            data-name="{{$seller->name}}"
                            data-order="{{$seller->anazmall_order}}"
                            style="height: 47px">
                            {{ $seller->name }}
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-mini btn-corner">
                                <a href="#"
                                   class="btn btn-xs btn-info action-edit"
                                   title="Edit">
                                    <i class="ace-icon fa fa-pencil"></i>
                                </a>
                                <a href="#"
                                   onclick="event.preventDefault(); action_clear_clicked({{$seller->id}})"
                                   class="btn btn-xs btn-danger action-clear"
                                   title="Clear">
                                    <i class="ace-icon fa fa-trash"></i>
                                </a>
                            </div>
                            <form id="clearCheck_{{$seller->id}}"
                                  action="{{route('backend.seller.anazmall.update')}}"
                                  method="POST"
                                  style="display: none">
                                @csrf
                                <input type="hidden" name="seller_id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="0">
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="width: 10%;">{{ count($anazmall_sellers) + 1 }}</td>
                    <td class="seller-name" style="width: 70%">
                        <form action="{{route('backend.seller.anazmall.update')}}" method="POST">
                            @csrf
                            <select class="chosen-select form-control"
                                    data-placeholder="- Seller -"
                                    id="seller_id"
                                    name="seller_id">
                                <option value=""></option>
                                @foreach(collect($sellers)->whereNotIn('id',collect($anazmall_sellers)->pluck('id')) as $seller)
                                    <option value="{{$seller->id}}">
                                        {{$seller->name}}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="status" value="1">
                            <input type="hidden" name="anazmall_order" value="{{ count($anazmall_sellers) + 1 }}">
                        </form>
                    </td>
                    <td class="actions" style="width: 20%">
                        <div class="btn-group btn-group-mini btn-corner">
                            <a href="#"
                                class="btn btn-xs btn-success action-save"
                                title="Save">
                                <i class="ace-icon fa fa-check"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.chosen-select').chosen({
                width: '100%'
            });

            $('.action-edit').on('click', action_edit_clicked);
            $('.action-save').on('click', action_save_clicked);
        });

        // action_save_clicked //
        function action_save_clicked(e) {
            e.preventDefault();

            const name = $(this).closest('tr').find('td.seller-name form');
            const val = name.find('.chosen-select').val();
            if (val > 0) {
                name.submit();
            }
        }

        // action_edit_clicked //
        function action_edit_clicked(e) {
            e.preventDefault();
            const name = $($(this).closest('tr').find('td.seller-name'));
            name.html(
                `<form action="{{route('backend.seller.anazmall.update')}}" method="POST">
                    <select class="chosen-select form-control"
                            data-placeholder="- Seller -"
                            id="seller_id"
                            name="seller_id">
                        <option value=""></option>
                        @foreach($sellers as $seller)
                <option value="{{$seller->id}}" ${name.data('id') === {{$seller->id}} ? 'selected' : ''}>
                            {{$seller->name}}
                </option>
@endforeach
                </select>
                <input type="hidden" name="status" value="1">
                <input type="hidden" name="anazmall_order" value="${name.data('order')}">
                    {{csrf_field()}}
                </form>`
            );

            name.find('.chosen-select').chosen({
                width: '100%'
            });

            const actions = $($(this).closest('tr').find('.actions'));
            actions.html(
                `<div class="btn-group btn-group-mini btn-corner">
                    <a href="#"
                       class="btn btn-xs btn-dark action-back"
                       title="Back">
                        <i class="ace-icon fa fa-arrow-left"></i>
                    </a>
                    <a href="#"
                       class="btn btn-xs btn-success action-save"
                       title="Save">
                        <i class="ace-icon fa fa-check"></i>
                    </a>
                </div>`
            );
            actions.find('.action-back').on('click', action_back_clicked);
            actions.find('.action-save').on('click', action_save_clicked);
        }

        // action_back_clicked //
        function action_back_clicked(e) {
            e.preventDefault();

            const name = $($(this).closest('tr').find('td.seller-name'));
            name.text(name.data('name'));

            name.find('.chosen-select').chosen({
                width: '100%'
            });

            const actions = $($(this).closest('tr').find('.actions'));
            actions.html(
                `<div class="btn-group btn-group-mini btn-corner">
                    <a href="#"
                       class="btn btn-xs btn-info action-edit"
                       title="Edit">
                        <i class="ace-icon fa fa-pencil"></i>
                    </a>
                    <a href="#"
                       onclick="event.preventDefault(); action_clear_clicked({{$seller->id}})"
                       class="btn btn-xs btn-danger action-clear"
                       title="Clear">
                        <i class="ace-icon fa fa-trash"></i>
                    </a>
                </div>
                <form id="clearCheck_{{$seller->id}}"
                              action="{{route('backend.seller.anazmall.update')}}"
                              method="POST"
                              style="display: none">
                            @csrf
                <input type="hidden" name="seller_id" value="{{$seller->id}}">
                    <input type="hidden" name="status" value="0">
                </form>`
            );
            actions.find('.action-edit').on('click', action_edit_clicked);
            actions.find('.action-edit').on('click', action_edit_clicked);
        }

        // action_clear_clicked //
        function action_clear_clicked(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will remove this seller as a Anazmall Seller!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear Seller!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#clearCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush
