@php
    $settings = settings();
    $admin_logo = getSettingsValByName('company_logo');
    $logo = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('landing/assets/img/logo_white.png');
    // Final fallback if fetch_file returns empty
    if (empty($logo) || $logo == asset('landing/assets/img/logo_white.png')) {
        $logo = asset('landing/assets/img/logo_white.png');
    }
@endphp
<!-- Start Header Section -->
<header class="cs_site_header cs_style_1 cs_type_2 cs_sticky_header cs_white_color cs_heading_font">
    <div class="cs_main_header">
        <div class="container">
            <div class="cs_main_header_in">
                <div class="cs_main_header_left">
                    <a class="cs_site_branding" href="{{ url('/') }}" aria-label="Home page link">
                        <img src="{{ asset('landing/assets/img/logo_white.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="cs_main_header_center">
                    <div class="cs_nav">
                        <ul class="cs_nav_list">
                            <li><a href="{{ url('/') }}" aria-label="Menu link">Home</a></li>
                            <li><a href="{{ route('landing.about') }}" aria-label="Menu link">About Us</a></li>
                            <li class="menu-item-has-children">
                                <a href="#" aria-label="Menu link">Services</a>
                                <ul>
                                    <li><a href="{{ route('landing.services') }}" aria-label="Menu link">Services</a></li>
                                    <li><a href="{{ route('landing.service-details') }}" aria-label="Menu link">Service Details</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" aria-label="Menu link">Pages</a>
                                <ul>
                                    <li><a href="{{ route('landing.team') }}" aria-label="Menu link">Our Team</a></li>
                                    <li><a href="{{ route('landing.team-details') }}" aria-label="Menu link">Team Details</a></li>
                                    <li><a href="{{ route('landing.pricing') }}" aria-label="Menu link">Our Pricing</a></li>
                                    <li><a href="{{ route('landing.faqs') }}" aria-label="Menu link">FAQ & Answer</a></li>
                                    <li><a href="{{ route('landing.error') }}" aria-label="Menu link">Error</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" aria-label="Menu link">Blog</a>
                                <ul>
                                    <li><a href="{{ url('blog') }}" aria-label="Menu link">Blog</a></li>
                                    <li><a href="{{ route('landing.blog-details') }}" aria-label="Menu link">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('register') }}" aria-label="Menu link">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="cs_main_header_right">
                    <a href="{{ route('landing.contact') }}" aria-label="Get started button"
                        class="cs_btn cs_style_1 cs_theme_bg_4 cs_fs_14 cs_bold cs_heading_color text-uppercase">
                        <span>Get Started</span>
                        <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header Section -->

