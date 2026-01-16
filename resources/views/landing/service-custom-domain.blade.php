@extends('landing.layout')

@section('page-title', 'Custom Domain - Service Details')
@section('meta-description', 'Use your own custom domain for your property listing website. Build brand recognition and create a professional online presence with your own domain name.')
@section('meta-keywords', 'custom domain, property website domain, branded website, property domain')
@section('og-title', 'Custom Domain - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Custom Domain</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Custom Domain</li>
            </ol>
                <div class="cs_hero_shape_1 position-absolute">
                    <img src="{{ asset('landing/assets/img/dna-shape.png') }}" alt="Shape">
                </div>
                <div class="cs_hero_shape_2 position-absolute">
                    <img src="{{ asset('landing/assets/img/spring-shape-3.svg') }}" alt="Shape">
                </div>
            </div>
        </div>
    </section>
    <!-- End Page Heading -->
    <!-- Start Service Details Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_service_details">
                <div class="cs_banner cs_radius_50">
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Custom Domain banner">
                </div>
                
                <p>Custom Domain is a professional solution that allows you to use your own branded domain name for your property listing website. With our platform, you can create a professional online presence that reflects your brand identity and builds trust with potential tenants.</p>
                
                <p>Our system provides seamless domain integration, allowing you to connect your existing domain or purchase a new one through our platform. Whether you want to use your company name or a property-specific domain, our custom domain feature gives you complete control.</p>
                
                <p>Key features include easy domain setup, SSL certificate management, DNS configuration assistance, and email forwarding options. This ensures that your property website looks professional and trustworthy to potential tenants.</p>
                
                <h2>Key Features of Custom Domain</h2>
                <p>Our Custom Domain solution comes with a comprehensive set of features designed to help you create a professional branded online presence.</p>
                
                <ul>
                    <li>Easy domain connection and setup</li>
                    <li>SSL certificate for secure connections</li>
                    <li>DNS configuration assistance</li>
                    <li>Email forwarding and management</li>
                    <li>Subdomain support for multiple properties</li>
                    <li>Domain renewal reminders and management</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Custom Domain feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Custom Domain feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Custom Domain, you can build brand recognition, create a professional online presence, and establish trust with potential tenants. Our platform is designed to make domain management simple and hassle-free.</p>
                
                <p>Get started today and experience the difference that a custom domain can make. Join thousands of property managers who trust Propilor to provide a professional branded online presence.</p>
                
                <div class="text-center cs_mt_50">
                    <a href="{{ url('register') }}" class="cs_btn cs_style_1 cs_bg_1 cs_fs_14 cs_bold cs_white_color text-uppercase">
                        <span>Get Started Free</span>
                        <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Service Details Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
@endsection

