@extends('layouts.auth')
@php
    $settings = settings();
@endphp
@section('tab-title')
    {{ __('Login') }}
@endsection
@push('script-page')
    @if ($settings['google_recaptcha'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('content')
    @php
        $registerPage = getSettingsValByName('register_page');
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class=" text-secondary"><b>{{ __('Hi, Welcome Back') }} </b></h2>
                        <p class="f-16 mt-2">{{ __('Enter your credentials to continue') }}</p>
                    </div>
                </div>
            </div>

            {{ Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm', 'class' => 'login-form']) }}
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="{{ __('Email address') }}" />
                <label for="email">{{ __('Email address') }}</label>
                @error('email')
                    <span class="invalid-email text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="{{ __('Password') }}" />
                <label for="password">{{ __('Password') }}</label>
                @error('password')
                    <span class="invalid-password text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="d-flex mt-1 justify-content-between">
                <div class="form-check">
                    <input class="form-check-input input-primary" type="checkbox" id="agree"
                        {{ old('remember') ? 'checked' : '' }} />
                    <label class="form-check-label text-muted" for="agree">{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-secondary">{{ __('Forgot Password?') }}</a>
                @endif
            </div>
            @if ($settings['google_recaptcha'] == 'on')
                <div class="form-group">
                    <label for="email" class="form-label"></label>
                    {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            @endif
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-secondary p-2">{{ __('Sign In') }}</button>
            </div>
            <div class="position-relative my-4">
                <div class="d-flex align-items-center">
                    <hr class="flex-grow-1">
                    <span class="px-3 text-muted small">{{ __('OR') }}</span>
                    <hr class="flex-grow-1">
                </div>
            </div>
            <div class="d-grid">
                <a href="{{ route('google.login') }}" class="google-signin-btn d-flex align-items-center justify-content-center text-decoration-none">
                    <svg width="20" height="20" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" class="google-icon">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.133h2.908c1.702-1.567 2.684-3.874 2.684-6.491z" fill="#4285F4"/>
                            <path d="M9 18c2.43 0 4.467-.795 5.956-2.15l-2.908-2.133c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.198C2.438 15.983 5.482 18 9 18z" fill="#34A853"/>
                            <path d="M3.964 10.866c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V5.248H.957C.348 6.174 0 7.548 0 9.156c0 1.608.348 2.982.957 3.908l3.007-2.198z" fill="#FBBC05"/>
                            <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 5.248L3.964 7.446C4.672 5.319 6.656 3.735 9 3.735z" fill="#EA4335"/>
                        </g>
                    </svg>
                    <span class="google-btn-text">{{ __('Continue with Google') }}</span>
                </a>
            </div>
            @if ($registerPage == 'on')
                <hr />
                <h5 class="d-flex justify-content-center">{{ __("Don't Have An Account?") }} <a class="ms-1 text-secondary"
                        href="{{ route('register') }}">{{ __('Create an account') }}</a>
                </h5>
            @endif
            {{ Form::close() }}
        </div>
    </div>
@endsection
