@extends('layouts.auth')

@section('content')

    <div class="container p-5">
        <div class="row">
            <div class="col-sm-6 col-xs-12 animate__animated animate__fadeIn">
                <div class="form-signin p-1 align-content-center">
                    <form class="py-5 bg-transparent mt-sm-4" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h3 class="text-center mb-5">Login</h3>
                        <div class="form">
                            <input class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus type="email/text">
                            <label class="text-black-50 label-name">
                                <span class="content-name">{{ __('E-Mail Address') }}</span>
                            </label>
                        </div>
                        <div class="form ">
                            <input class="form-control @error('password') is-invalid @enderror" name="password"
                                   id="password" required autocomplete="current-password" type="password">
                            <label class="text-black-50 label-name">
                                <span class="content-name">{{ __('Password') }}</span>
                            </label>
                        </div>
                        <div class="form-group px-sm-5 mt-5 text-sm-center">

                            <input class="form-check-input form-check" type="checkbox" name="remember" id="remember"
                                   value="{{ old('remember') ? 'checked' : '' }}">
                            <label class="form-check-label">{{ __('Remember Me') }}</label>
                            <a href="{{ route('password.request') }}"
                               class="float-right text-decoration-none text-sm-center">{{ __('Forgot Your Password?') }}</a>
                        </div>
                        <button class="btn btn-success btn-block rounded-pill shadow mt-5"
                                type="submit">{{ __('Login') }}
                            <i class="fas fa-angle-right ml-2"></i>
                        </button>
                    </form>
                    <a class="btn btn-outline-success btn-block rounded-pill shadow mt-n4" href="{{route('register')}}">Create
                        account
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 layout bg-img pt-sm-3">
            </div>
        </div>
    </div>
    <script type="text/javascript"> //<![CDATA[
        var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
        document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
        //]]></script>
    <script language="JavaScript" type="text/javascript">
        TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_md_167x42.png", "POSDV", "none");
    </script>

@endsection
