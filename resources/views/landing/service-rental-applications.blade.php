@extends('landing.layout')

@section('page-title', 'Rental Applications - Service Details')
@section('meta-description', 'Streamline your rental application process with our digital application system. Collect, review, and manage rental applications efficiently with automated screening and approval workflows.')
@section('meta-keywords', 'rental applications, tenant screening, application management, property rental')
@section('og-title', 'Rental Applications - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Rental Applications</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Rental Applications</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Rental Applications banner">
                </div>
                
                <p>Rental Applications is a comprehensive digital solution designed to streamline your tenant application process. With our advanced platform, you can collect, review, and manage rental applications efficiently, reducing the time and effort required to find and approve qualified tenants.</p>
                
                <p>Our system provides a seamless application experience for both property managers and prospective tenants. Applicants can submit their information online, upload required documents, and track their application status in real-time.</p>
                
                <p>Key features include automated application screening, document verification, credit check integration, and customizable application forms. This ensures that you can quickly identify the best candidates for your properties while maintaining compliance with fair housing regulations.</p>
                
                <h2>Key Features of Rental Applications</h2>
                <p>Our Rental Applications solution comes with a comprehensive set of features designed to streamline your tenant screening process and help you find qualified tenants faster.</p>
                
                <ul>
                    <li>Digital application forms with customizable fields</li>
                    <li>Automated application screening and scoring</li>
                    <li>Document upload and verification system</li>
                    <li>Credit check and background screening integration</li>
                    <li>Application status tracking and notifications</li>
                    <li>Compliance with fair housing regulations</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Rental Applications feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Rental Applications feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Rental Applications, you can streamline your tenant screening process, reduce manual paperwork, and find qualified tenants faster. Our platform is designed to be intuitive, secure, and compliant with all relevant regulations.</p>
                
                <p>Get started today and experience the difference that professional rental application management can make. Join thousands of property managers who trust Propilor to streamline their tenant application process.</p>
                
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

