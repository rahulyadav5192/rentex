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
    <meta name="description" content="@yield('meta-description', !empty($settings['meta_seo_description']) ? $settings['meta_seo_description'] : 'Propilor - Complete Property and Tenant Management CRM. Automate your properties, tenants, rent billing, and maintenance with our modern all-in-one management platform.')">
    <meta name="keywords" content="@yield('meta-keywords', 'property management, tenant management, CRM, property software, rental management, property management system')">
    <meta name="author" content="Propilor">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og-title', 'Propilor - Property & Tenant Management CRM')">
    <meta property="og:description" content="@yield('meta-description', 'Complete Property and Tenant Management CRM. Automate your properties, tenants, rent billing, and maintenance.')">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="@yield('og-title', 'Propilor - Property & Tenant Management CRM')">
    <meta property="twitter:description" content="@yield('meta-description', 'Complete Property and Tenant Management CRM. Automate your properties, tenants, rent billing, and maintenance.')">
    <!-- Favicon Icon -->
    <link rel="icon" href="{{  asset('landing/assets/img/favicon.png') }}">
    <!-- Site Title -->
    <title>@yield('page-title', 'Home') - Propilor | Property & Tenant Management CRM</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('landing/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/assets/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://unpkg.com/lucide@latest"></script>

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
    
    <!-- Initialize Lucide Icons -->
    <script>
        (function() {
            function initLucideIcons() {
                if (typeof lucide !== 'undefined') {
                    try {
                        lucide.createIcons();
                    } catch(e) {
                        console.warn('Lucide icons initialization error:', e);
                    }
                }
            }
            
            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initLucideIcons);
            } else {
                initLucideIcons();
            }
            
            // Re-initialize when mega menu is shown
            setTimeout(function() {
                const megaMenu = document.querySelector('.mega-menu');
                if (megaMenu) {
                    megaMenu.addEventListener('mouseenter', function() {
                        setTimeout(initLucideIcons, 100);
                    });
                }
            }, 500);
        })();
    </script>
    
    @stack('scripts')
</body>

</html>

