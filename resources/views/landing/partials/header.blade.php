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
                                <a href="{{ route('landing.services') }}" style="color: #ffffff !important;">Features</a>

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

                                            <a href="{{ route('landing.service.rental-applications') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="file-check"></i>
                                                </div>
                                                <div>
                                                    <h5>Rental Applications</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.rent-reporting') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="trending-up"></i>
                                                </div>
                                                <div>
                                                    <h5>Rent Reporting</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.listing-website') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="globe"></i>
                                                </div>
                                                <div>
                                                    <h5>Listing Website</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.custom-domain') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="link"></i>
                                                </div>
                                                <div>
                                                    <h5>Custom Domain</h5>
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

                                            <a href="{{ route('landing.service.lead-tracking') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="target"></i>
                                                </div>
                                                <div>
                                                    <h5>Lead Tracking</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.listing-syndication') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="share-2"></i>
                                                </div>
                                                <div>
                                                    <h5>Automatic Listing Syndication</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.team-management') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="users-round"></i>
                                                </div>
                                                <div>
                                                    <h5>Team Management</h5>
                                                </div>
                                            </a>

                                            <a href="{{ route('landing.service.email-alerts') }}" class="mega-item">
                                                <div class="icon-wrap">
                                                    <i data-lucide="bell"></i>
                                                </div>
                                                <div>
                                                    <h5>Email Alerts</h5>
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
                                    gap: 6px;
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
                                    gap: 12px;
                                    padding: 10px;
                                    border-radius: 12px;
                                    text-decoration: none;
                                    transition: all .2s ease;
                                }

                                .mega-item:hover {
                                    background: #f1f5f9;
                                    transform: translateY(-1px);
                                }

                                /* ICON */
                                .icon-wrap {
                                    width: 36px;
                                    height: 36px;
                                    border-radius: 10px;
                                    background: #1e293b;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                }

                                .icon-wrap i,
                                .icon-wrap svg {
                                    width: 18px;
                                    height: 18px;
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

                                /* Mobile Styles */
                                @media screen and (max-width: 1199px) {
                                    .mega-menu {
                                        position: relative;
                                    }
                                    
                                    /* Features menu item styling on mobile */
                                    .mega-menu > a {
                                        color: #ffffff !important;
                                    }
                                    
                                    .cs_nav_list.cs_active .mega-menu > a {
                                        color: #ffffff !important;
                                    }

                                    /* Hide mega dropdown on mobile initially */
                                    .mega-menu .mega-dropdown {
                                        position: static !important;
                                        width: 100% !important;
                                        transform: none !important;
                                        opacity: 1 !important;
                                        visibility: visible !important;
                                        background: #000000 !important;
                                        border-radius: 0;
                                        padding: 0;
                                        box-shadow: none;
                                        margin-top: 0;
                                        margin-left: 0;
                                        margin-right: 0;
                                        display: none;
                                        max-height: none;
                                        overflow: visible;
                                        z-index: 1;
                                    }

                                    /* Show when parent is active */
                                    .mega-menu.active .mega-dropdown,
                                    .mega-menu .mega-dropdown.cs_active {
                                        display: block !important;
                                        position: static !important;
                                    }
                                    
                                    /* Ensure it stays visible when menu is open */
                                    .cs_nav_list.cs_active .mega-menu.active .mega-dropdown {
                                        display: block !important;
                                        position: static !important;
                                    }

                                    /* Make dropdown toggle work with mega dropdown */
                                    .mega-menu .cs_menu_dropdown_toggle {
                                        display: flex !important;
                                    }

                                    .mega-menu.active .cs_menu_dropdown_toggle {
                                        display: flex !important;
                                    }

                                    /* Prevent hover effects on mobile */
                                    .mega-menu:hover .mega-dropdown {
                                        display: none;
                                    }

                                    .mega-menu.active .mega-dropdown,
                                    .mega-menu.active:hover .mega-dropdown {
                                        display: block !important;
                                    }

                                    .mega-grid {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 0;
                                        width: 100%;
                                    }

                                    .mega-column {
                                        gap: 0;
                                        padding: 0;
                                        background: transparent;
                                        width: 100%;
                                    }

                                    .mega-column.highlight {
                                        background: transparent;
                                        padding: 0;
                                    }

                                    .mega-title {
                                        font-size: 11px;
                                        color: #ffffff !important;
                                        padding: 14px 20px;
                                        margin: 0;
                                        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                                        background: rgba(255, 255, 255, 0.08);
                                        font-weight: 600;
                                        text-transform: uppercase;
                                        letter-spacing: 0.5px;
                                    }

                                    .mega-item {
                                        display: flex !important;
                                        flex-direction: row !important;
                                        align-items: center !important;
                                        flex-wrap: nowrap !important;
                                        gap: 12px;
                                        padding: 14px 20px;
                                        border-radius: 0;
                                        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                                        color: #ffffff !important;
                                        background: transparent;
                                        width: 100%;
                                        text-decoration: none;
                                    }
                                    
                                    /* Ensure icon and text are side by side horizontally */
                                    .mega-item .icon-wrap {
                                        flex-shrink: 0 !important;
                                        flex-grow: 0 !important;
                                        width: 32px !important;
                                        height: 32px !important;
                                        display: flex !important;
                                        align-items: center !important;
                                        justify-content: center !important;
                                    }
                                    
                                    .mega-item > div:not(.icon-wrap) {
                                        flex: 1 1 auto !important;
                                        display: flex !important;
                                        align-items: center !important;
                                    }
                                    
                                    .mega-item h5 {
                                        margin: 0 !important;
                                        display: block !important;
                                        white-space: nowrap !important;
                                    }

                                    .mega-item:hover,
                                    .mega-item:focus,
                                    .mega-item:active {
                                        background: rgba(255, 255, 255, 0.12) !important;
                                        transform: none;
                                        color: #ffffff !important;
                                    }

                                    .mega-item h5 {
                                        color: #ffffff !important;
                                        font-size: 14px;
                                        font-weight: 500;
                                        margin: 0;
                                    }

                                    .icon-wrap {
                                        width: 32px;
                                        height: 32px;
                                        background: rgba(255, 255, 255, 0.2) !important;
                                        border-radius: 8px;
                                        flex-shrink: 0;
                                    }

                                    .icon-wrap i,
                                    .icon-wrap svg {
                                        width: 16px;
                                        height: 16px;
                                        color: #ffffff !important;
                                        stroke: #ffffff !important;
                                        fill: none;
                                    }

                                    .mega-cta {
                                        margin: 0;
                                        padding: 15px 20px;
                                        border-radius: 0;
                                        background: rgba(59, 130, 246, 0.25);
                                        color: #93c5fd !important;
                                        border-top: 1px solid rgba(255, 255, 255, 0.15);
                                        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                                        display: block;
                                        text-align: left;
                                        font-weight: 600;
                                    }

                                    .mega-cta:hover {
                                        background: rgba(59, 130, 246, 0.35) !important;
                                        color: #bfdbfe !important;
                                    }
                                    
                                    /* Ensure all links are white */
                                    .mega-dropdown a {
                                        color: #ffffff !important;
                                    }
                                    
                                    .mega-dropdown a:hover,
                                    .mega-dropdown a:focus,
                                    .mega-dropdown a:active {
                                        color: #ffffff !important;
                                    }
                                    
                                    /* Prevent any white background from showing */
                                    .mega-dropdown * {
                                        box-sizing: border-box;
                                    }
                                    
                                    /* Ensure menu can scroll without closing */
                                    .cs_nav_list.cs_active {
                                        overflow-y: auto !important;
                                        overflow-x: hidden !important;
                                        -webkit-overflow-scrolling: touch;
                                        touch-action: pan-y;
                                        position: fixed !important;
                                        z-index: 9999;
                                        height: 100vh !important;
                                        max-height: 100vh !important;
                                        top: 0 !important;
                                        left: 0 !important;
                                        width: 100vw !important;
                                    }
                                    
                                    /* Make sure menu content can scroll */
                                    .cs_nav_list.cs_active ul {
                                        height: auto !important;
                                        overflow: visible !important;
                                    }
                                    
                                    /* Prevent menu from closing on touch/scroll */
                                    .cs_nav_list.cs_active .mega-menu.active .mega-dropdown {
                                        pointer-events: auto;
                                        touch-action: pan-y;
                                    }
                                    
                                    /* Ensure menu toggle (close icon) is visible - keep original positioning */
                                    .cs_menu_toggle {
                                        display: inline-block !important;
                                        z-index: 10001 !important;
                                        cursor: pointer !important;
                                        background: transparent !important;
                                        /* Don't override position - use original from SCSS */
                                    }
                                    
                                    .cs_menu_toggle.cs_toggle_active {
                                        display: inline-block !important;
                                        z-index: 10001 !important;
                                    }
                                    
                                    /* Ensure toggle spans are visible */
                                    .cs_menu_toggle span,
                                    .cs_menu_toggle.cs_toggle_active span {
                                        display: block !important;
                                        visibility: visible !important;
                                    }
                                    
                                    /* Prevent body scroll when menu is open */
                                    body.menu-open {
                                        overflow: hidden !important;
                                        position: fixed !important;
                                        width: 100% !important;
                                        height: 100% !important;
                                    }
                                }

                            </style>
                            @push('scripts')
                            <script>
                                // Ensure mega dropdown stays visible when scrolling and handle active state
                                jQuery(document).ready(function($) {
                                    // Store original body styles
                                    var originalBodyStyles = {
                                        overflow: $('body').css('overflow'),
                                        position: $('body').css('position'),
                                        width: $('body').css('width'),
                                        height: $('body').css('height')
                                    };
                                    
                                    // Close other mega menus when one opens
                                    $(document).on('click', '.mega-menu .cs_menu_dropdown_toggle', function() {
                                        var $clickedMenu = $(this).closest('.mega-menu');
                                        
                                        // Close other open mega menus
                                        $('.mega-menu').not($clickedMenu).each(function() {
                                            if ($(this).hasClass('active')) {
                                                $(this).removeClass('active');
                                                $(this).find('.mega-dropdown').slideUp(300);
                                                $(this).find('.cs_menu_dropdown_toggle').removeClass('active');
                                            }
                                        });
                                    });
                                    
                                    // Prevent background scrolling when menu is open
                                    var $navList = $('.cs_nav_list');
                                    var $body = $('body');
                                    var scrollPosition = 0;
                                    
                                    // Handle scroll within the menu only
                                    $navList.on('scroll touchmove', function(e) {
                                        // Ensure mega dropdown stays visible
                                        if ($(this).hasClass('cs_active')) {
                                            $('.mega-menu.active .mega-dropdown').css({
                                                'display': 'block',
                                                'position': 'static',
                                                'visibility': 'visible',
                                                'opacity': '1'
                                            });
                                        }
                                        
                                        // Allow scrolling within menu
                                        e.stopPropagation();
                                        return true;
                                    });
                                    
                                    // Prevent window/body scroll when menu is open (but allow menu scroll)
                                    $(window).on('scroll', function(e) {
                                        if ($('.cs_nav_list').hasClass('cs_active')) {
                                            // Prevent scrolling the background
                                            window.scrollTo(0, scrollPosition);
                                            return false;
                                        }
                                    });
                                    
                                    // Prevent touchmove on body but allow on menu
                                    $(document).on('touchmove', function(e) {
                                        if ($('.cs_nav_list').hasClass('cs_active')) {
                                            // Allow scrolling within menu
                                            if ($(e.target).closest('.cs_nav_list').length || 
                                                $(e.target).closest('.mega-dropdown').length) {
                                                return true;
                                            }
                                            // Prevent scrolling on body
                                            e.preventDefault();
                                            return false;
                                        }
                                    });
                                    
                                    // Ensure menu is scrollable - allow touch events
                                    $navList.on('touchstart touchmove', function(e) {
                                        if ($(this).hasClass('cs_active')) {
                                            // Allow touch events within menu for scrolling
                                            e.stopPropagation();
                                        }
                                    });
                                    
                                    // Ensure menu is scrollable
                                    $navList.on('touchstart', function(e) {
                                        if ($(this).hasClass('cs_active')) {
                                            // Allow touch events within menu
                                            e.stopPropagation();
                                        }
                                    });
                                    
                                    // Lock body scroll when menu opens, unlock when closes
                                    var navList = document.querySelector('.cs_nav_list');
                                    if (navList) {
                                        var observer = new MutationObserver(function(mutations) {
                                            mutations.forEach(function(mutation) {
                                                if (mutation.attributeName === 'class') {
                                                    var $navList = $('.cs_nav_list');
                                                    
                                                    if ($navList.hasClass('cs_active')) {
                                                        // Menu opened - lock body scroll
                                                        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                                                        $body.addClass('menu-open').css({
                                                            'overflow': 'hidden',
                                                            'position': 'fixed',
                                                            'top': '-' + scrollPosition + 'px',
                                                            'width': '100%',
                                                            'height': '100%'
                                                        });
                                                    } else {
                                                        // Menu closed - unlock body scroll
                                                        var top = parseInt($body.css('top'), 10);
                                                        $body.removeClass('menu-open').css({
                                                            'overflow': originalBodyStyles.overflow,
                                                            'position': originalBodyStyles.position,
                                                            'top': '',
                                                            'width': originalBodyStyles.width,
                                                            'height': originalBodyStyles.height
                                                        });
                                                        
                                                        // Restore scroll position
                                                        if (top) {
                                                            window.scrollTo(0, Math.abs(top));
                                                        }
                                                        
                                                        // Close all mega menus
                                                        $('.mega-menu').removeClass('active');
                                                        $('.mega-dropdown').slideUp(0);
                                                        $('.mega-menu .cs_menu_dropdown_toggle').removeClass('active');
                                                    }
                                                }
                                            });
                                        });
                                        observer.observe(navList, { attributes: true, attributeFilter: ['class'] });
                                    }
                                    
                                    // Also handle menu toggle clicks to ensure body lock
                                    $(document).on('click', '.cs_menu_toggle', function() {
                                        setTimeout(function() {
                                            if ($('.cs_nav_list').hasClass('cs_active')) {
                                                scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                                                $body.addClass('menu-open').css({
                                                    'overflow': 'hidden',
                                                    'position': 'fixed',
                                                    'top': '-' + scrollPosition + 'px',
                                                    'width': '100%',
                                                    'height': '100%'
                                                });
                                            } else {
                                                var top = parseInt($body.css('top'), 10);
                                                $body.removeClass('menu-open').css({
                                                    'overflow': originalBodyStyles.overflow,
                                                    'position': originalBodyStyles.position,
                                                    'top': '',
                                                    'width': originalBodyStyles.width,
                                                    'height': originalBodyStyles.height
                                                });
                                                if (top) {
                                                    window.scrollTo(0, Math.abs(top));
                                                }
                                            }
                                        }, 10);
                                    });
                                    
                                    // Prevent touch events on body when menu is open
                                    $(document).on('touchmove', function(e) {
                                        if ($('.cs_nav_list').hasClass('cs_active')) {
                                            // Allow scrolling within menu
                                            if ($(e.target).closest('.cs_nav_list').length) {
                                                return true;
                                            }
                                            // Prevent scrolling on body
                                            e.preventDefault();
                                            return false;
                                        }
                                    });
                                });
                            </script>
                            @endpush
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

