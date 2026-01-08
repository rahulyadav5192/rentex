@extends('landing.layout')

@section('page-title', 'Our Team')
@section('meta-description', 'Meet the Propilor team - dedicated professionals working to revolutionize property and tenant management. Learn about the experts behind the leading Property Management CRM platform.')
@section('meta-keywords', 'propilor team, property management team, property software developers')
@section('og-title', 'Our Team - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Our Team</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Team</li>
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
    <!-- Start Team Section -->
    <section class="position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row cs_row_gap_30 cs_gap_y_30 justify-content-center">
                <div class="col-lg-4 col-md-6">
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
                <div class="col-lg-4 col-md-6">
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
                <div class="col-lg-4 col-md-6">
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
                <div class="col-lg-4 col-md-6">
                    <div class="cs_team cs_style_1">
                        <a href="{{ route('landing.team-details') }}" class="cs_team_thumbnail cs_radius_100 cs_center position-relative z-1">
              <img src="{{ asset('landing/assets/img/team-img-4.jpg') }}" alt="Team image">
              </a>
                        <div class="cs_team_info cs_radius_30 cs_white_bg cs_center_column text-center">
                            <h3 class="cs_team_title cs_fs_24 cs_semibold cs_mb_4"><a href="{{ route('landing.team-details') }}">Annette Black</a></h3>
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
                <div class="col-lg-4 col-md-6">
                    <div class="cs_team cs_style_1">
                        <a href="{{ route('landing.team-details') }}" class="cs_team_thumbnail cs_radius_100 cs_center position-relative z-1">
              <img src="{{ asset('landing/assets/img/team-img-5.jpg') }}" alt="Team image">
              </a>
                        <div class="cs_team_info cs_radius_30 cs_white_bg cs_center_column text-center">
                            <h3 class="cs_team_title cs_fs_24 cs_semibold cs_mb_4"><a href="{{ route('landing.team-details') }}">Jacob Jones</a></h3>
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
                <div class="col-lg-4 col-md-6">
                    <div class="cs_team cs_style_1">
                        <a href="{{ route('landing.team-details') }}" class="cs_team_thumbnail cs_radius_100 cs_center position-relative z-1">
              <img src="{{ asset('landing/assets/img/team-img-6.jpg') }}" alt="Team image">
              </a>
                        <div class="cs_team_info cs_radius_30 cs_white_bg cs_center_column text-center">
                            <h3 class="cs_team_title cs_fs_24 cs_semibold cs_mb_4"><a href="{{ route('landing.team-details') }}">Dianne Russell</a></h3>
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