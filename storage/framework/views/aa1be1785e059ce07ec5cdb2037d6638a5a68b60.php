<?php
    $routeName = \Request::route()->getName();
    // Check Section 9 for logo first, then fall back to settings
    $logoUrl1 = asset('logo.png'); // Default fallback
    $section9 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 9')->first();
    
    if ($section9 && !empty($section9->content_value)) {
        $section9_content = json_decode($section9->content_value, true);
        $logo_path = !empty($section9_content['logo_path']) ? $section9_content['logo_path'] : '';
        
        if (!empty($logo_path)) {
            $logoUrl1 = fetch_file(basename($logo_path), 'upload/logo/');
            // If fetch_file returns empty, fall back to settings
            if (empty($logoUrl1)) {
                $admin_logo = getSettingsValByName('company_logo');
                $logoUrl1 = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
            }
        } else {
            // No logo in Section 9, fall back to settings
            $admin_logo = getSettingsValByName('company_logo');
            $logoUrl1 = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
        }
    } else {
        // Section 9 doesn't exist, use settings
    $admin_logo = getSettingsValByName('company_logo');
        $logoUrl1 = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
    }
    
    // Final fallback
    if (empty($logoUrl1)) {
        $logoUrl1 = asset('logo.png');
    }
    
    // Get app name for branding
    $appName = !empty($settings['app_name']) ? $settings['app_name'] : 'Rentex';
    
    // Get Section 0 for button data
    $Section_0 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 0')->first();
    $Section_0_content_value = !empty($Section_0->content_value) ? json_decode($Section_0->content_value, true) : [];
?>

<nav class="fixed top-0 left-0 right-0 z-50 w-full pt-4 pb-2 sm:pt-6 sm:pb-4 px-3 sm:px-4 lg:px-8" style="position: fixed !important;">
    <div class="max-w-7xl mx-auto bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-white/40 dark:border-slate-700/50 rounded-full shadow-lg dark:shadow-slate-950/50 flex justify-between items-center px-4 sm:px-6 py-2 sm:py-3 transition-all duration-300">
        <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.location.href='<?php echo e(route('web.page', $user->code)); ?>'">
            <?php if(!empty($logoUrl1) && $logoUrl1 != asset('logo.png')): ?>
                <img src="<?php echo e($logoUrl1); ?>" alt="Logo" class="h-8 w-auto max-w-[180px] object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <?php endif; ?>
            <div class="flex items-center gap-2" style="<?php echo e(!empty($logoUrl1) && $logoUrl1 != asset('logo.png') ? 'display: none;' : ''); ?>">
                <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 44H44" stroke="currentColor" stroke-linecap="round" stroke-width="4"></path>
                    <path class="dark:stroke-white" d="M10 44V20L20 12L30 20V44" stroke="#1E293B" stroke-linejoin="round" stroke-width="4"></path>
                    <path class="dark:stroke-white" d="M30 44V26L38 20L42 23V44" stroke="#1E293B" stroke-linejoin="round" stroke-width="4"></path>
                    <path d="M20 12V4" stroke="currentColor" stroke-linecap="round" stroke-width="4"></path>
                    <rect fill="currentColor" height="8" rx="1" width="8" x="16" y="24"></rect>
                    <rect fill="currentColor" height="4" rx="0.5" width="4" x="34" y="30"></rect>
                </svg>
            </div>
        </div>
        
        <div class="hidden md:flex items-center space-x-1">
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['web.page']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('web.page', $user->code)); ?>">
                <?php echo e(__('Home')); ?>

            </a>
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['property.home','property.detail']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('property.home', ['code' => $user->code])); ?>">
                <?php echo e(__('Properties')); ?>

            </a>
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['blog.home','blog.detail']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('blog.home', ['code' => $user->code])); ?>">
                <?php echo e(__('Blog')); ?>

            </a>
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['contact.home']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('contact.home', ['code' => $user->code])); ?>">
                <?php echo e(__('Contact')); ?>

            </a>
        </div>
        
        <div class="hidden md:flex items-center gap-3">
            <button aria-label="Toggle Dark Mode" class="p-2.5 rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition-colors group" onclick="toggleTheme()">
                <span class="material-icons-round text-xl group-hover:text-slate-700 dark:hidden">dark_mode</span>
                <span class="material-icons-round text-xl hidden dark:block text-yellow-400 group-hover:text-yellow-300">light_mode</span>
            </button>
            <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 mx-1"></div>
            <?php if(!empty($Section_0_content_value['btn_name'] ?? '')): ?>
                <a class="bg-slate-900 dark:bg-slate-800 text-white dark:text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-slate-800 dark:hover:bg-slate-700 transition-all shadow-lg hover:shadow-lg transform hover:-translate-y-0.5 border border-slate-800 dark:border-slate-700" 
                   href="<?php echo e($Section_0_content_value['btn_link'] ?? '#'); ?>">
                    <?php echo e($Section_0_content_value['btn_name'] ?? __('Explore')); ?>

                </a>
            <?php else: ?>
                <a class="bg-slate-900 dark:bg-slate-800 text-white dark:text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-slate-800 dark:hover:bg-slate-700 transition-all shadow-lg hover:shadow-lg transform hover:-translate-y-0.5 border border-slate-800 dark:border-slate-700" 
                   href="<?php echo e(route('property.home', ['code' => $user->code])); ?>">
                    <?php echo e(__('Explore')); ?>

                </a>
            <?php endif; ?>
                </div>

        <div class="md:hidden flex items-center gap-3">
            <button class="p-2 rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition-colors" onclick="toggleTheme()">
                <span class="material-icons-round text-xl dark:hidden">dark_mode</span>
                <span class="material-icons-round text-xl hidden dark:block text-yellow-400">light_mode</span>
            </button>
            <button id="hamburgerBtn" class="p-2 text-black dark:text-black hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all duration-300 focus:outline-none relative w-10 h-10 flex items-center justify-center" onclick="toggleMobileMenu()">
                <span class="hamburger-icon">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </span>
            </button>
                    </div>
                </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden mt-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-white/40 dark:border-slate-700/50 rounded-2xl shadow-lg p-4 transition-all duration-300">
        <div class="flex flex-col space-y-2">
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['web.page']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('web.page', $user->code)); ?>">
                <?php echo e(__('Home')); ?>

            </a>
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['property.home','property.detail']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('property.home', ['code' => $user->code])); ?>">
                <?php echo e(__('Properties')); ?>

            </a>
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['blog.home','blog.detail']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('blog.home', ['code' => $user->code])); ?>">
                <?php echo e(__('Blog')); ?>

            </a>
            <a class="px-5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary rounded-full hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-all duration-200 <?php echo e(in_array($routeName, ['contact.home']) ? 'text-primary dark:text-primary bg-slate-100 dark:bg-slate-800/50' : ''); ?>" 
               href="<?php echo e(route('contact.home', ['code' => $user->code])); ?>">
                <?php echo e(__('Contact')); ?>

            </a>
        </div>
        </div>
    </nav>

    <style>
        /* Hamburger Menu Animation */
        .hamburger-icon {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 20px;
            height: 16px;
            position: relative;
            transition: all 0.3s ease;
        }

        .hamburger-line {
            display: block;
            height: 2.5px;
            width: 100%;
            background-color: #000000;
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform-origin: center;
        }

        /* Active state - transform to X */
        #hamburgerBtn.active .hamburger-line:nth-child(1) {
            transform: translateY(6.75px) rotate(45deg);
            background-color: #000000;
        }

        #hamburgerBtn.active .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
            background-color: #000000;
        }

        #hamburgerBtn.active .hamburger-line:nth-child(3) {
            transform: translateY(-6.75px) rotate(-45deg);
            background-color: #000000;
        }

        /* Hover effect */
        #hamburgerBtn:hover .hamburger-line {
            background-color: var(--primary-color, #f97316);
        }

        /* Dark mode - keep black */
        .dark .hamburger-line {
            background-color: #000000;
        }

        .dark #hamburgerBtn.active .hamburger-line {
            background-color: #000000;
        }
    </style>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const btn = document.getElementById('hamburgerBtn');
            
            menu.classList.toggle('hidden');
            btn.classList.toggle('active');
            
            // Add smooth animation
            if (!menu.classList.contains('hidden')) {
                menu.style.opacity = '0';
                menu.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    menu.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    menu.style.opacity = '1';
                    menu.style.transform = 'translateY(0)';
                }, 10);
            }
        }
    </script>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/header.blade.php ENDPATH**/ ?>