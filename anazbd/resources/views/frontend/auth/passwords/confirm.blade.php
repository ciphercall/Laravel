@extends('layouts.app')

@push('css')
<style>
    .auth-input {
        border: 1px solid #92a2a9;
        border-width: 0px 0px 1px 1px;
        border-radius: 0px;
        height: 50px;
    }

    .auth-input:focus-within {
        border: 1px solid #92a2a9;
        border-width: 0px 0px 1px 1px;
        border-radius: 0px;
        height: 50px;
    }

    .auth-button {
        border: 1px solid #92a2a9;
        background: #fff;
        color: #92a2a9;
        font-weight: bold;
        width: 100%;
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control auth-input @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn auth-button">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection