@extends('landing.layout')

@section('page-title', 'Rent Reporting - Service Details')
@section('meta-description', 'Generate comprehensive rent reports and analytics. Track rent collection, occupancy rates, and financial performance with detailed reporting and insights.')
@section('meta-keywords', 'rent reporting, rent analytics, financial reports, property income tracking')
@section('og-title', 'Rent Reporting - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Rent Reporting</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Rent Reporting</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Rent Reporting banner">
                </div>
                
                <p>Rent Reporting is a powerful analytics and reporting solution designed to give you complete visibility into your rental income and property performance. With our advanced reporting tools, you can track rent collection, occupancy rates, and financial performance across all your properties.</p>
                
                <p>Our system provides comprehensive reports that help you make informed decisions about your property portfolio. Whether you need to track monthly rent collection, analyze occupancy trends, or generate financial statements, our reporting tools have you covered.</p>
                
                <p>Key features include automated report generation, customizable report templates, real-time data visualization, and export capabilities. This ensures that you always have the insights you need to optimize your property management operations.</p>
                
                <h2>Key Features of Rent Reporting</h2>
                <p>Our Rent Reporting solution comes with a comprehensive set of features designed to provide you with detailed insights into your rental income and property performance.</p>
                
                <ul>
                    <li>Automated rent collection reports and analytics</li>
                    <li>Real-time occupancy rate tracking</li>
                    <li>Financial performance dashboards</li>
                    <li>Customizable report templates</li>
                    <li>Export reports to PDF, Excel, and CSV formats</li>
                    <li>Historical data analysis and trend visualization</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Rent Reporting feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Rent Reporting feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Rent Reporting, you can gain valuable insights into your property performance, identify trends, and make data-driven decisions. Our platform is designed to be intuitive, powerful, and scalable to meet your reporting needs.</p>
                
                <p>Get started today and experience the difference that comprehensive rent reporting can make. Join thousands of property managers who trust Propilor to provide detailed insights into their rental operations.</p>
                
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

