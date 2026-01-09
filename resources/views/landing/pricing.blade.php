@extends('landing.layout')

@section('page-title', 'Pricing')
@section('meta-description', 'Choose the perfect Propilor plan for your property management needs. Flexible pricing options for property managers, landlords, and real estate professionals. Start with a free trial and scale as you grow.')
@section('meta-keywords', 'property management pricing, tenant management pricing, property software cost, property CRM pricing, rental management software pricing')
@section('og-title', 'Pricing - Propilor')

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">Our Pricing</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item active">Pricing</li>
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
    <!-- Start Pricing Section -->
    <section class="position-relative">
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="cs_section_heading cs_style_1 cs_center_column cs_mb_60 text-center">
                <div class="cs_section_subtitle cs_fs_18 cs_heading_color cs_mb_22">
                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                    <span>Our Pricing</span>
                    <img src="{{ asset('landing/assets/img/icons/star-1.svg') }}" alt="Star icon">
                </div>
                <h2 class="cs_section_title cs_fs_48 cs_semibold cs_mb_20 text-capitalize">Starter Plan For Everyone</h2>
                <p class="mb-0">All the generators on the Internet tend to repeat predefined chunks as necessary, making this <br> the first true generator on the Internet.</p>
            </div>
            <div class="cs_center cs_mb_60">
                <ul class="cs_pricing_control cs_type_1 cs_center cs_mp_0 cs_fs_14 cs_heading_color cs_bold text-uppercase position-relative">
                    <li class="">
                        <a href="yearly" aria-label="Pricing toggle button">Bill Annually</a>
                        <div class="cs_offer_info cs_theme_color_4 cs_heading_font cs_normal position-absolute">
                            @php
                                $maxDiscount = isset($subscriptions) && $subscriptions->count() > 0 ? $subscriptions->max('yearly_discount') : 20;
                                $maxDiscount = $maxDiscount ?? 20;
                            @endphp
                            <span>Save {{ $maxDiscount }}%</span>
                        </div>
                                </li>
                    <li class="active">
                        <a href="monthly" aria-label="Pricing toggle button">Bill Monthly</a>
                                </li>
                            </ul>
                        </div>
            <div class="row cs_row_gap_30 cs_gap_y_30 align-items-end">
                @if(isset($subscriptions) && $subscriptions->count() > 0)
                    @foreach($subscriptions as $subscription)
                        @php
                            $isMostPopular = $subscription->most_popular == 1;
                            $iconMap = [
                                0 => 'free.svg',
                                1 => 'dimond.svg',
                                2 => 'crown.svg'
                            ];
                            $iconIndex = min($loop->index, 2);
                        @endphp
                <div class="col-lg-4">
                            <div class="cs_pricing_table cs_style_1 cs_gray_bg_2 cs_radius_30 {{ $isMostPopular ? 'position-relative cs_active' : '' }}">
                                @if($isMostPopular)
                        <div class="cs_pricing_table_shape position-absolute">
                            <img src="{{ asset('landing/assets/img/pricing-shape-1.svg') }}" alt="Shape">
                        </div>
                        <div class="cs_pricing_badge cs_accent_bg cs_medium cs_white_color text-center position-absolute">Most Popular</div>
                                @endif
                        <div class="cs_pricing_table_heading cs_mb_3">
                                    <h2 class="cs_plan_title cs_fs_24 cs_semibold mb-0">{{ $subscription->title }}</h2>
                            <span class="cs_plan_icon">
                                        <img src="{{ asset('landing/assets/img/icons/' . $iconMap[$iconIndex]) }}" alt="Pricing plan icon">
                </span>
                        </div>
                        <div class="cs_pricing_info cs_mb_20">
                                    <div class="cs_price cs_fs_48 cs_semibold cs_heading_color cs_heading_font cs_mb_4">
                                        @if($subscription->package_amount == 0)
                                            <span>Free</span>
                                        @else
                                            @php
                                                $yearlyDiscount = $subscription->yearly_discount ?? 20; // Default 20% if not set
                                                $discountMultiplier = (100 - $yearlyDiscount) / 100;
                                                
                                                if ($subscription->interval == 'Monthly') {
                                                    $monthlyPrice = $subscription->package_amount;
                                                    $yearlyPrice = round($monthlyPrice * 12 * $discountMultiplier, 0);
                                                } elseif ($subscription->interval == 'Yearly') {
                                                    $yearlyPrice = $subscription->package_amount;
                                                    $monthlyPrice = round($yearlyPrice / 12, 0);
                                                } else {
                                                    // For Quarterly, Unlimited, etc., use package_amount as monthly
                                                    $monthlyPrice = $subscription->package_amount;
                                                    $yearlyPrice = round($monthlyPrice * 12 * $discountMultiplier, 0);
                                                }
                                            @endphp
                                            <span class="monthlyPrice">${{ number_format($monthlyPrice, 0) }}</span>
                                            <span class="yearlyPrice">${{ number_format(round($yearlyPrice / 12, 0), 0) }}</span>
                                        @endif
                                        <small>Per User/Month</small>
                        </div>
                                    <p class="mb-0">{{ $subscription->description ?: 'Get essential features to kickstart your journey to success' }}</p>
                        </div>
                        <div class="cs_separator cs_mb_22"></div>
                        <div class="cs_feature_wrapper cs_mb_30">
                            <ul class="cs_pricing_feature_list cs_mp_0">
                                <li>
                                    <span class="cs_feature_icon cs_green_color">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $isMostPopular ? 'cs_heading_color' : '' }}">Access to all basic features</span>
                                </li>
                                <li>
                                            <span class="cs_feature_icon {{ $subscription->email_notification ? 'cs_green_color' : '' }}">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    @if($subscription->email_notification)
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                                                    @else
                                                        <path d="M1 1L7 7L13 1L14 2L8 8L14 14L13 15L7 9L1 15L0 14L6 8L0 2L1 1Z" fill="currentColor"/>
                                                    @endif
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $subscription->email_notification && $isMostPopular ? 'cs_heading_color' : '' }}">Email Notification</span>
                                </li>
                                <li>
                                            <span class="cs_feature_icon {{ $subscription->subdomain ? 'cs_green_color' : '' }}">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    @if($subscription->subdomain)
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                                                    @else
                                                        <path d="M1 1L7 7L13 1L14 2L8 8L14 14L13 15L7 9L1 15L0 14L6 8L0 2L1 1Z" fill="currentColor"/>
                                                    @endif
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $subscription->subdomain && $isMostPopular ? 'cs_heading_color' : '' }}">Subdomain</span>
                                </li>
                                <li>
                                            <span class="cs_feature_icon {{ $subscription->custom_domain ? 'cs_green_color' : '' }}">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    @if($subscription->custom_domain)
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                                                    @else
                                                        <path d="M1 1L7 7L13 1L14 2L8 8L14 14L13 15L7 9L1 15L0 14L6 8L0 2L1 1Z" fill="currentColor"/>
                                                    @endif
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $subscription->custom_domain && $isMostPopular ? 'cs_heading_color' : '' }}">Add Custom Domain</span>
                                </li>
                                <li>
                                    <span class="cs_feature_icon cs_green_color">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $isMostPopular ? 'cs_heading_color' : '' }}">Up to {{ $subscription->user_limit }} users</span>
                                </li>
                                <li>
                                    <span class="cs_feature_icon cs_green_color">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $isMostPopular ? 'cs_heading_color' : '' }}">Up to {{ $subscription->property_limit }} properties</span>
                                </li>
                                <li>
                                    <span class="cs_feature_icon cs_green_color">
                      <svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.2442 0.289465L5.02298 7.10457L2.68046 4.6782C1.1639 3.21126 -0.947636 5.40321 0.466273 6.97165L3.86805 10.4952C3.89139 10.5194 3.93805 10.5701 3.96372 10.5919C4.57501 11.1719 5.52228 11.1284 6.08225 10.4952L13.7211 1.81682C14.5914 0.787306 13.2358 -0.611965 12.2465 0.289465H12.2442Z" fill="currentColor"/>
                      </svg>
                    </span>
                                            <span class="cs_feature_title {{ $isMostPopular ? 'cs_heading_color' : '' }}">Up to {{ $subscription->tenant_limit }} tenants</span>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('landing.contact') }}" aria-label="Buy service button" class="cs_btn cs_style_1 cs_fs_14 cs_bold cs_heading_color text-uppercase">
              <span>Get Started</span>
              <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
              </a>
                    </div>
                </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>No pricing plans available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Pricing Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    @endsection