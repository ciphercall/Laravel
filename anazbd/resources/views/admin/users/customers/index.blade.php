@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">person</i> Customers
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">

                <div class="card-header-primary">
                    All Customers
                </div>
                <div class="row card-body">
                    <div class="col card bg m-3">
                        <table class="table table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">SL</th>
                                    <th width="10%">Name</th>
                                    <th width="15%">Email</th>
                                    <th width="10%">Mobile</th>
                                    <th width="5%">Status</th>
                                    <th width="5%">Registered From</th>
                                    <th width="5%">OTP</th>
                                    <th width="10%">Joined</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ($users->total()-$loop->index)-(($users->currentpage()-1) * $users->perpage() ) }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td><span class="badge @if($user->status) badge-success @else badge-danger @endif">@if($user->status) Active @else Deactive @endif</span></td>
                                        <td>{{ $user->platform_origin }}</td>
                                        <td>{{ $user->otp }}</td>
                                        <td>{{ Carbon\Carbon::parse($user->created_at)->format("d-m-Y h:i A") }}</td>
                                        <td>
                                            <div class="row justify-content-center">
                                                @if($user->status)
                                                    <a onclick="return confirm('Are You Sure ?')" href="{{ route('admin.users.customer.toggle',$user->id) }}" class="btn btn-sm btn-info">Deactive</a>
                                                @else
                                                    <a onclick="return confirm('Are You Sure ?')" href="{{ route('admin.users.customer.toggle',$user->id) }}" class="btn btn-sm btn-primary">Activate</a>
                                                @endif
                                                <a href="{{ route('admin.users.customer.edit',$user->id) }}" class="btn btn-sm btn-warning"><i class="material-icons">edit</i></a>
                                                <form action="{{route('admin.users.customer.delete',az_hash($user->id))}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

