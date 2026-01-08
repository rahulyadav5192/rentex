@extends('landing.layout')

@section('page-title', 'Blog')
@section('meta-description', 'Read the latest articles, tips, and insights about property management, tenant management, and real estate industry trends. Stay updated with Propilor blog for best practices and expert advice.')
@section('meta-keywords', 'property management blog, tenant management articles, property management tips, real estate blog, property management news')
@section('og-title', 'Blog - Propilor')

@section('content')
<!-- Start Page Heading -->
        <section class="cs_page_heading cs_style_hero text-center position-relative">
            <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
            <div class="container">
                <h1 class="cs_fs_64 cs_bold cs_mb_8">Our Blog</h1>
                <ol class="breadcrumb cs_fs_18 cs_heading_font">
                    <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
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
        <!-- Start Blog Section -->
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row cs_row_gap_30 cs_gap_y_30">
                <div class="col-lg-4 col-md-6">
                    <article class="cs_post cs_style_1 cs_radius_20">
                        <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
  <img src="{{ asset('landing/assets/img/post-img-1.jpg') }}" alt="Post image">
  <span class="cs_post_category cs_heading_bg cs_fs_14 cs_medium cs_white_color position-absolute">Development</span>
  </a>
                        <div class="cs_post_content">
                            <div class="cs_post_meta_wrapper cs_mb_12">
                                <div class="cs_post_meta">
                                    <span><i class="fa-regular fa-user"></i></span>
                                    <span>Adam Smith</span>
                                </div>
                                <div class="cs_post_meta">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <span>11 Jan, 2025</span>
                                </div>
                            </div>
                            <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13"><a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link">How to Comprehensive at SaaS Developments.</a></h3>
                            <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
  <span>Learn More</span>
  <span>
  <i class="fa-solid fa-arrow-right"></i>
  </span>
  </a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="cs_post cs_style_1 cs_radius_20">
                        <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
  <img src="{{ asset('landing/assets/img/post-img-2.jpg') }}" alt="Post image">
  <span class="cs_post_category cs_fs_14 cs_medium cs_heading_bg cs_white_color position-absolute">Technology</span>
  </a>
                        <div class="cs_post_content">
                            <div class="cs_post_meta_wrapper cs_mb_12">
                                <div class="cs_post_meta">
                                    <span><i class="fa-regular fa-user"></i></span>
                                    <span>Adam Smith</span>
                                </div>
                                <div class="cs_post_meta">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <span>11 Jan, 2025</span>
                                </div>
                            </div>
                            <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13"><a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link">6 Essential Tips for Big Commerce Stores</a></h3>
                            <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
  <span>Learn More</span>
  <span>
  <i class="fa-solid fa-arrow-right"></i>
  </span>
  </a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="cs_post cs_style_1 cs_radius_20">
                        <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
  <img src="{{ asset('landing/assets/img/post-img-3.jpg') }}" alt="Post image">
  <span class="cs_post_category cs_heading_bg cs_fs_14 cs_medium cs_white_color position-absolute">Marketing</span>
  </a>
                        <div class="cs_post_content">
                            <div class="cs_post_meta_wrapper cs_mb_12">
                                <div class="cs_post_meta">
                                    <span><i class="fa-regular fa-user"></i></span>
                                    <span>Adam Smith</span>
                                </div>
                                <div class="cs_post_meta">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <span>11 Jan, 2025</span>
                                </div>
                            </div>
                            <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13"><a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link">Empowering Startups & Small Businesses</a></h3>
                            <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
  <span>Learn More</span>
  <span>
  <i class="fa-solid fa-arrow-right"></i>
  </span>
  </a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="cs_post cs_style_1 cs_radius_20">
                        <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
  <img src="{{ asset('landing/assets/img/post-img-4.jpg') }}" alt="Post image">
  <span class="cs_post_category cs_heading_bg cs_fs_14 cs_medium cs_white_color position-absolute">Development</span>
  </a>
                        <div class="cs_post_content">
                            <div class="cs_post_meta_wrapper cs_mb_12">
                                <div class="cs_post_meta">
                                    <span><i class="fa-regular fa-user"></i></span>
                                    <span>Adam Smith</span>
                                </div>
                                <div class="cs_post_meta">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <span>11 Jan, 2025</span>
                                </div>
                            </div>
                            <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13"><a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link">The Ultimate Guide to Responsive Design in 2025</a></h3>
                            <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
  <span>Learn More</span>
  <span>
  <i class="fa-solid fa-arrow-right"></i>
  </span>
  </a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="cs_post cs_style_1 cs_radius_20">
                        <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
  <img src="{{ asset('landing/assets/img/post-img-5.jpg') }}" alt="Post image">
  <span class="cs_post_category cs_fs_14 cs_medium cs_heading_bg cs_white_color position-absolute">Technology</span>
  </a>
                        <div class="cs_post_content">
                            <div class="cs_post_meta_wrapper cs_mb_12">
                                <div class="cs_post_meta">
                                    <span><i class="fa-regular fa-user"></i></span>
                                    <span>Adam Smith</span>
                                </div>
                                <div class="cs_post_meta">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <span>11 Jan, 2025</span>
                                </div>
                            </div>
                            <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13"><a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link">Top 10 Web Design Trends You Shouldn’t Miss</a></h3>
                            <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
  <span>Learn More</span>
  <span>
  <i class="fa-solid fa-arrow-right"></i>
  </span>
  </a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4 col-md-6">
                    <article class="cs_post cs_style_1 cs_radius_20">
                        <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
  <img src="{{ asset('landing/assets/img/post-img-6.jpg') }}" alt="Post image">
  <span class="cs_post_category cs_heading_bg cs_fs_14 cs_medium cs_white_color position-absolute">Marketing</span>
  </a>
                        <div class="cs_post_content">
                            <div class="cs_post_meta_wrapper cs_mb_12">
                                <div class="cs_post_meta">
                                    <span><i class="fa-regular fa-user"></i></span>
                                    <span>Adam Smith</span>
                                </div>
                                <div class="cs_post_meta">
                                    <span><i class="fa-solid fa-calendar-days"></i></span>
                                    <span>11 Jan, 2025</span>
                                </div>
                            </div>
                            <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13"><a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link">Boost Your SEO with These Simple Webflow Tweaks</a></h3>
                            <a href="{{ route('landing.blog-details') }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
  <span>Learn More</span>
  <span>
  <i class="fa-solid fa-arrow-right"></i>
  </span>
  </a>
                        </div>
                    </article>
                </div>
            </div>
            <div class="cs_height_60 cs_height_lg_50"></div>
            <ul class="pagination cs_center cs_heading_font cs_mp_0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item disabled"><span>...</span></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <!-- End Blog Section -->
        
        <!-- Start Scroll Up Button -->
        <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
  </svg>
  </button>
        <!-- End Scroll Up Button -->
    @endsection