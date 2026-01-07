@extends('landing.layout')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Contact Us</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Contact Us</li>
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
    <!-- Start Contact Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row cs_gap_y_30 align-items-center">
                <div class="col-lg-6">
                    <div class="cs_contact_desc">
                        <ul class="cs_contact_info_list cs_mp_0">
                            <li>
                                <div class="cs_iconbox cs_style_6">
                                    <span class="cs_iconbox_icon cs_center cs_radius_100 position-relative">
                    <img src="{{ asset('landing/assets/img/icons/call.svg') }}" alt="Telephone icon">
                    </span>
                                    <div class="cs_iconbox_info">
                                        <p class="cs_white_color cs_heading_font cs_mb_4">Call Us 7/24</p>
                                        <a href="tel:+2085550112" aria-label="Phone call button" class="cs_fs_24 cs_bold cs_white_color cs_heading_font">+208-555-0112</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="cs_iconbox cs_style_6">
                                    <span class="cs_iconbox_icon cs_center cs_radius_100 position-relative">
                    <img src="{{ asset('landing/assets/img/icons/email.svg') }}" alt="Email icon">
                    </span>
                                    <div class="cs_iconbox_info">
                                        <p class="cs_white_color cs_heading_font cs_mb_4">Make a Quote</p>
                                        <a href="mailto:Infotek@gmail.com" aria-label="Phone call button" class="cs_fs_24 cs_bold cs_white_color cs_heading_font">Infotek@gmail.com</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="cs_iconbox cs_style_6">
                                    <span class="cs_iconbox_icon cs_center cs_radius_100 position-relative">
                    <img src="{{ asset('landing/assets/img/icons/location.svg') }}" alt="Location icon">
                    </span>
                                    <div class="cs_iconbox_info">
                                        <p class="cs_white_color cs_heading_font cs_mb_4">Location</p>
                                        <p class="cs_fs_24 cs_bold cs_white_color cs_heading_font mb-0">4517 Washington ave.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <a href="https://www.youtube.com/embed/HC-tgFdIcB0" aria-label="Click to play video" class="cs_video cs_style_1 cs_center cs_video_open cs_bg_filed position-relative" data-src="{{ asset('landing/assets/img/contact-img-1.jpg') }}">
              <span class="cs_player_btn cs_style_1 cs_center cs_radius_100 cs_white_bg cs_theme_color_3 position-relative"><i class="fa-solid fa-play"></i>
              </span>
              </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cs_contact_form_wrapper">
                        <h2 class="cs_fs_36 cs_semibold cs_mb_21">Ready to Get Started?</h2>
                        <p class="cs_mb_26">Nullam varius, erat quis iaculis dictum, eros urna varius eros, ut blandit felis odio in turpis. Quisque rhoncus, eros in auctor ultrices,</p>
                        <form action="https://api.web3forms.com/submit" method="POST" class="cs_contact_form row cs_gap_y_20" id="cs_form">
                            <input type="hidden" name="access_key" value="YOUR_ACCESS_KEY_HERE">
                            <div class="col-sm-6">
                                <label for="name">Your Name*</label>
                                <input type="text" name="name" id="name" placeholder="Your Name" class="cs_form_field cs_radius_8">
                            </div>
                            <div class="col-sm-6">
                                <label for="email">Your Email*</label>
                                <input type="email" name="email" id="email" placeholder="Email Address" class="cs_form_field cs_radius_8">
                            </div>
                            <div class="col-sm-12">
                                <label for="message">Message*</label>
                                <textarea name="comment" rows="6" id="message" placeholder="Write Message" class="cs_form_field cs_radius_8"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" aria-label="Submit button" class="cs_btn cs_style_1 cs_bg_1 cs_semibold cs_white_color text-capitalize">
                  <span>Send Message</span>
                  <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                  </button>
                                <div id="cs_result" class="cs_result"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <div class="cs_location_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158857.8398865339!2d-0.2664029591612951!3d51.52873980508483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C%20UK!5e0!3m2!1sen!2sbd!4v1745143522273!5m2!1sen!2sbd"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!-- End Contact Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection