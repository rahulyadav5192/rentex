@extends('landing.layout')

@section('page-title', 'Complete Visibility & Reports - Service Details')
@section('meta-description', 'Gain full visibility into your property operations with real-time reports. Analyze occupancy, income, expenses, and maintenance costs to make informed decisions.')
@section('meta-keywords', 'property reports, analytics, visibility, property analytics, financial reports')
@section('og-title', 'Complete Visibility & Reports - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Complete Visibility & Reports</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Complete Visibility & Reports</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Complete Visibility & Reports banner">
                </div>
                
                <p>Complete Visibility & Reports provides comprehensive insights into your property operations. With real-time reporting, you can analyze occupancy rates, income, expenses, and maintenance costs to make informed business decisions.</p>
                
                <p>Our advanced analytics help you identify trends, optimize operations, and maximize profitability. The system generates detailed reports on various aspects of your property management business.</p>
                
                <p>From financial summaries to occupancy analytics, maintenance cost breakdowns to tenant satisfaction metrics, you get all the data you need to run your property management business successfully.</p>
                
                <h2>Key Features of Complete Visibility & Reports</h2>
                <p>Our Complete Visibility & Reports solution comes with a comprehensive set of features designed to streamline your property management operations and help you achieve better results.</p>
                
                <ul>
                    <li>Real-time property operation reports</li>
                    <li>Financial analytics and summaries</li>
                    <li>Occupancy rate analysis</li>
                    <li>Expense tracking and categorization</li>
                    <li>Maintenance cost breakdowns</li>
                    <li>Customizable report generation</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Complete Visibility & Reports feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Complete Visibility & Reports feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Complete Visibility & Reports, you can streamline your operations, reduce manual work, and focus on growing your property management business. Our platform is designed to be intuitive, powerful, and scalable to meet your needs.</p>
                
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

