@php
    $settings = settings();
    $user = \App\Models\User::find(1);
    \App::setLocale($user->lang);
@endphp
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ !empty($settings['meta_seo_description']) ? $settings['meta_seo_description'] : 'SaasoX - saas & software HTML Template' }}">
    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : 'Themeservices' }}">
    <!-- Favicon Icon -->
    <link rel="icon" href="{{ !empty($settings['company_favicon']) ? fetch_file($settings['company_favicon'], 'upload/logo/') : asset('landing/assets/img/favicon.png') }}">
    <!-- Site Title -->
    <title>{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }} - @yield('page-title', 'Home')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('landing/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/style.css') }}">
    
    @stack('styles')
</head>

<body>
    <!-- Start Preloader -->
    <div class="cs_preloader cs_white_bg">
        <div class="cs_preloader_in position-relative">
            <span></span>
        </div>
    </div>
    <!-- End Preloader -->
    
    @include('landing.partials.header')
    
    @yield('content')
    
    @include('landing.partials.footer')
    
    <!-- Script -->
    <script src="{{ asset('landing/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('landing/assets/js/jquery.slick.min.js') }}"></script>
    <script src="{{ asset('landing/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('landing/assets/js/odometer.js') }}"></script>
    <script src="{{ asset('landing/assets/js/main.js') }}"></script>
    
    @stack('scripts')
</body>

</html>

