@extends('landing.layout')

@section('page-title', 'Automatic Listing Syndication - Service Details')
@section('meta-description', 'Automatically syndicate your property listings to multiple platforms. Reach more potential tenants by publishing your listings across popular rental websites.')
@section('meta-keywords', 'listing syndication, property syndication, multi-platform listings, rental syndication')
@section('og-title', 'Automatic Listing Syndication - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Automatic Listing Syndication</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Automatic Listing Syndication</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Automatic Listing Syndication banner">
                </div>
                
                <p>Automatic Listing Syndication is a powerful solution designed to help you automatically publish your property listings to multiple rental platforms. With our advanced syndication system, you can reach more potential tenants by publishing your listings across popular rental websites without manual effort.</p>
                
                <p>Our system provides seamless integration with major rental platforms, allowing you to manage all your listings from one central location. Whether you want to publish to Zillow, Apartments.com, Rent.com, or other platforms, our syndication tool handles it automatically.</p>
                
                <p>Key features include automatic listing updates, multi-platform publishing, listing synchronization, and performance tracking. This ensures that your properties get maximum visibility and attract more qualified tenants.</p>
                
                <h2>Key Features of Automatic Listing Syndication</h2>
                <p>Our Automatic Listing Syndication solution comes with a comprehensive set of features designed to help you maximize your property visibility across multiple platforms.</p>
                
                <ul>
                    <li>Automatic publishing to multiple rental platforms</li>
                    <li>Real-time listing synchronization and updates</li>
                    <li>Integration with major rental websites</li>
                    <li>Listing performance analytics and tracking</li>
                    <li>Customizable listing descriptions per platform</li>
                    <li>Bulk listing management and updates</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Automatic Listing Syndication feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Automatic Listing Syndication feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Automatic Listing Syndication, you can save time, reach more potential tenants, and maximize your property visibility. Our platform is designed to be intuitive, powerful, and scalable to meet your syndication needs.</p>
                
                <p>Get started today and experience the difference that automatic listing syndication can make. Join thousands of property managers who trust Propilor to maximize their property visibility across multiple platforms.</p>
                
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

