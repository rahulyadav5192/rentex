@extends('landing.layout')

@section('page-title', 'Page Not Found')
@section('meta-description', 'The page you are looking for could not be found. Return to Propilor homepage to explore our Property and Tenant Management CRM platform.')
@section('meta-keywords', '404 error, page not found')
@section('og-title', 'Page Not Found - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Error page</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Error page</li>
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
    <!-- Start Error Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="cs_center_column text-center">
                        <div class="cs_error_img cs_mb_15">
                            <img src="{{ asset('landing/assets/img/404.png') }}" alt="404 image">
                        </div>
                        <h2 class="cs_fs_48 cs_semibold cs_mb_10">Opp’s That Page Can’t be Found</h2>
                        <p class="cs_mb_33">It looks like nothing was found at this location. Maybe try one of <br> the links below or a search?</p>
                        <a href="{{ route('landing.contact') }}" aria-label="Back to home page button" class="cs_btn cs_style_1 cs_bg_1 cs_fs_14 cs_bold cs_white_color">
              <span class="cs_btn_icon"><i class="fa-solid fa-house"></i></span>
              <span>BACK TO HOME</span>
              </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Error Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection