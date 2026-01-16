@extends('landing.layout')

@section('page-title', 'Listing Website - Service Details')
@section('meta-description', 'Create a professional listing website for your properties. Showcase your available units with beautiful photos, detailed descriptions, and online application forms.')
@section('meta-keywords', 'property listing website, property showcase, online listings, property marketing')
@section('og-title', 'Listing Website - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Listing Website</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">Listing Website</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Listing Website banner">
                </div>
                
                <p>Listing Website is a powerful solution designed to help you create a professional, mobile-responsive website to showcase your available properties. With our platform, you can create beautiful property listings with photos, detailed descriptions, and online application forms.</p>
                
                <p>Our system provides a customizable website builder that allows you to create a unique online presence for your property business. Whether you manage residential apartments, commercial spaces, or vacation rentals, our listing website helps you attract more qualified tenants.</p>
                
                <p>Key features include responsive design, SEO optimization, online application integration, virtual tour support, and social media sharing. This ensures that your properties get maximum visibility and attract the right tenants.</p>
                
                <h2>Key Features of Listing Website</h2>
                <p>Our Listing Website solution comes with a comprehensive set of features designed to help you create a professional online presence for your properties.</p>
                
                <ul>
                    <li>Customizable website templates and themes</li>
                    <li>Mobile-responsive design for all devices</li>
                    <li>High-quality photo galleries and virtual tours</li>
                    <li>SEO optimization for better search visibility</li>
                    <li>Online application and inquiry forms</li>
                    <li>Social media integration and sharing</li>
                </ul>
                
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Listing Website feature image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Listing Website feature image">
                        </div>
                    </div>
                </div>
                
                <p>With Propilor's Listing Website, you can create a professional online presence for your properties, attract more qualified tenants, and streamline your rental process. Our platform is designed to be intuitive, powerful, and scalable to meet your marketing needs.</p>
                
                <p>Get started today and experience the difference that a professional listing website can make. Join thousands of property managers who trust Propilor to showcase their properties online.</p>
                
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

