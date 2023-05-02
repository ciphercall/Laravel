@extends('backend.layouts.master')

@section('title','customer-List')
@section('page-header')
    <i class="fa fa-list"></i> customer List
@stop

@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'List customer',
       'route' => route('backend.customer.index')
    ])

   <div class="col-xs-12 col-sm-3 center">
        <div>
            <span class="profile-picture">
            <img id="avatar" class="editable img-responsive editable-click editable-empty" alt="Alex's Avatar" src="{{ asset('assets/images/avatars/profile-pic.jpg')}}">
        </span>

            <div class="space-4"></div>

            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                <div class="inline position-relative">
                    <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                        <i class="ace-icon fa fa-circle light-green"></i> &nbsp;
                        <span class="white">Alex M. Doe</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="space-6"></div>

        <div class="hr hr12 dotted"></div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Username </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="username">alexdoe</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Location </div>

                <div class="profile-info-value">
                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                    <span class="editable editable-click" id="country">Netherlands</span>
                    <span class="editable editable-click" id="city">Amsterdam</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> District </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="age">Alaxa</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Area </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="age">A/2,H:398</span>
                </div>
            </div>


            <div class="profile-info-row">
                <div class="profile-info-name">Resistered/Joined </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="signup">2010/06/20</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Last Time Order </div>

                <div class="profile-info-value">
                    <span class="editable editable-click" id="login">3 hours ago</span>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('backend.partials._paginate', ['data' => $customers]) --}}
@endsection

@push('js')
    <script type="text/javascript">
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush
