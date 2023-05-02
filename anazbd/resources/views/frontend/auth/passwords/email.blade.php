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
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li><i
                        style="margin: 7px" class="fa fa-angle-right "></i>
                    <li class="breadcrumb-item">Password Reset</li>
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
                        @if (session('status'))
                        <div class="alert alert-success col-sm-6 offset-sm-4" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="p-login-box">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-sm-6">
                                    <input id="email" type="email" name="email"
                                        class="form-control auth-input @error('email') is-invalid @enderror" required
                                        autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <div class="col-sm-6 offset-sm-4">
                                    <button type="submit" class="btn btn-outlined text-center auth-button">
                                        {{ __('Send Password Reset Link') }}
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