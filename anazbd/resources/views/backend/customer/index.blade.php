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
    <form class="form-horizontal" method="post" action="{{ route('admin.user.search') }}" role="form" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered">
            <tbody><tr>
                <th  class="bg-dark" style="width: 22%"><label for="name">Name - Number - Email </label></th>
                <th class="bg-dark" style="width: 12%;">Actions</th>
            </tr>
            <tr>
                <td>
                    <input type="text" id="myInput" name="search" placeholder="Customer search here.." value="" class="input-sm form-control text-center" required>
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <button type="submit" class="btn btn-xs btn-primary" title="Search">
                            <i class="ace-icon fa fa-search"></i>
                        </button>

                        <a href="{{ route('backend.customer.index') }}" class="btn btn-xs btn-info" title="Show All">
                            <i class="ace-icon fa fa-list"></i>
                        </a>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </form>
    <table class="table table-bordered" id="table1">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 10%">SL</th>
            <th class="bg-dark" style="width: 20%">Name</th>
            <th class="bg-dark" style="width: 20%">number</th>
            <th class="bg-dark" style="width: 20%">Email</th>
            <th class="bg-dark" style="width: 20%">Gender</th>
            <th class="bg-dark" style="width: 20%">Birth Day</th>
            <th class="bg-dark" style="">Action</th>
        </tr>
        @forelse($users as $key => $user)
        {{-- @dd($user); --}}
            <tr>
                <td>{{ $key+1 }}</td>
                <td> {{ $user->name }}</td>
                <td> {{ $user->number }}</td>
                <td> {{ $user->email }}</td>
                <td> {{ $user->gender }}</td>
                <td> {{ $user->date.'-'.$user->month.'-'.$user->year }}</td>
                <td>
                    {{-- <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.customer.show') }}"
                           class="btn btn-xs btn-info"
                           title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check()"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action=""
                          id="deleteCheck_{{ $banner->id }}" method="GET">
                        @csrf
                    </form> --}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No data available in table</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('backend.partials._paginate', ['data' => $users])
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
