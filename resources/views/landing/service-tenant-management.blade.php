@extends('landing.layout')

@section('page-title', 'Tenant Management - Service Details')
@section('meta-description', 'Manage tenant profiles, leases, documents, and communication with ease. Keep complete tenant history, rent status, and agreements organized and accessible anytime.')
@section('meta-keywords', 'tenant management, tenant profiles, lease management, tenant communication')
@section('og-title', 'Tenant Management - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Tenant Management</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Tenant Management</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Tenant Management banner">
                </div>
                
                <p>Tenant Management is an essential feature that helps you maintain comprehensive records of all your tenants. Our system allows you to manage tenant profiles, leases, documents, and communication all in one place.</p>
                
                <p>With complete tenant history tracking, you can easily access rent status, lease agreements, payment history, and maintenance requests. This comprehensive view helps you build better relationships with your tenants and ensures nothing falls through the cracks.</p>
                
                <p>The platform enables seamless communication with tenants, automated reminders for lease renewals, document storage, and easy access to tenant information whenever you need it.</p>
                
                <h2>Key Features of Tenant Management</h2>
                <p>Our Tenant Management solution comes with a comprehensive set of features designed to streamline your property management operations and help you achieve better results.</p>
                
                <ul>
                    <li>Complete tenant profile management</li>
                    <li>Lease agreement tracking and storage</li>
                    <li>Document management and organization</li>
                    <li>Tenant communication history</li>
                    <li>Rent payment status monitoring</li>
                    <li>Automated lease renewal reminders</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Tenant Management feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Tenant Management feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Tenant Management, you can streamline your operations, reduce manual work, and focus on growing your property management business. Our platform is designed to be intuitive, powerful, and scalable to meet your needs.</p>
                
                <p>Get started today and experience the difference that professional property management software can make. Join thousands of property owners and managers who trust Propilor to manage their properties efficiently.</p>
                
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

