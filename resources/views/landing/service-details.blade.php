@extends('landing.layout')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Service Details</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Service Details</li>
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
                    <img src="{{ asset('landing/assets/img/service_img-1.jpg') }}" alt="Service details banner">
                </div>
                <p>Our UI/UX design services are crafted to elevate your digital presence with precision and creativity. We begin by understanding your goals and your audience, ensuring that every design decision aligns with your brand’s vision. Our approach
                    integrates user research, wireframing, and prototyping to create intuitive and engaging interfaces.
                </p>
                <p>We focus on delivering seamless user experiences that drive engagement and satisfaction. From concept to launch, our team is dedicated to design solutions that are not only visually appealing but also functionally robust. We continuously
                    test and refine our designs to meet the highest standards of usability.</p>
                <h2>Boost your brand with the help of our creative agency's UX design.</h2>
                <p>Enhance your brand’s impact with our creative agency's expert UX design services. We’ll craft engaging and intuitive user experiences that elevate your brand and captivate your audience.</p>
                <ul>
                    <li>consectetur placerat augue vestibulum</li>
                    <li> adipiscing elit Etiam aliquam, enim vitae</li>
                    <li>Mauris tincidunt a eget facilisis Quisque</li>
                    <li>Donec at augue ante Nam posuere mauris</li>
                    <li>Lorem ipsum dolor sit amet, consectetur</li>
                    <li>quis pretium elit placerat id Fusce egestas</li>
                </ul>
                <div class="row cs_row_gap_30 cs_gap_y_30 cs_mb_32">
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-2.jpg') }}" alt="Service image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="cs_radius_20">
                            <img src="{{ asset('landing/assets/img/service_img-3.jpg') }}" alt="Service image">
                        </div>
                    </div>
                </div>
                <p>Nam posuere mauris enim, quis pretium elit placerat id Fusce egestas nisi vel ipsum vehicula facilisis In pulvinar imperdiet venenatis Class aptent taciti sociosqu ad litora torent per conubia nostra, per inceptos himenaeos. Donec eu pulvinar
                    lorem. Etiam vestibulum ligula quis nisl feugiat, consectetur placerat augue vestibulum Nulla aliquam elit eu diam pharetra.Nam posuere mauris enim, </p>
                <p>Nam posuere mauris enim, quis pretium elit placerat id Fusce egestas nisi vel ipsum vehicula facilisis In pulvinar imperdiet venenatis Class aptent taciti sociosqu ad litora torent per conubia nostra, per inceptos himenaeos. Donec eu pulvinar
                    lorem. </p>
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