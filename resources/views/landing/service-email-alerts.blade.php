@extends('landing.layout')

@section('page-title', 'Email Alerts - Service Details')
@section('meta-description', 'Stay informed with automated email alerts. Receive notifications for rent payments, maintenance requests, lease renewals, and other important property events.')
@section('meta-keywords', 'email alerts, property notifications, automated alerts, property management alerts')
@section('og-title', 'Email Alerts - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Email Alerts</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Email Alerts</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Email Alerts banner">
                </div>
                
                <p>Email Alerts is a powerful notification system designed to keep you informed about important property management events. With our automated email alerts, you can receive timely notifications for rent payments, maintenance requests, lease renewals, and other critical property events.</p>
                
                <p>Our system provides customizable alert settings that allow you to control what notifications you receive and when. Whether you want daily summaries, real-time alerts, or weekly reports, our email alert system ensures you never miss important information.</p>
                
                <p>Key features include customizable alert preferences, multiple notification types, email templates, alert scheduling, and notification history. This ensures that you stay informed and can respond quickly to important events.</p>
                
                <h2>Key Features of Email Alerts</h2>
                <p>Our Email Alerts solution comes with a comprehensive set of features designed to keep you informed about important property management events.</p>
                
                <ul>
                    <li>Customizable alert preferences and settings</li>
                    <li>Multiple notification types and categories</li>
                    <li>Professional email templates</li>
                    <li>Alert scheduling and frequency control</li>
                    <li>Notification history and tracking</li>
                    <li>Multi-recipient support for team alerts</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Email Alerts feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Email Alerts feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Email Alerts, you can stay informed about important property events, respond quickly to issues, and maintain better communication with your team and tenants. Our platform is designed to be intuitive, reliable, and customizable to meet your notification needs.</p>
                
                <p>Get started today and experience the difference that automated email alerts can make. Join thousands of property managers who trust Propilor to keep them informed about important property management events.</p>
                
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

