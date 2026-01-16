@php
    $settings = settings();
    $admin_logo = getSettingsValByName('company_logo');
    $logo = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('landing/assets/img/logo_white.png');
    // Final fallback if fetch_file returns empty
    if (empty($logo) || $logo == asset('landing/assets/img/logo_white.png')) {
        $logo = asset('landing/assets/img/logo_white.png');
    }
@endphp
<!-- Start Header Section -->
<header class="cs_site_header cs_style_1 cs_type_2 cs_sticky_header cs_white_color cs_heading_font">
    <div class="cs_main_header">
        <div class="container">
            <div class="cs_main_header_in">
                <div class="cs_main_header_left">
                    <a class="cs_site_branding" href="{{ url('/') }}" aria-label="Home page link">
                        <img src="{{ asset('landing/assets/img/logo_white.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="cs_main_header_center">
                    <div class="cs_nav">
                        <ul class="cs_nav_list">
                            <li><a href="{{ url('/') }}" aria-label="Menu link">Home</a></li>
                            <li class="menu-item-has-children mega-menu">
                                <a href="{{ route('landing.services') }}">Services</a>

                                <div class="mega-dropdown">
                                    <div class="mega-grid">

                                        <!-- COLUMN -->
                                        <div class="mega-column">
                                            <p class="mega-title">Property & Tenants</p>

                                            <a href="{{ route('landing.service.property-automation') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="building-2"></i>
                                                </div>
                                                <div>
                                                    <h5>Property Automation</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.tenant-management') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="users"></i>
                                                </div>
                                                <div>
                                                    <h5>Tenant Management</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.lease-contract') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="file-text"></i>
                                                </div>
                                                <div>
                                                    <h5>Lease & Contracts</h5>
                                                </div>
                                            </a>
                                        </div>

                                        <!-- COLUMN -->
                                        <div class="mega-column">
                                            <p class="mega-title">Finance & Reports</p>

                                            <a href="{{ route('landing.service.rent-billing') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="credit-card"></i>
                                                </div>
                                                <div>
                                                    <h5>Rent & Billing</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.visibility-reports') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="bar-chart-3"></i>
                                                </div>
                                                <div>
                                                    <h5>Reports & Insights</h5>
                                                </div>
                                            </a>
                                        </div>

                                        <!-- COLUMN -->
                                        <div class="mega-column highlight">
                                            <p class="mega-title">Operations</p>

                                            <a href="{{ route('landing.service.maintenance-tasks') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="wrench"></i>
                                                </div>
                                                <div>
                                                    <h5>Maintenance</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.services') }}" class="mega-cta">
                                                Explore All Services →
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            <style>
                                /* === MEGA MENU === */
                                .mega-menu {
                                    position: relative;
                                }

                                .mega-dropdown {
                                    position: absolute;
                                    top: 110%;
                                    left: 50%;
                                    transform: translateX(-50%) translateY(10px);
                                    width: 960px;
                                    background: #ffffff;
                                    border-radius: 20px;
                                    padding: 32px;
                                    box-shadow:
                                        0 40px 80px rgba(0,0,0,0.12),
                                        0 8px 24px rgba(0,0,0,0.06);
                                    opacity: 0;
                                    visibility: hidden;
                                    transition: all 0.25s ease;
                                    z-index: 999;
                                }

                                .mega-menu:hover .mega-dropdown {
                                    opacity: 1;
                                    visibility: visible;
                                    transform: translateX(-50%) translateY(0);
                                }

                                /* GRID */
                                .mega-grid {
                                    display: grid;
                                    grid-template-columns: 1.2fr 1.2fr 1fr;
                                    gap: 32px;
                                }

                                /* COLUMN */
                                .mega-column {
                                    display: flex;
                                    flex-direction: column;
                                    gap: 12px;
                                }

                                .mega-column.highlight {
                                    background: linear-gradient(180deg, #f8fafc, #ffffff);
                                    border-radius: 16px;
                                    padding: 20px;
                                }

                                /* TITLE */
                                .mega-title {
                                    font-size: 11px;
                                    font-weight: 600;
                                    text-transform: uppercase;
                                    letter-spacing: .08em;
                                    color: #6b7280;
                                    margin-bottom: 8px;
                                    font-family: 'Poppins', sans-serif;
                                }

                                /* ITEM */
                                .mega-item {
                                    display: flex;
                                    align-items: center;
                                    gap: 14px;
                                    padding: 14px;
                                    border-radius: 14px;
                                    text-decoration: none;
                                    transition: all .2s ease;
                                }

                                .mega-item:hover {
                                    background: #f1f5f9;
                                    transform: translateY(-1px);
                                }

                                /* ICON */
                                .icon-wrap {
                                    width: 44px;
                                    height: 44px;
                                    border-radius: 12px;
                                    background: #1e293b;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                }

                                .icon-wrap i,
                                .icon-wrap svg {
                                    width: 20px;
                                    height: 20px;
                                    color: #ffffff;
                                    stroke: #ffffff;
                                    fill: none;
                                }

                                .icon-wrap i[data-lucide] {
                                    display: inline-block;
                                }

                                /* TEXT */
                                .mega-item h5 {
                                    font-size: 14px;
                                    font-weight: 600;
                                    margin: 0;
                                    color: #0f172a;
                                    font-family: 'Poppins', sans-serif;
                                }

                                /* CTA */
                                .mega-cta {
                                    margin-top: 14px;
                                    padding: 14px;
                                    border-radius: 14px;
                                    text-align: center;
                                    font-weight: 600;
                                    font-size: 13px;
                                    color: #2563eb;
                                    background: #eff6ff;
                                    text-decoration: none;
                                    font-family: 'Poppins', sans-serif;
                                }

                                .mega-cta:hover {
                                    background: #dbeafe;
                                }

                            </style>
                            <li><a href="{{ route('landing.pricing') }}" aria-label="Menu link">Pricing</a></li>
                            <li><a href="{{ route('landing.about') }}" aria-label="Menu link">About Us</a></li>
                            <li><a href="{{ route('landing.faqs') }}" aria-label="Menu link">FAQ</a></li>
                            <li><a href="{{ route('landing.blog') }}" aria-label="Menu link">Blog</a></li>
                            <li><a href="{{ route('landing.contact') }}" aria-label="Menu link">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="cs_main_header_right">
                    <a href="{{ route('register') }}" aria-label="Get started button"
                        class="cs_btn cs_style_1 cs_theme_bg_4 cs_fs_14 cs_bold cs_heading_color text-uppercase">
                        <span>Get Started</span>
                        <span class="cs_btn_icon"><i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header Section -->

