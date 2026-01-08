@extends('landing.layout')

@section('page-title', !empty($service) ? $service['title'] . ' - Service Details' : 'Service Details')
@section('meta-description', !empty($service) ? $service['description'] : 'Learn more about Propilor\'s property and tenant management services. Detailed information about our features, tools, and how we help you manage your properties efficiently.')
@section('meta-keywords', 'property management service details, tenant management features, property software features')
@section('og-title', !empty($service) ? $service['title'] . ' - Propilor' : 'Service Details - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">{{ !empty($service) ? $service['title'] : 'Service Details' }}</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Services page link" href="{{ route('landing.services') }}">Services</a></li>
                <li class="breadcrumb-item active">{{ !empty($service) ? $service['title'] : 'Service Details' }}</li>
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
                @if(!empty($service))
                    <div class="cs_banner cs_radius_50">
                        <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="{{ $service['title'] }} banner">
                    </div>
                    
                    @foreach($service['content'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                    
                    <h2>Key Features of {{ $service['title'] }}</h2>
                    <p>Our {{ $service['title'] }} solution comes with a comprehensive set of features designed to streamline your property management operations and help you achieve better results.</p>
                    
                    <ul>
                        @foreach($service['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    
                    <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                        <div class="col-md-6">
                            <div class="cs_radius_20">
                                <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="{{ $service['title'] }} feature image">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cs_radius_20">
                                <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="{{ $service['title'] }} feature image">
                            </div>
                        </div>
                    </div>
                    
                    <p>With Propilor's {{ $service['title'] }}, you can streamline your operations, reduce manual work, and focus on growing your property management business. Our platform is designed to be intuitive, powerful, and scalable to meet your needs.</p>
                    
                    <p>Get started today and experience the difference that professional property management software can make. Join thousands of property owners and managers who trust Propilor to manage their properties efficiently.</p>
                    
                    <div class="text-center cs_mt_50">
                        <a href="{{ url('register') }}" class="cs_btn cs_style_1 cs_bg_1 cs_fs_14 cs_bold cs_white_color text-uppercase">
                            <span>Get Started Free</span>
                            <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                        </a>
                    </div>
                @else
                    <div class="cs_banner cs_radius_50">
                        <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Service details banner">
                    </div>
                    <p>Explore our comprehensive property and tenant management services designed to help you streamline operations and maximize efficiency.</p>
                    <p>Propilor offers a complete suite of tools and features to manage your properties, tenants, rent collection, maintenance, and more - all in one place.</p>
                    
                    <h2>Our Services</h2>
                    <div class="row cs_row_gap_30 cs_gap_y_30">
                        @if(!empty($services))
                            @foreach($services as $slug => $serviceItem)
                                <div class="col-md-6 col-lg-4">
                                    <div class="cs_iconbox cs_style_4 cs_radius_15 position-relative overflow-hidden">
                                        <div class="cs_iconbox_content cs_radius_15 position-relative">
                                            <div class="cs_iconbox_header cs_mb_17">
                                                <h3 class="cs_iconbox_title cs_fs_24 cs_semibold mb-0">
                                                    <a href="{{ route('landing.service-details', $slug) }}" aria-label="{{ $serviceItem['title'] }} details link">
                                                        {{ $serviceItem['title'] }}
                                                    </a>
                                                </h3>
                                            </div>
                                            <div class="cs_iconbox_info">
                                                <p class="cs_mb_25">{{ $serviceItem['description'] }}</p>
                                                <a href="{{ route('landing.service-details', $slug) }}" aria-label="{{ $serviceItem['title'] }} details link"
                                                    class="cs_btn cs_style_1 cs_fs_14 cs_bold cs_heading_color text-uppercase">
                                                    <span>READ MORE</span>
                                                    <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
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