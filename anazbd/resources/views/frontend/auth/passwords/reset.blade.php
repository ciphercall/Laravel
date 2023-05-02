@extends('layouts.app2')

@push('css')
<style>
    .auth-input {
        border: 1px solid #92a2a9;
        border-width: 0px 0px 1px 1px;
        border-radius: 0px;
        height: 50px;
        width: 100%;
    }

    .auth-input:focus-within {
        border: 1px solid #92a2a9;
        border-width: 0px 0px 1px 1px;
        border-radius: 0px;
        height: 50px;
        width: 100%;
    }

    .auth-button {
        border: 1px solid #92a2a9;
        background: #92a2a9;
        color: #92a2a9;
        font-weight: bold;
        width: 100%;
        padding:10px;

    }

    .auth-button:hover {
        border: 1px solid #92a2a9;
        background: #92a2a9;
        color: #fff;
        width: 100%;
    }
</style>
@endpush

@section('content')
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li><i
                        style="margin: 7px" class="fa fa-angle-right "></i>
                    <li class="breadcrumb-item">{{-- Password Confirm --}}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="page-section inner-page-sec-padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}" class="p-login-box">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email"
                                    class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-sm-6">
                                    <input id="email" type="email"
                                        class="form-control auth-input @error('email') is-invalid @enderror"
                                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                        autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-sm-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-sm-6">
                                    <input id="password" type="password"
                                        class="form-control auth-input @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-sm-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control auth-input"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <div class="col-sm-6 offset-sm-4">
                                    <button type="submit" class="btn auth-button">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection