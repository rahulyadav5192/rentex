@extends('landing.layout')

@section('page-title', 'Lead Tracking - Service Details')
@section('meta-description', 'Track and manage leads from multiple sources. Monitor lead activity, conversion rates, and follow up with potential tenants efficiently.')
@section('meta-keywords', 'lead tracking, lead management, tenant leads, property leads')
@section('og-title', 'Lead Tracking - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Lead Tracking</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Lead Tracking</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Lead Tracking banner">
                </div>
                
                <p>Lead Tracking is a comprehensive solution designed to help you track and manage leads from multiple sources. With our advanced platform, you can monitor lead activity, track conversion rates, and follow up with potential tenants efficiently.</p>
                
                <p>Our system provides a centralized dashboard that gives you complete visibility into your lead pipeline. Whether leads come from your website, social media, referrals, or other sources, our tracking tools help you stay organized and never miss an opportunity.</p>
                
                <p>Key features include automated lead capture, lead scoring, activity tracking, follow-up reminders, and conversion analytics. This ensures that you can effectively nurture leads and convert them into tenants.</p>
                
                <h2>Key Features of Lead Tracking</h2>
                <p>Our Lead Tracking solution comes with a comprehensive set of features designed to help you manage and convert leads effectively.</p>
                
                <ul>
                    <li>Automated lead capture from multiple sources</li>
                    <li>Lead scoring and qualification system</li>
                    <li>Activity tracking and interaction history</li>
                    <li>Follow-up reminders and task management</li>
                    <li>Conversion rate analytics and reporting</li>
                    <li>Integration with email and communication tools</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Lead Tracking feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Lead Tracking feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Lead Tracking, you can streamline your lead management process, improve conversion rates, and never miss a potential tenant. Our platform is designed to be intuitive, powerful, and scalable to meet your lead tracking needs.</p>
                
                <p>Get started today and experience the difference that professional lead tracking can make. Join thousands of property managers who trust Propilor to manage and convert their leads effectively.</p>
                
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

