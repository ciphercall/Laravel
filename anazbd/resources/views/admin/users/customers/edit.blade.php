@extends('admin.layout.master')
@section('page_header')
    <i class="material-icons">person</i> Customers
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                
                <div class="card-header-primary">
                    Profile Of {{ $user->name ?? $user->mobile }}
                </div>
                <form action="{{ route('admin.users.customer.update',$user->id) }}" method="POST">
                <div class="row card-body">
                        @csrf
                        @method('PATCH')
                        <div class="col-sm-9 col-md-9 col-lg-9">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="">Mobile</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="">OTP</label>
                                    <input type="text" name="OTP" class="form-control" value="{{ $user->otp }}">
                                    @error('otp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col form-group">
                                    <label for="">Password Confirmation</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="">Provider</label>
                                    <p>{{ $user->provider ?? 'NA' }}</p>
                                </div>
                                <div class="col form-group">
                                    <label for="">Birthday</label>
                                    @if($user->day && $user->month && $user->year)
                                        <p>{{ $user->day."/".$user->month."/".$user->year }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-sm btn-success"><i class="material-icons">save</i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <img src="{{ asset($user->image) }}" alt="" class="img-thumbnail">
                        </div>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

