@extends('layouts.auth')

@section('content')
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-lg-5 col-xs-12">
            <h3 class="text-center mb-5">{{ __('Reset Password') }}</h3>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form">
                    <input class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus type="email/text">
                    <label class="text-black-50 label-name">
                        <span class="content-name">{{ __('E-Mail') }}</span>
                    </label>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-success">
                    {{ __('Send Password Reset Link') }}
                </button>
            </form>

        </div>
    </div>
@endsection
