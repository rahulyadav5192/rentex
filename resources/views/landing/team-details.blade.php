@extends('landing.layout')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Team Details</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Team Details</li>
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
    <!-- Start Team Details Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_team_details">
                <div class="cs_team_info_wrapper cs_gray_bg_2 cs_radius_50">
                    <div class="row cs_gap_y_40">
                        <div class="col-lg-5">
                            <div class="cs_team_thumbnail cs_radius_30">
                                <img src="{{ asset('landing/assets/img/team-img-7.jpg') }}" alt="Team image">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="cs_team_info">
                                <div class="cs_team_header cs_mb_26">
                                    <div class="cs_team_heading">
                                        <h3 class="cs_fs_48 cs_semibold">Olivia Martinez</h3>
                                        <p class="mb-0">Gemini market</p>
                                    </div>
                                    <div class="cs_social_links cs_style_1">
                                        <a href="#" class="cs_center cs_radius_50">
                      <i class="fa-brands fa-facebook-f"></i>
                      </a>
                                        <a href="#" class="cs_center cs_radius_50">
                      <i class="fa-brands fa-x-twitter"></i>
                      </a>
                                        <a href="#" class="cs_center cs_radius_50">
                      <i class="fa-brands fa-linkedin-in"></i>
                      </a>
                                        <a href="#" class="cs_center cs_radius_50">
                      <i class="fa-brands fa-youtube"></i>
                      </a>
                                    </div>
                                </div>
                                <p>Our UI/UX design services are crafted to elevate your digital presence with precision and creativity. We begin by understanding your goals and your audience, ensuring that every design decision </p>
                                <p>Aligns with your brand’s vision. Our approach integrates user research, wireframing, and prototyping to create intuitive and engaging interfaces.</p>
                                <ul class="cs_contact_list cs_mp_0">
                                    <li>
                                        <span class="cs_contact_icon cs_center cs_radius_100 cs_white_bg"><i class="fa-solid fa-phone-volume"></i></span>
                                        <a href="tel:+9156980036420">+91 5698 0036 420</a>
                                    </li>
                                    <li>
                                        <span class="cs_contact_icon cs_center cs_radius_100 cs_white_bg"><i class="fa-solid fa-paper-plane"></i></span>
                                        <a href="mailto:info@Reiatix.com">info@Reiatix.com</a>
                                    </li>
                                    <li>
                                        <span class="cs_contact_icon cs_center cs_radius_100 cs_white_bg"><i class="fa-solid fa-location-dot"></i></span>
                                        <span class="mb-0">26 Manor St, Braintree UK</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cs_team_about">
                    <h2>About Olivia Martinez</h2>
                    <p>Our UI/UX design services are crafted to elevate your digital presence with precision and creativity. We begin by understanding your goals and your audience, ensuring that every design decision aligns with your brand’s vision. Our
                        approach integrates user research, wireframing, and prototyping to create intuitive and engaging interfaces.
                    </p>
                    <p>We focus on delivering seamless user experiences that drive engagement and satisfaction. From concept to launch, our team is dedicated to design solutions that are not only visually appealing but also functionally robust. We continuously
                        test and refine our designs to meet the highest standards of usability.</p>
                    <ul>
                        <li>consectetur placerat augue vestibulum</li>
                        <li>Mauris tincidunt a eget facilisis Quisque </li>
                        <li>Lorem ipsum dolor sit amet, consectetur </li>
                    </ul>
                    <p>Nam posuere mauris enim, quis pretium elit placerat id Fusce egestas nisi vel ipsum vehicula facilisis In pulvinar imperdiet venenatis Class aptent taciti sociosqu ad litora torent per conubia nostra, per inceptos himenaeos. Donec
                        eu pulvinar lorem. Etiam vestibulum ligula quis nisl feugiat, consectetur placerat augue vestibulum Nulla aliquam elit eu diam pharetra.Nam posuere mauris enim,</p>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Team Details Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection