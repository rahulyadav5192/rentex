@php
    $settings = settings();
    $admin_logo = getSettingsValByName('company_logo');
    $logo = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('landing/assets/img/logo_white.png');
    // Final fallback if fetch_file returns empty
    if (empty($logo) || $logo == asset('landing/assets/img/logo_white.png')) {
        $logo = asset('landing/assets/img/logo_white.png');
    }
    $companyAddress = !empty($settings['company_address']) ? $settings['company_address'] : '12 Division Park, SKY 12546. Berlin';
    $companyEmail = !empty($settings['company_email']) ? $settings['company_email'] : 'help@webteck-mail.com';
    $companyPhone = !empty($settings['company_phone']) ? $settings['company_phone'] : '+(215) 2536-32156';
    $companyName = !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME');
@endphp
<!-- Start Footer Section -->
<footer class="cs_footer cs_style_1 cs_type_2 cs_accent_bg cs_bg_filed" data-src="{{ asset('landing/assets/img/footer-bg-3.svg') }}">
    <div class="cs_height_130 cs_height_lg_80"></div>
    <div class="container">
        <div class="cs_footer_top position-relative">
            <ul class="cs_location_list cs_mp_0">
                <li>
                    <span class="cs_location_icon cs_center cs_heading_color cs_radius_100">
                        <i class="fa-solid fa-location-dot"></i></span>
                    <div class="cs_location_info cs_fs_18">
                        <p class="cs_fs_14 cs_theme_color_4 mb-0">ADDRESS</p>
                        <p class="cs_white_color mb-0">{!! nl2br(e($companyAddress)) !!}</p>
                    </div>
                </li>
                <li>
                    <span class="cs_location_icon cs_center cs_heading_color cs_radius_100">
                        <i class="fa-solid fa-envelope"></i></span>
                    <div class="cs_location_info cs_fs_18">
                        <p class="cs_fs_14 cs_theme_color_4 mb-0">EMAIL</p>
                        <a href="mailto:{{ $companyEmail }}" aria-label="Send mail link">{{ $companyEmail }}</a>
                    </div>
                </li>
                <li>
                    <span class="cs_location_icon cs_center cs_heading_color cs_radius_100">
                        <i class="fa-solid fa-phone"></i></span>
                    <div class="cs_location_info cs_fs_18">
                        <p class="cs_fs_14 cs_theme_color_4 mb-0">CALL</p>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $companyPhone) }}" aria-label="Make a call link">{{ $companyPhone }}</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="cs_footer_main cs_radius_30">
            <div class="cs_footer_desc">
                <div class="cs_brand">
                    <img src="{{ $logo }}" alt="Logo">
                </div>
                <div class="cs_footer_desc_text">
                    @if(!empty($settings['company_description']))
                        {{ $settings['company_description'] }}
                    @else
                        Their team's technical expertise is truly outstanding. They took the time to thoroughly understand our goals and requirements and then designed and implemented solutions that not only addressed our immediate challenges but also positioned us for future growth.
                    @endif
                </div>
            </div>
            <div class="cs_footer_header cs_radius_30">
                <ul class="cs_footer_menu cs_semibold cs_white_color cs_mp_0">
                    <li><a href="{{ url('/') }}" aria-label="Home page link">Home</a></li>
                    <li><a href="{{ route('landing.about') }}" aria-label="About page link">About Us</a></li>
                    <li><a href="{{ route('landing.services') }}" aria-label="Services page link">Services</a></li>
                    <li><a href="{{ route('landing.pricing') }}" aria-label="Pricing page link">Pricing</a></li>
                    <li><a href="{{ url('bloag') }}" aria-label="Blog page link">Blog</a></li>
                    <li><a href="{{ route('landing.contact') }}" aria-label="Contact page link">Contact Us</a></li>
                </ul>
                <div class="cs_social_links cs_style_1 cs_heading_color">
                    @if(!empty($settings['facebook_url']))
                        <a href="{{ $settings['facebook_url'] }}" target="_blank" aria-label="Social link"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if(!empty($settings['twitter_url']))
                        <a href="{{ $settings['twitter_url'] }}" target="_blank" aria-label="Social link"><i class="fa-brands fa-x-twitter"></i></a>
                    @endif
                    @if(!empty($settings['instagram_url']))
                        <a href="{{ $settings['instagram_url'] }}" target="_blank" aria-label="Social link"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if(!empty($settings['linkedin_url']))
                        <a href="{{ $settings['linkedin_url'] }}" target="_blank" aria-label="Social link"><i class="fa-brands fa-linkedin"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="cs_footer_bottom position-relative">
            <div class="cs_footer_text cs_white_color text-center">Copyright &copy; <span class="cs_getting_year"></span> {{ $companyName }} — Smart Property Operations Software</div>
        </div>
    </div>
</footer>
<!-- End Footer Section -->
<!-- Start Scroll Up Button -->
<button type="button" aria-label="Scroll to top button"
    class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z"
            fill="currentColor" />
    </svg>
</button>
<!-- End Scroll Up Button -->

