@extends('landing.layout')

@section('page-title', 'Rent & Billing Automation - Service Details')
@section('meta-description', 'Automate rent billing cycles, track payments, manage dues, and generate receipts. Get a clear view of collected, pending, and overdue rent across all properties.')
@section('meta-keywords', 'rent automation, billing automation, payment tracking, rent collection')
@section('og-title', 'Rent & Billing Automation - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Rent & Billing Automation</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Rent & Billing Automation</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Rent & Billing Automation banner">
                </div>
                
                <p>Rent & Billing Automation eliminates the manual work involved in managing rent collection and billing. Our automated system handles billing cycles, tracks payments, manages dues, and generates receipts automatically.</p>
                
                <p>You get a clear, comprehensive view of collected, pending, and overdue rent across all your properties. This visibility helps you identify issues early and take proactive measures to ensure consistent cash flow.</p>
                
                <p>The system supports multiple payment methods, automated reminders for overdue payments, and detailed financial reporting. This ensures that your rent collection process is efficient, transparent, and hassle-free.</p>
                
                <h2>Key Features of Rent & Billing Automation</h2>
                <p>Our Rent & Billing Automation solution comes with a comprehensive set of features designed to streamline your property management operations and help you achieve better results.</p>
                
                <ul>
                    <li>Automated rent billing cycles</li>
                    <li>Payment tracking and management</li>
                    <li>Automated receipt generation</li>
                    <li>Overdue payment reminders</li>
                    <li>Multi-property rent overview</li>
                    <li>Financial reporting and analytics</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Rent & Billing Automation feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Rent & Billing Automation feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Rent & Billing Automation, you can streamline your operations, reduce manual work, and focus on growing your property management business. Our platform is designed to be intuitive, powerful, and scalable to meet your needs.</p>
                
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

