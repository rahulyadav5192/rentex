@extends('landing.layout')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">About Us</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">About Us</li>
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
    <!-- Start Feature Section -->
    <section class="position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_card cs_style_2 position-relative z-1">
                <div class="row cs_gap_y_40">
                    <div class="col-lg-6 order-lg-2">
                        <div class="cs_card_thumbnail">
                            <img src="{{ asset('landing/assets/img/dashboard-2.png') }}" alt="Dashboard image">
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="cs_card_content">
                            <div class="cs_section_heading cs_style_1 cs_mb_34">
                                <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                                    <span>Appreciation feature</span>
                                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                                </div>
                                <h2 class="cs_section_title cs_fs_48 cs_semibold">Our Priority CRM Options For The Future</h2>
                                <p class="mb-0">CRM management is comprehensive contact management, allowing businesses to centralize and organize customer information for easy access.</p>
                            </div>
                            <div class="cs_service_item cs_radius_15 cs_gray_bg_2 cs_mb_24 cs_active">
                                <h3 class="cs_service_title cs_fs_24 cs_semibold cs_mb_8">Sales Force Automation</h3>
                                <p class="mb-0">CRM management is comprehensive contact management, allowing businesses to centralize and organize customer information for allowing businesses to centralize and organize easy access.</p>
                            </div>
                            <div class="cs_service_item cs_radius_15 cs_mb_48">
                                <h3 class="cs_service_title cs_fs_24 cs_semibold cs_mb_8">Lead Management</h3>
                                <p class="mb-0">CRM management is comprehensive contact management, allowing businesses to centralize and organize customer information for allowing businesses to centralize and organize easy access.</p>
                            </div>
                            <div class="cs_btns_group">
                                <a href="{{ route('landing.contact') }}" aria-label="Get started button" class="cs_btn cs_style_1 cs_bg_1 cs_fs_14 cs_bold cs_white_color text-uppercase">
                  <span>Get Started Free</span>
                  <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                  </a>
                                <div class="cs_client_info_wrapper">
                                    <img src="{{ asset('landing/assets/img/customers-group.png') }}" alt="Customers image">
                                    <div>
                                        <h3 class="cs_fs_30 cs_semibold mb-0">3.5k <span>+</span></h3>
                                        <p class="cs_heading_color mb-0">Active Customer</p>
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
    <!-- End Feature Section -->
    <!-- Start Customer Review Section -->
    <section class="cs_customer_review cs_bg_filed cs_radius_50" data-src="{{ asset('landing/assets/img/rating-bg-1.svg') }}">
        <div class="container">
            <div class="cs_section_heading cs_style_1 text-center cs_mb_47">
                <h2 class="cs_fs_48 cs_semibold cs_white_color mb-0">Customers Have Consistently <br> Rated Saaso 4.9/5</h2>
            </div>
            <div class="row cs_row_gap_30 cs_gap_y_30">
                <div class="col-lg-4">
                    <div class="cs_review_item cs_center_column cs_radius_20 text-center">
                        <div class="cs_rating_container cs_center cs_mb_32">
                            <div class="cs_rating" data-rating="0">
                                <div class="cs_rating_percentage"></div>
                            </div>
                        </div>
                        <p class="cs_fs_20 cs_white_color cs_mb_33">"The Interface Is Excellent"</p>
                        <img src="{{ asset('landing/assets/img/rating-logo-1.svg') }}" alt="Logo">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cs_review_item cs_center_column cs_radius_20 text-center">
                        <div class="cs_rating_container cs_center cs_mb_32">
                            <div class="cs_rating" data-rating="0">
                                <div class="cs_rating_percentage"></div>
                            </div>
                        </div>
                        <p class="cs_fs_20 cs_white_color cs_mb_33">"Improvements In Every Release"</p>
                        <img src="{{ asset('landing/assets/img/rating-logo-2.svg') }}" alt="Logo">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cs_review_item cs_center_column cs_radius_20 text-center">
                        <div class="cs_rating_container cs_center cs_mb_32">
                            <div class="cs_rating" data-rating="0">
                                <div class="cs_rating_percentage"></div>
                            </div>
                        </div>
                        <p class="cs_fs_20 cs_white_color cs_mb_33">"The Interface Is Excellent"</p>
                        <img src="{{ asset('landing/assets/img/rating-logo-3.svg') }}" alt="Logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Customer Review Section -->
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
    <!-- Start Counter Section -->
    <div class="cs_counter cs_style_1 cs_type_1 cs_accent_bg" data-src="{{ asset('landing/assets/img/counter-bg-2.svg') }}">
        <div class="container">
            <div class="row cs_gap_y_30">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs_numberbox cs_center_column text-center">
                        <div class="cs_counter_number cs_fs_48 cs_semibold cs_white_color cs_mb_10">
                            <span class="odometer" data-count-to="16"></span>K+
                        </div>
                        <p class="cs_fs_24 cs_heading_font mb-0">Completed Our <br> Projects</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs_numberbox cs_center_column text-center">
                        <div class="cs_counter_number cs_fs_48 cs_semibold cs_white_color cs_mb_10">
                            <span class="odometer" data-count-to="180"></span>+
                        </div>
                        <p class="cs_fs_24 cs_heading_font mb-0">Our Expert Support <br> Team Members</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs_numberbox cs_center_column text-center">
                        <div class="cs_counter_number cs_fs_48 cs_semibold cs_white_color cs_mb_10">
                            <span class="odometer" data-count-to="6"></span>K+
                        </div>
                        <p class="cs_fs_24 cs_heading_font mb-0">Our Worldwide <br> Clients</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs_numberbox cs_center_column text-center">
                        <div class="cs_counter_number cs_fs_48 cs_semibold cs_white_color cs_mb_10">
                            <span class="odometer" data-count-to="35"></span>+
                        </div>
                        <p class="cs_fs_24 cs_heading_font mb-0">We are Winning <br> Awards</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Counter Section -->
    <!-- Start Customer Story Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_card cs_style_1 cs_type_5">
                <div class="row cs_gap_y_30">
                    <div class="col-lg-5 order-lg-2">
                        <a href="https://www.youtube.com/embed/HC-tgFdIcB0" aria-label="Click to play video" class="cs_video cs_style_1 cs_center cs_video_open cs_bg_filed cs_radius_15 position-relative" data-src="{{ asset('landing/assets/img/video-bg-1.jpg') }}">
                <span class="cs_player_btn cs_style_1 cs_center cs_radius_100 cs_theme_bg_2 cs_white_color position-relative"><i class="fa-solid fa-play"></i>
                </span>
                <div class="cs_vector_shape_5 position-absolute">
                  <img src="{{ asset('landing/assets/img/vector-10.svg') }}" alt="Vector shape">
                </div>
              </a>
                    </div>
                    <div class="col-lg-7 order-lg-1">
                        <div class="cs_card_content">
                            <div class="cs_section_heading cs_style_1 cs_mb_20">
                                <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                                    <span>Costumer Story</span>
                                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                                </div>
                                <h2 class="cs_section_title cs_fs_48 cs_semibold text-capitalize mb-0">How a certain consumer used a product successfully</h2>
                            </div>
                            <p class="cs_card_desc cs_mb_51">CRM management is comprehensive contact management, allowing businesses to centralize and organize customer information for easy access.</p>
                            <div class="cs_btns_group">
                                <a href="#" aria-label="Get started button" class="cs_btn cs_style_1 cs_bg_1 cs_fs_14 cs_bold cs_white_color text-uppercase">
                  <span>read costumer story </span>
                  <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                  </a>
                                <div class="cs_client_info_wrapper">
                                    <img src="{{ asset('landing/assets/img/customers-group-2.png') }}" alt="Customers image">
                                    <div>
                                        <h3 class="cs_fs_18 cs_normal mb-0">Happy Costumer</h3>
                                        <p class="mb-0"><span class="cs_theme_color_5"><i class="fa-solid fa-star"></i></span> 3.5(10k Review)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Customer Story Section -->
    <!-- Start Testimonial Section -->
    <section class="cs_slider cs_style_1 cs_slider_gap_30 position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_testimonial_slider_wrapper cs_radius_20 position-relative">
                <div class="cs_section_heading cs_style_1 cs_mb_10">
                    <h2 class="cs_section_title cs_fs_24 cs_normal mb-0">Clients Feedback</h2>
                </div>
                <div class="cs_slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-center="0" data-variable-width="0" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="1" data-md-slides="1" data-lg-slides="1" data-add-slides="1">
                    <div class="cs_slider_wrapper">
                        <div class="cs_slide">
                            <div class="cs_testimonial cs_style_2">
                                <div class="cs_testimonial_heading cs_mb_10">
                                    <span class="cs_quote_icon cs_center cs_white_bg cs_radius_100">
                    <img src="{{ asset('landing/assets/img/icons/qote.svg') }}" alt="Quote icon">
                    </span>
                                    <div class="cs_rating" data-rating="5">
                                        <div class="cs_rating_percentage"></div>
                                    </div>
                                </div>
                                <blockquote>This is why having reviews and client testimonials is so important for your business. So, in this article, go over some client testimonial examples you should be aware of and how you can go about gathering those testimonials
                                    for yourself. This is why having reviews and client testimonials is so important for your business. So, in this article, we’ll go over some client testimonial</blockquote>
                                <div class="cs_avatar cs_style_1">
                                    <span class="cs_avatar_icon cs_center cs_radius_100">
                    <img src="{{ asset('landing/assets/img/avatar-5.jpg') }}" alt="Avatar">
                    </span>
                                    <div class="cs_avatar_info">
                                        <h3 class="cs_fs_20 cs_semibold mb-0">Juliana Rose</h3>
                                        <p class="cs_fs_14 mb-0">Marketing Manager</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cs_slide">
                            <div class="cs_testimonial cs_style_2">
                                <div class="cs_testimonial_heading cs_mb_10">
                                    <span class="cs_quote_icon cs_center cs_white_bg cs_radius_100">
                    <img src="{{ asset('landing/assets/img/icons/qote.svg') }}" alt="Quote icon">
                    </span>
                                    <div class="cs_rating" data-rating="5">
                                        <div class="cs_rating_percentage"></div>
                                    </div>
                                </div>
                                <blockquote>This is why having reviews and client testimonials is so important for your business. So, in this article, go over some client testimonial examples you should be aware of and how you can go about gathering those testimonials
                                    for yourself. This is why having reviews and client testimonials is so important for your business. So, in this article, we’ll go over some client testimonial</blockquote>
                                <div class="cs_avatar cs_style_1">
                                    <span class="cs_avatar_icon cs_center cs_radius_100">
                    <img src="{{ asset('landing/assets/img/avatar-6.jpg') }}" alt="Avatar">
                    </span>
                                    <div class="cs_avatar_info">
                                        <h3 class="cs_fs_20 cs_semibold mb-0">Anjelina Rose</h3>
                                        <p class="cs_fs_14 mb-0">UI/UX Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cs_slider_arrows cs_style_1">
                        <div class="cs_right_arrow rounded-circle cs_center cs_white_bg cs_theme_color_2 slick-arrow">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonial Section -->
    <!-- Start Team Section -->
    <section class="position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_section_heading cs_style_1 cs_center_column cs_mb_47 text-center position-relative z-1">
                <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                    <span>Our Team</span>
                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                </div>
                <h2 class="cs_section_title cs_fs_48 cs_semibold mb-0">Our Experts Team Member</h2>
            </div>
            <div class="row cs_row_gap_30 cs_gap_y_30 justify-content-center">
                <div class="col-lg-4">
                    <div class="cs_team cs_style_1">
                        <a href="{{ route('landing.team-details') }}" class="cs_team_thumbnail cs_radius_100 cs_center position-relative z-1">
              <img src="{{ asset('landing/assets/img/team-img-1.jpg') }}" alt="Team image">
              </a>
                        <div class="cs_team_info cs_radius_30 cs_white_bg cs_center_column text-center">
                            <h3 class="cs_team_title cs_fs_24 cs_semibold cs_mb_4"><a href="{{ route('landing.team-details') }}">Miler Michel</a></h3>
                            <p class="cs_fs_18 cs_heading_color cs_mb_12">co-Founder</p>
                            <div class="cs_social_links cs_style_1">
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-pinterest-p"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cs_team cs_style_1">
                        <a href="{{ route('landing.team-details') }}" class="cs_team_thumbnail cs_radius_100 cs_center position-relative z-1">
              <img src="{{ asset('landing/assets/img/team-img-2.jpg') }}" alt="Team image">
              </a>
                        <div class="cs_team_info cs_radius_30 cs_white_bg cs_center_column text-center">
                            <h3 class="cs_team_title cs_fs_24 cs_semibold cs_mb_4"><a href="{{ route('landing.team-details') }}">Olivia Martinez</a></h3>
                            <p class="cs_fs_18 cs_heading_color cs_mb_12">co-Founder</p>
                            <div class="cs_social_links cs_style_1">
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-pinterest-p"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cs_team cs_style_1">
                        <a href="{{ route('landing.team-details') }}" class="cs_team_thumbnail cs_radius_100 cs_center position-relative z-1">
              <img src="{{ asset('landing/assets/img/team-img-3.jpg') }}" alt="Team image">
              </a>
                        <div class="cs_team_info cs_radius_30 cs_white_bg cs_center_column text-center">
                            <h3 class="cs_team_title cs_fs_24 cs_semibold cs_mb_4"><a href="{{ route('landing.team-details') }}">Scarlett Adams</a></h3>
                            <p class="cs_fs_18 cs_heading_color cs_mb_12">HR manager</p>
                            <div class="cs_social_links cs_style_1">
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" aria-label="Social link"><i class="fa-brands fa-pinterest-p"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Team Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection