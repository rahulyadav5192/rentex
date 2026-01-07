@extends('landing.layout')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">FAQs</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">FAQs</li>
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
    <!-- Start FAQ Section -->
    <section class="cs_faq cs_style_1 position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row cs_gap_y_30 position-relative z-1">
                <div class="col-lg-5">
                    <div class="cs_section_heading cs_style_1 cs_faq_heading cs_mb_20">
                        <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                            <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                            <span>FAQ’s</span>
                            <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                        </div>
                        <h2 class="cs_section_title cs_fs_48 cs_semibold">Frequently Ask Questions</h2>
                        <p class="cs_card_desc cs_mb_32">All the generators on the Internet tend to repeat predefined chunks as necessary, making this the first true</p>
                        <a href="{{ route('landing.faqs') }}" aria-label="FAQ page link" class="cs_btn cs_style_1 cs_bg_1 cs_fs_14 cs_bold cs_white_color text-uppercase">
              <span>Check More Faq</span>
              <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
              </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="cs_faq_wrapper_1">
                        <div class="cs_accordian cs_style_2 cs_gray_bg_2 cs_radius_10 position-relative active">
                            <div class="cs_accordian_head">
                                <h3 class="cs_accordian_title cs_fs_20 cs_semibold mb-0">Q. CRM software, and how can it benefit my business?</h3>
                                <span class="cs_accordian_toggler cs_center cs_radius_100 position-absolute">
                  <i class="fa-solid fa-arrow-up"></i>
                  </span>
                            </div>
                            <div class="cs_accordian_body">
                                <p>CRM (Customer Relationship Management) software helps businesses centralize data, streamline sales processes, and improve customer.</p>
                            </div>
                        </div>
                        <div class="cs_accordian cs_style_2 cs_gray_bg_2 cs_radius_10 position-relative">
                            <div class="cs_accordian_head">
                                <h3 class="cs_accordian_title cs_fs_20 cs_semibold mb-0">Q. How do I get started with CRM software?</h3>
                                <span class="cs_accordian_toggler cs_center cs_radius_100 position-absolute">
                  <i class="fa-solid fa-arrow-up"></i>
                  </span>
                            </div>
                            <div class="cs_accordian_body">
                                <p>CRM (Customer Relationship Management) software helps businesses centralize data, streamline sales processes, and improve customer.</p>
                            </div>
                        </div>
                        <div class="cs_accordian cs_style_2 cs_gray_bg_2 cs_radius_10 position-relative">
                            <div class="cs_accordian_head">
                                <h3 class="cs_accordian_title cs_fs_20 cs_semibold mb-0">Q. Can I customize CRM software my business needs?</h3>
                                <span class="cs_accordian_toggler cs_center cs_radius_100 position-absolute">
                  <i class="fa-solid fa-arrow-up"></i>
                  </span>
                            </div>
                            <div class="cs_accordian_body">
                                <p>CRM (Customer Relationship Management) software helps businesses centralize data, streamline sales processes, and improve customer.</p>
                            </div>
                        </div>
                        <div class="cs_accordian cs_style_2 cs_gray_bg_2 cs_radius_10 position-relative">
                            <div class="cs_accordian_head">
                                <h3 class="cs_accordian_title cs_fs_20 cs_semibold mb-0">Q. How secure is my data in CRM software?</h3>
                                <span class="cs_accordian_toggler cs_center cs_radius_100 position-absolute">
                  <i class="fa-solid fa-arrow-up"></i>
                  </span>
                            </div>
                            <div class="cs_accordian_body">
                                <p>CRM (Customer Relationship Management) software helps businesses centralize data, streamline sales processes, and improve customer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cs_faq_shape_3 position-absolute">
                <img src="{{ asset('landing/assets/img/vector-12.svg') }}" alt="Vector shape">
            </div>
            <div class="cs_faq_shape_4 position-absolute">
                <img src="{{ asset('landing/assets/img/vector-13.svg') }}" alt="Vector shape">
            </div>
            <div class="cs_faq_shape_5 position-absolute">
                <img src="{{ asset('landing/assets/img/vector-14.svg') }}" alt="Vector shape">
            </div>
            <div class="cs_faq_shape_6 position-absolute">
                <img src="{{ asset('landing/assets/img/vector-15.svg') }}" alt="Vector shape">
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End FAQ Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection