@extends('layouts.auth')
@php
    $settings = settings();
@endphp
@section('tab-title')
    {{ __('Register') }}
@endsection
@push('script-page')
    @if ($settings['google_recaptcha'] == 'on')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="auth-header">
                        <h2 class="text-secondary"><b>{{ __('Sign up') }} </b></h2>
                        <p class="f-16 mt-2">{{ __('Enter your details and create account') }}</p>
                    </div>
                </div>
            </div>

            {{ Form::open(['route' => 'register', 'method' => 'post', 'id' => 'register-Form']) }}
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name"
                    placeholder="{{ __('Name') }}" />
                <label for="name">{{ __('Name') }}</label>
                @error('name')
                    <span class="invalid-name text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
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
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="{{ __('Password Confirmation') }}" />
                <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
                @error('password_confirmation')
                    <span class="invalid-password_confirmation text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-check mt-3">
                <input class="form-check-input input-primary" type="checkbox" id="agree" name="agree" required />
                <label class="form-check-label" for="agree">
                    <span class="h5 mb-0">
                        {{ __('Agree with') }}
                        <span><a
                                href="{{ !empty($menu->slug) ? route('page', $menu->slug) : '#' }}">{{ __('Terms and conditions') }}</a>.</span>
                    </span>
                </label>
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
                <button type="submit" class="btn btn-secondary p-2">{{ __('Sign Up') }}</button>
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
            <hr />
            <h5 class="d-flex justify-content-center">{{ __('Already have an account?') }} <a class="ms-1 text-secondary"
                    href="{{ route('login') }}">{{ __('Login in here') }}</a>
            </h5>
            {{ Form::close() }}
        </div>
    </div>
@endsection
