@extends('landing.layout')

@section('page-title', 'Our Services')
@section('meta-description', 'Explore Propilor\'s comprehensive property and tenant management services. From automated rent collection and maintenance tracking to tenant communication and financial reporting - we provide all the tools you need to manage your properties efficiently.')
@section('meta-keywords', 'property management services, tenant management services, property management features, rental management tools, property software features')
@section('og-title', 'Our Services - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Our Services</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
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
    <!-- Start Features Section -->
    <section class="position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_features_items_wrapper position-relative z-1">
                <div class="cs_feature_item cs_radius_20 cs_bg_filed" data-src="{{ asset('landing/assets/img/feature-item-bg.svg') }}">
                    <h3 class="cs_fs_36 cs_semibold cs_white_color cs_mb_40">See more and get visibility <br> for your business</h3>
                    <a href="{{ route('landing.contact') }}" aria-label="Get started button" class="cs_btn cs_style_1 cs_fs_14 cs_bold cs_white_color text-uppercase">
            <span>Get Started</span>
            <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
                </div>
                <div class="cs_feature_item cs_white_bg cs_radius_20">
                    <span class="cs_feature_icon cs_center cs_radius_12 cs_mb_15">
            <img src="{{ asset('landing/assets/img/icons/code-icon.svg') }}" alt="Coding icon">
            </span>
                    <h3 class="cs_fs_24 cs_semibold cs_mb_6">
                        <a href="{{ route('landing.service-details') }}" aria-label="Service details link">Software Development</a>
                    </h3>
                    <ul class="cs_features_list cs_mp_0">
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Security</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Agile Methodologies</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Clear Requirements</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Feedback &  Improvement</span>
                        </li>
                    </ul>
                    <a href="{{ route('landing.service-details') }}" aria-label="Service details link" class="cs_text_btn cs_fs_14 cs_bold text-uppercase">
            <span>Read More</span>
            <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
                </div>
                <div class="cs_feature_item cs_white_bg cs_radius_20">
                    <span class="cs_feature_icon cs_center cs_bg_1 cs_radius_12 cs_mb_15">
            <img src="{{ asset('landing/assets/img/icons/cloud-computing.svg') }}" alt="Cloud computing icon">
            </span>
                    <h3 class="cs_fs_24 cs_semibold cs_mb_6">
                        <a href="{{ route('landing.service-details') }}" aria-label="Service details link">Cloud Computing Solutions</a>
                    </h3>
                    <ul class="cs_features_list cs_mp_0">
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Security</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Agile Methodologies</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Clear Requirements</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Feedback &  Improvement</span>
                        </li>
                    </ul>
                    <a href="{{ route('landing.service-details') }}" aria-label="Service details link" class="cs_text_btn cs_fs_14 cs_bold text-uppercase">
            <span>Read More</span>
            <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
                </div>
                <div class="cs_feature_item cs_white_bg cs_radius_20">
                    <span class="cs_feature_icon cs_bg_2 cs_center cs_radius_12 cs_mb_15">
            <img src="{{ asset('landing/assets/img/icons/quality-assurance.svg') }}" alt="Quality assurance icon">
            </span>
                    <h3 class="cs_fs_24 cs_semibold cs_mb_6">
                        <a href="{{ route('landing.service-details') }}" aria-label="Service details link">Quality Assurance</a>
                    </h3>
                    <ul class="cs_features_list cs_mp_0">
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Security</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Agile Methodologies</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Clear Requirements</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Feedback &  Improvement</span>
                        </li>
                    </ul>
                    <a href="{{ route('landing.service-details') }}" aria-label="Service details link" class="cs_text_btn cs_fs_14 cs_bold text-uppercase">
            <span>Read More</span>
            <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
                </div>
                <div class="cs_feature_item cs_white_bg cs_radius_20">
                    <span class="cs_feature_icon cs_bg_3 cs_center cs_radius_12 cs_mb_15">
            <img src="{{ asset('landing/assets/img/icons/security.svg') }}" alt="Cybersecurity security icon">
            </span>
                    <h3 class="cs_fs_24 cs_semibold cs_mb_6">
                        <a href="{{ route('landing.service-details') }}" aria-label="Service details link">Cybersecurity Services</a>
                    </h3>
                    <ul class="cs_features_list cs_mp_0">
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Security</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Agile Methodologies</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Clear Requirements</span>
                        </li>
                        <li>
                            <img src="{{ asset('landing/assets/img/icons/caret-icon.svg') }}" alt="Caret icon">
                            <span>Feedback &  Improvement</span>
                        </li>
                    </ul>
                    <a href="{{ route('landing.service-details') }}" aria-label="Service details link" class="cs_text_btn cs_fs_14 cs_bold text-uppercase">
            <span>Read More</span>
            <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
            </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Features Section -->
    <!-- Start Features Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_section_heading cs_style_1 cs_center_column cs_mb_47 text-center">
                <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                    <span>Awesome Feature</span>
                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                </div>
                <h2 class="cs_section_title cs_fs_48 cs_semibold mb-0">Our Fantastic App Features</h2>
            </div>
            <div class="cs_features_steps_wrapper">
                <div class="cs_feature_step cs_center_column">
                    <div class="cs_step_index cs_radius_50 cs_fs_14 cs_semibold cs_heading_color text-uppercase"><span>Step One</span></div>
                    <div class="cs_vertical_line"></div>
                    <div class="cs_step_indfo_wrapper cs_radius_30 text-center position-relative">
                        <h3 class="cs_fs_24 cs_semibold cs_mb_10">Download App</h3>
                        <p class="mb-0">All the generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
                        <img src="{{ asset('landing/assets/img/border-shape.png') }}" alt="Border shape">
                    </div>
                </div>
                <div class="cs_feature_step cs_center_column">
                    <div class="cs_step_index cs_radius_50 cs_fs_14 cs_semibold cs_heading_color text-uppercase"><span>Step Two</span></div>
                    <div class="cs_vertical_line"></div>
                    <div class="cs_step_indfo_wrapper cs_radius_30 text-center position-relative">
                        <h3 class="cs_fs_24 cs_semibold cs_mb_10">Create account</h3>
                        <p class="mb-0">All the generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
                        <img src="{{ asset('landing/assets/img/border-shape.png') }}" alt="Border shape">
                    </div>
                </div>
                <div class="cs_feature_step cs_center_column">
                    <div class="cs_step_index cs_radius_50 cs_fs_14 cs_semibold cs_heading_color text-uppercase"><span>Step Three</span></div>
                    <div class="cs_vertical_line"></div>
                    <div class="cs_step_indfo_wrapper cs_radius_30 text-center position-relative">
                        <h3 class="cs_fs_24 cs_semibold cs_mb_10">Install App, & Enjoy</h3>
                        <p class="mb-0">All the generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
                        <img src="{{ asset('landing/assets/img/border-shape.png') }}" alt="Border shape">
                    </div>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Features Section -->
    <!-- Start Customization Section -->
    <section class="position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_card cs_style_1 cs_type_3">
                <div class="row cs_gap_y_50 position-relative z-1">
                    <div class="col-lg-6">
                        <div class="cs_card_thumbnail position-relative">
                            <img src="{{ asset('landing/assets/img/dashboard.png') }}" alt="Dashboard image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="cs_card_content">
                            <div class="cs_section_heading cs_style_1 cs_mb_27">
                                <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                                    <span>Customizations & Analysis</span>
                                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                                </div>
                                <h2 class="cs_section_title cs_fs_48 cs_semibold">We Make It Easy To Track All User Analytics</h2>
                                <p class="cs_card_desc mb-0">All the generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
                            </div>
                            <div class="cs_iconbox_wrapper_1">
                                <div class="cs_iconbox cs_style_1 cs_type_1">
                                    <span class="cs_iconbox_icon cs_center cs_accent_bg">
                    <img src="{{ asset('landing/assets/img/icons/advanced-tracking.svg') }}" alt="Advanced tracking icon">
                    </span>
                                    <div class="cs_iconbox_info">
                                        <h3 class="cs_fs_20 cs_semibold cs_mb_1">Advanced tracking</h3>
                                        <p class="mb-0">All the generators on the Internet tend to repeat predefined chunks as</p>
                                    </div>
                                </div>
                                <div class="cs_iconbox cs_style_1 cs_type_1">
                                    <span class="cs_iconbox_icon cs_center cs_bg_1">
                    <img src="{{ asset('landing/assets/img/icons/in-depth.svg') }}" alt="In-depth monitoring icon">
                    </span>
                                    <div class="cs_iconbox_info">
                                        <h3 class="cs_fs_20 cs_semibold cs_mb_1">In-depth monitoring</h3>
                                        <p class="mb-0">All the generators on the Internet tend to repeat predefined chunks as</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Customization Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection