@php
    $routeName = \Request::route()->getName();
    // Check Section 9 for logo first, then fall back to settings
    $logoUrl1 = asset('logo.png'); // Default fallback
    $section9 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 9')->first();
    
    if ($section9 && !empty($section9->content_value)) {
        $section9_content = json_decode($section9->content_value, true);
        $logo_path = !empty($section9_content['logo_path']) ? $section9_content['logo_path'] : '';
        
        if (!empty($logo_path)) {
            $logoUrl1 = fetch_file(basename($logo_path), 'upload/logo/');
            if (empty($logoUrl1)) {
                $admin_logo = getSettingsValByName('company_logo');
                $logoUrl1 = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
            }
        } else {
            $admin_logo = getSettingsValByName('company_logo');
            $logoUrl1 = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
        }
    } else {
        $admin_logo = getSettingsValByName('company_logo');
        $logoUrl1 = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
    }
    
    if (empty($logoUrl1)) {
        $logoUrl1 = asset('logo.png');
    }
    
    $appName = !empty($settings['app_name']) ? $settings['app_name'] : 'Rentex';
    
    $Section_0 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 0')->first();
    $Section_0_content_value = !empty($Section_0->content_value) ? json_decode($Section_0->content_value, true) : [];
@endphp

<header class="lg:tw-px-4 tw-max-w-[100vw] tw-max-w-lg:tw-mr-auto max-lg:tw-top-0 tw-fixed tw-top-4 lg:tw-left-1/2 lg:tw--translate-x-1/2 tw-z-20 tw-flex tw-h-[60px] tw-w-full 
                tw-text-gray-700 tw-bg-[#f2f3f4] dark:tw-text-gray-200 dark:tw-bg-[#080808] tw-px-[3%] tw-rounded-md lg:tw-max-w-5xl tw-shadow-md dark:tw-shadow-gray-700
                lg:tw-justify-around lg:!tw-backdrop-blur-lg lg:tw-opacity-[0.99]">
    <a class="tw-flex tw-p-[4px] tw-gap-2 tw-place-items-center" href="{{ route('web.page', $user->code) }}">
        <div class="tw-h-[30px] tw-max-w-[100px]">
            <img src="{{ $logoUrl1 }}" alt="logo" class="tw-object-contain tw-h-full tw-w-full dark:tw-invert" onerror="this.style.display='none';">
        </div>
        <span class="tw-uppercase tw-text-base tw-font-medium">{{ $appName }}</span>
    </a>
    <div class="collapsible-header animated-collapse max-lg:tw-shadow-md" id="collapsed-header-items">
        <nav class="tw-relative tw-flex tw-h-full max-lg:tw-h-max tw-w-max tw-gap-5 tw-text-base max-lg:tw-mt-[30px] max-lg:tw-flex-col 
                        max-lg:tw-gap-5 lg:tw-mx-auto tw-place-items-center">
            <a class="header-links" href="{{ route('web.page', $user->code) }}">{{ __('Home') }}</a>
            <a class="header-links" href="{{ route('property.home', ['code' => $user->code]) }}">{{ __('Properties') }}</a>
            <a class="header-links" href="{{ route('blog.home', ['code' => $user->code]) }}">{{ __('Blog') }}</a>
            <a class="header-links" href="{{ route('contact.home', ['code' => $user->code]) }}">{{ __('Contact') }}</a>
        </nav>
        <div class="lg:tw-mx-4 tw-flex tw-place-items-center tw-gap-[20px] tw-text-base max-md:tw-w-full 
                        max-md:tw-flex-col max-md:tw-place-content-center">
            <button type="button" onclick="toggleMode()" class="header-links tw-text-gray-600 dark:tw-text-gray-300"
                title="toggle-theme" id="theme-toggle">
                <i class="bi bi-sun" id="toggle-mode-icon"></i>
            </button>
            <a href="{{ !empty($Section_0_content_value['btn_link']) ? $Section_0_content_value['btn_link'] : route('property.home', ['code' => $user->code]) }}" 
               aria-label="{{ !empty($Section_0_content_value['btn_name']) ? $Section_0_content_value['btn_name'] : __('Explore') }}" 
               class="btn tw-flex tw-gap-3 tw-px-3 tw-py-2 tw-transition-transform tw-duration-[0.3s] hover:tw-translate-x-2">
                <span>{{ !empty($Section_0_content_value['btn_name']) ? $Section_0_content_value['btn_name'] : __('Explore') }}</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <button class="bi bi-list tw-absolute tw-right-3 tw-top-3 tw-z-50 tw-text-3xl tw-text-gray-500 lg:tw-hidden"
        onclick="toggleHeader()" aria-label="menu" id="collapse-btn"></button>
</header>

<script>
    // Header toggle functionality (from new theme)
    const RESPONSIVE_WIDTH = 1024;
    let isHeaderCollapsed = window.innerWidth < RESPONSIVE_WIDTH;
    const collapseBtn = document.getElementById("collapse-btn");
    const collapseHeaderItems = document.getElementById("collapsed-header-items");
    
    function onHeaderClickOutside(e) {
        if (!collapseHeaderItems.contains(e.target) && !collapseBtn.contains(e.target)) {
            toggleHeader();
        }
    }
    
    function toggleHeader() {
        if (isHeaderCollapsed) {
            collapseHeaderItems.classList.add("max-lg:!tw-opacity-100", "tw-min-h-[90vh]");
            collapseHeaderItems.style.height = "90vh";
            collapseBtn.classList.remove("bi-list");
            collapseBtn.classList.add("bi-x", "max-lg:tw-fixed");
            isHeaderCollapsed = false;
            document.body.classList.add("modal-open");
            setTimeout(() => window.addEventListener("click", onHeaderClickOutside), 1);
        } else {
            collapseHeaderItems.classList.remove("max-lg:!tw-opacity-100", "tw-min-h-[90vh]");
            collapseHeaderItems.style.height = "0vh";
            collapseBtn.classList.remove("bi-x", "max-lg:tw-fixed");
            collapseBtn.classList.add("bi-list");
            document.body.classList.remove("modal-open");
            isHeaderCollapsed = true;
            window.removeEventListener("click", onHeaderClickOutside);
        }
    }
    
    // Theme toggle functionality
    function updateFavicon() {
        const favicon = document.getElementById("favicon");
        if (!favicon) return;
        const isDark = document.documentElement.classList.contains("tw-dark");
        favicon.href = isDark ? "./assets/logo/logo-dark.png" : "./assets/logo/logo-light.png";
    }
    
    if (localStorage.getItem('color-mode') === 'dark' || (!('color-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('tw-dark');
        updateToggleModeBtn();
        updateFavicon();
    } else {
        document.documentElement.classList.remove('tw-dark');
        updateToggleModeBtn();
        updateFavicon();
    }
    
    function toggleMode() {
        document.documentElement.classList.toggle("tw-dark");
        updateToggleModeBtn();
        updateFavicon();
    }
    
    function updateToggleModeBtn() {
        const toggleIcon = document.querySelector("#toggle-mode-icon");
        if (document.documentElement.classList.contains("tw-dark")) {
            toggleIcon.classList.remove("bi-sun");
            toggleIcon.classList.add("bi-moon");
            localStorage.setItem("color-mode", "dark");
        } else {
            toggleIcon.classList.add("bi-sun");
            toggleIcon.classList.remove("bi-moon");
            localStorage.setItem("color-mode", "light");
        }
    }
    
    // Responsive handling
    function responsive() {
        if (!isHeaderCollapsed) {
            toggleHeader();
        }
        if (window.innerWidth > RESPONSIVE_WIDTH) {
            collapseHeaderItems.style.height = "";
        } else {
            isHeaderCollapsed = true;
        }
    }
    
    responsive();
    window.addEventListener("resize", responsive);
</script>
