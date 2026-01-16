@extends('landing.layout')

@section('page-title', 'Team Management - Service Details')
@section('meta-description', 'Manage your property management team efficiently. Assign roles, track tasks, and collaborate with team members to streamline operations.')
@section('meta-keywords', 'team management, property team, collaboration, team roles')
@section('og-title', 'Team Management - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Team Management</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Team Management</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Team Management banner">
                </div>
                
                <p>Team Management is a comprehensive solution designed to help you manage your property management team efficiently. With our advanced platform, you can assign roles, track tasks, and collaborate with team members to streamline operations and improve productivity.</p>
                
                <p>Our system provides a centralized dashboard that gives you complete visibility into your team's activities and performance. Whether you have a small team or a large organization, our team management tools help you stay organized and ensure everyone is working efficiently.</p>
                
                <p>Key features include role-based access control, task assignment and tracking, team communication tools, performance analytics, and activity logs. This ensures that your team can collaborate effectively and deliver exceptional service to your tenants.</p>
                
                <h2>Key Features of Team Management</h2>
                <p>Our Team Management solution comes with a comprehensive set of features designed to help you manage your property management team effectively.</p>
                
                <ul>
                    <li>Role-based access control and permissions</li>
                    <li>Task assignment and tracking system</li>
                    <li>Team communication and collaboration tools</li>
                    <li>Performance analytics and reporting</li>
                    <li>Activity logs and audit trails</li>
                    <li>Team member profiles and contact management</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Team Management feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Team Management feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Team Management, you can streamline your team operations, improve collaboration, and ensure everyone is working efficiently. Our platform is designed to be intuitive, powerful, and scalable to meet your team management needs.</p>
                
                <p>Get started today and experience the difference that professional team management can make. Join thousands of property managers who trust Propilor to manage their teams effectively.</p>
                
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

