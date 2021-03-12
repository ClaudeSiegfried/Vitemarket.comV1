@extends('layouts.auth')

@section('content')
    <div class="container p-5">
        <div class="row form-signup align-items-center justify-content-center">
            <div class="col-sm-12 col-xs-12 layout bg-img pt-sm-4">
            </div>
            <div class="col-sm-7 col-md-12 animate__animated animate__fadeIn">
                <div class="container p-4 align-self-center">
                    <h3 class="text-center font-weight-light">{{ __('Register') }}</h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form ">
                                    <input class="form-control py-4 @error('name') is-invalid @enderror" name="name"
                                           id="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                           type="text">
                                    <label class="text-black-50 label-name" for="name">
                                        <span class="content-name">{{ __('Name') }}</span>
                                    </label>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form">
                                    <input class="form-control py-4 @error('tel') is-invalid @enderror" name="tel"
                                           id="tel"
                                           value="{{ old('tel') }}" required autocomplete="tel" autofocus type="tel">
                                    <label class="text-black-50 label-name" for="tel">
                                        <span class="content-name">{{ __('Phone Number') }}</span>
                                    </label>
                                    @error('tel')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form">
                                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus
                                       type="email/text">
                                <label class="text-black-50 label-name" for="email">
                                    <span class="content-name">{{ __('E-Mail Address') }}</span>
                                </label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form ">
                                    <input class="form-control py-4 @error('password') is-invalid @enderror"
                                           name="password"
                                           id="password"
                                           type="password"
                                           required autocomplete="new-password">
                                    <label class="text-black-50 label-name" for="password">
                                        <span class="content-name">{{ __('Password') }}</span>
                                    </label>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form ">
                                    <input class="form-control py-4 @error('password-confirm') is-invalid @enderror"
                                           name="password_confirmation"
                                           id="password-confirm"
                                           type="password"
                                           required autocomplete="new-password">
                                    <label class="text-black-50 label-name" for="password-confirm">
                                        <span class="content-name">{{ __('Confirm Password') }}</span>
                                    </label>

                                    @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-5 mb-0">
                            <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                                {{ __('Register') }}<i class="fas fa-angle-right ml-2"></i>
                            </button>
                        </div>

                    </form>
                    <a href="{{route('login')}}"
                       class="btn btn-outline-success btn-block rounded-pill shadow mt-4 text-wrap">Sign In<i
                            class="fas fa-angle-right ml-2"></i></a>
                </div>
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
