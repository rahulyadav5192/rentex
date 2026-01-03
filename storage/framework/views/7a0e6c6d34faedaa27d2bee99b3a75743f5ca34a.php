<?php $__env->startSection('content'); ?>

    <!-- Home Banner Style V1 -->
    <?php
        $Section_0 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 0')->first();
        $Section_0_content_value = !empty($Section_0->content_value)
            ? json_decode($Section_0->content_value, true)
            : [];
    ?>
    <?php if(empty($Section_0_content_value['section_enabled']) || $Section_0_content_value['section_enabled'] == 'active'): ?>
        <?php
            $bgImageUrl = null;
            if (!empty($Section_0_content_value['bg_image_path'])) {
                $bgImageUrl = fetch_file(basename($Section_0_content_value['bg_image_path']), 'upload/fronthomepage/');
            }
        ?>
        <section class="flex-grow flex items-center py-6 sm:py-8 lg:py-20 relative hero-section-mobile" style="overflow: visible;">
            <style>
                .hero-section-mobile {
                    padding-top: 100px !important;
                    min-height: calc(100vh - 100px) !important;
                }
                @media (min-width: 640px) {
                    .hero-section-mobile {
                        padding-top: 140px !important;
                        min-height: calc(100vh - 140px) !important;
                    }
                }
            </style>
            <?php if($bgImageUrl): ?>
                <!-- Full screen background image - extends behind header to full viewport -->
                <!-- Account for body_content margin-top (80px mobile, 110px desktop) to reach viewport top, and extend to full height -->
                <div class="absolute w-full z-0 hero-bg-image" style="background-image: url('<?php echo e($bgImageUrl); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; left: 0; right: 0; height: 100vh; min-height: 100vh;"></div>
                <!-- Dark overlay with increased opacity (75% light, 80% dark) -->
                <div class="absolute w-full bg-slate-900/75 dark:bg-slate-900/80 z-0 hero-bg-overlay" style="left: 0; right: 0; height: 100vh; min-height: 100vh;"></div>
                <style>
                    .hero-bg-image {
                        top: -80px;
                    }
                    .hero-bg-overlay {
                        top: -80px;
                    }
                    @media (min-width: 640px) {
                        .hero-bg-image {
                            top: -110px;
                        }
                        .hero-bg-overlay {
                            top: -110px;
                        }
                    }
                </style>
            <?php endif; ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 items-center">
                    <div class="flex flex-col space-y-6 md:space-y-8 max-w-2xl order-1">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-display font-extrabold <?php echo e($bgImageUrl ? 'text-white' : 'text-slate-900 dark:text-white'); ?> leading-[1.1] tracking-tight">
                            <?php echo e($Section_0_content_value['title'] ?? 'Owner Rentex'); ?>

                        </h1>
                        <p class="text-base sm:text-lg lg:text-xl <?php echo e($bgImageUrl ? 'text-slate-200' : 'text-slate-500 dark:text-slate-400'); ?> leading-relaxed font-light">
                            <?php echo e($Section_0_content_value['sub_title'] ?? 'Experience the most extensive and thorough real-estate management platform. Streamline your property workflow, from tenant screening to maintenance requests. Boost your portfolio\'s performance with our comprehensive suite of tools designed for modern owners.'); ?>

                        </p>
                        <div class="flex flex-row gap-2 sm:gap-3 md:gap-4 pt-2 sm:pt-4">
                            <?php if(!empty($Section_0_content_value['btn_name'])): ?>
                                <a class="inline-flex justify-center items-center flex-1 px-4 sm:px-6 md:px-8 py-2.5 sm:py-3 md:py-4 bg-primary text-white text-xs sm:text-sm md:text-base font-semibold rounded-full shadow-glow hover:bg-orange-600 transition-all duration-300 transform hover:-translate-y-1 whitespace-nowrap" 
                                   href="<?php echo e($Section_0_content_value['btn_link'] ?? route('property.home', ['code' => $user->code])); ?>">
                                    <span class="hidden sm:inline"><?php echo e($Section_0_content_value['btn_name']); ?></span>
                                    <span class="sm:hidden"><?php echo e(__('Explore')); ?></span>
                                    <span class="material-icons-round ml-1 sm:ml-2 text-sm sm:text-base md:text-lg">arrow_forward</span>
                                </a>
                            <?php else: ?>
                                <a class="inline-flex justify-center items-center flex-1 px-4 sm:px-6 md:px-8 py-2.5 sm:py-3 md:py-4 bg-primary text-white text-xs sm:text-sm md:text-base font-semibold rounded-full shadow-glow hover:bg-orange-600 transition-all duration-300 transform hover:-translate-y-1 whitespace-nowrap" 
                                   href="<?php echo e(route('property.home', ['code' => $user->code])); ?>">
                                    <span class="hidden sm:inline"><?php echo e(__('Explore Properties')); ?></span>
                                    <span class="sm:hidden"><?php echo e(__('Explore')); ?></span>
                                    <span class="material-icons-round ml-1 sm:ml-2 text-sm sm:text-base md:text-lg">arrow_forward</span>
                                </a>
                            <?php endif; ?>
                            <a class="inline-flex justify-center items-center flex-1 px-4 sm:px-6 md:px-8 py-2.5 sm:py-3 md:py-4 border-2 <?php echo e($bgImageUrl ? 'border-white/30 text-white hover:bg-white/10' : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800'); ?> text-xs sm:text-sm md:text-base font-semibold rounded-full transition-all duration-300 whitespace-nowrap" 
                               href="<?php echo e(route('contact.home', ['code' => $user->code])); ?>">
                                <?php echo e(__('Contact Us')); ?>

                            </a>
                        </div>
                        
                    </div>
                    <div class="relative group order-2 mb-6 lg:mb-0">
                        <div class="absolute -inset-2 sm:-inset-4 bg-gradient-to-r from-primary/20 to-purple-500/20 rounded-[2.5rem] blur-2xl opacity-50 dark:opacity-30 group-hover:opacity-75 transition duration-500"></div>
                        <div class="relative overflow-hidden rounded-[2rem] shadow-2xl dark:shadow-black/50 aspect-[4/3] lg:aspect-square xl:aspect-[4/3]">
                            <?php if(!empty($Section_0_content_value['banner_image1_path'])): ?>
                                <?php
                                    $bannerImage = fetch_file(basename($Section_0_content_value['banner_image1_path']), 'upload/fronthomepage/');
                                ?>
                                <img alt="Modern luxury property" 
                                     class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-in-out" 
                                     src="<?php echo e($bannerImage); ?>"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-60" style="<?php echo e(!empty($Section_0_content_value['banner_image1_path']) ? '' : 'display: flex; align-items: center; justify-content: center;'); ?>">
                                <?php if(empty($Section_0_content_value['banner_image1_path'])): ?>
                                    <div class="text-center text-white">
                                        <i class="ti ti-home" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                        <p style="font-size: 1.2rem; opacity: 0.7;"><?php echo e(__('Banner Image')); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Need something -->
    <?php
        $Section_1 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 1')->first();
        $Section_1_content_value = !empty($Section_1->content_value)
            ? json_decode($Section_1->content_value, true)
            : [];
        
        // Map icons for features (can be customized per box) 
        $featureIcons = [
            1 => ['icon' => 'eco', 'color' => 'green'],
            2 => ['icon' => 'pool', 'color' => 'blue'],
            3 => ['icon' => 'security', 'color' => 'purple'],
            4 => ['icon' => 'build_circle', 'color' => 'orange'],
        ];
    ?>
    <?php if(empty($Section_1_content_value['section_enabled']) || $Section_1_content_value['section_enabled'] == 'active'): ?>
        <section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="text-center mb-10 sm:mb-12 lg:mb-16">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-text-main-light dark:text-text-main-dark mb-3 sm:mb-4 tracking-tight">
                    <?php echo e($Section_1_content_value['Sec1_title'] ?? __('Property Highlights')); ?>

                </h2>
                <p class="text-base sm:text-lg text-text-muted-light dark:text-text-muted-dark max-w-2xl mx-auto px-2 sm:px-0">
                    <?php echo e($Section_1_content_value['Sec1_info'] ?? __('Top reasons this property is a smart investment, curated for long-term growth and comfort.')); ?>

                </p>
                        </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    <?php for($is4 = 1; $is4 <= 4; $is4++): ?>
                        <?php if(
                            !empty($Section_1_content_value['Sec1_box' . $is4 . '_enabled']) &&
                                $Section_1_content_value['Sec1_box' . $is4 . '_enabled'] == 'active'): ?>
                        <?php
                            $iconData = $featureIcons[$is4] ?? ['icon' => 'star', 'color' => 'gray'];
                            $iconColor = $iconData['color'];
                            // Map color to Tailwind classes - using full class names for Tailwind to detect
                            $bgColorClasses = [
                                'green' => 'bg-green-100 dark:bg-green-900/30',
                                'blue' => 'bg-blue-100 dark:bg-blue-900/30',
                                'purple' => 'bg-purple-100 dark:bg-purple-900/30',
                                'orange' => 'bg-orange-100 dark:bg-orange-900/30',
                                'gray' => 'bg-gray-100 dark:bg-gray-900/30',
                            ];
                            $iconColorClasses = [
                                'green' => 'text-green-600 dark:text-green-400',
                                'blue' => 'text-blue-600 dark:text-blue-400',
                                'purple' => 'text-purple-600 dark:text-purple-400',
                                'orange' => 'text-orange-600 dark:text-orange-400',
                                'gray' => 'text-gray-600 dark:text-gray-400',
                            ];
                            $bgClass = $bgColorClasses[$iconColor] ?? $bgColorClasses['gray'];
                            $iconClass = $iconColorClasses[$iconColor] ?? $iconColorClasses['gray'];
                        ?>
                        <div class="group bg-surface-light dark:bg-surface-dark rounded-2xl p-6 sm:p-8 shadow-soft hover:shadow-soft-hover transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full <?php echo e($bgClass); ?> flex items-center justify-center mb-4 sm:mb-6 mx-auto sm:mx-0 group-hover:scale-110 transition-transform duration-300">
                                <?php if(!empty($Section_1_content_value['Sec1_box' . $is4 . '_image_path'])): ?>
                                    <img src="<?php echo e(fetch_file(basename($Section_1_content_value['Sec1_box' . $is4 . '_image_path']), 'upload/fronthomepage/')); ?>"
                                         alt="<?php echo e($Section_1_content_value['Sec1_box' . $is4 . '_title'] ?? ''); ?>"
                                         class="w-10 h-10 sm:w-12 sm:h-12 object-contain"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <span class="material-icons-outlined text-2xl sm:text-3xl <?php echo e($iconClass); ?>" style="display: none;"><?php echo e($iconData['icon']); ?></span>
                                <?php else: ?>
                                    <span class="material-icons-outlined text-2xl sm:text-3xl <?php echo e($iconClass); ?>"><?php echo e($iconData['icon']); ?></span>
                                <?php endif; ?>
                                    </div>
                            <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-text-main-light dark:text-text-main-dark text-center sm:text-left">
                                <?php echo e($Section_1_content_value['Sec1_box' . $is4 . '_title'] ?? ''); ?>

                            </h3>
                            <p class="text-text-muted-light dark:text-text-muted-dark leading-relaxed text-sm text-center sm:text-left">
                                <?php echo e($Section_1_content_value['Sec1_box' . $is4 . '_info'] ?? ''); ?>

                            </p>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Funfact -->
    <?php
        $Section_2 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 2')->first();
        $Section_2_content_value = !empty($Section_2->content_value)
            ? json_decode($Section_2->content_value, true)
            : [];
        
        // Map icons for stats
        $statIcons = [
            1 => 'apartment',
            2 => 'groups',
            3 => 'verified',
            4 => 'rocket_launch',
        ];
    ?>
    <?php if(empty($Section_2_content_value['section_enabled']) || $Section_2_content_value['section_enabled'] == 'active'): ?>
        <section id="stats-counter-section" class="mt-12 w-full">
            <div class="relative w-full overflow-hidden rounded-t-4xl px-4 sm:px-6 lg:px-8 py-24" style="background: linear-gradient(135deg, #1d6061 0%, #154c4d 100%);">
                <div class="absolute top-0 right-0 w-full h-full circle-pattern opacity-30 pointer-events-none"></div>
                <div class="max-w-7xl mx-auto relative z-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 text-center divide-y lg:divide-y-0 lg:divide-x divide-white/10">
                        <?php for($boxNum = 1; $boxNum <= 4; $boxNum++): ?>
                            <?php if(!empty($Section_2_content_value['Box' . $boxNum . '_number']) || !empty($Section_2_content_value['Box' . $boxNum . '_title'])): ?>
                                <?php
                                    $targetNumber = (int)($Section_2_content_value['Box' . $boxNum . '_number'] ?? 0);
                                ?>
                                <div class="flex flex-col items-center p-4 group">
                                    <div class="mb-4 p-3 bg-white/10 rounded-full backdrop-blur-sm group-hover:bg-white/20 transition-colors duration-300">
                                        <span class="material-icons-outlined text-3xl text-white"><?php echo e($statIcons[$boxNum] ?? 'star'); ?></span>
                                    </div>
                                    <span class="counter-number text-5xl lg:text-6xl font-extrabold text-white mb-2 tracking-tight" 
                                          data-target="<?php echo e($targetNumber); ?>"
                                          data-duration="2000">
                                        0
                                    </span>
                                    <span class="text-sm uppercase tracking-widest font-semibold text-white/70">
                                        <?php echo e($Section_2_content_value['Box' . $boxNum . '_title'] ?? ''); ?>

                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </section>
        
        <script>
            (function() {
                // Counter animation function
                function animateCounter(element) {
                    const target = parseInt(element.getAttribute('data-target')) || 0;
                    const duration = parseInt(element.getAttribute('data-duration')) || 2000;
                    const start = 0;
                    const increment = target / (duration / 16); // 60fps
                    let current = start;
                    
                    const timer = setInterval(function() {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        
                        // Format number (add commas for thousands)
                        const formatted = Math.floor(current).toLocaleString('en-US');
                        element.textContent = formatted;
                    }, 16); // ~60fps
                }
                
                // Intersection Observer to trigger animation when section is in view
                const statsSection = document.getElementById('stats-counter-section');
                if (statsSection) {
                    const observerOptions = {
                        root: null,
                        rootMargin: '0px',
                        threshold: 0.3 // Trigger when 30% of section is visible
                    };
                    
                    const observer = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                // Get all counter elements
                                const counters = entry.target.querySelectorAll('.counter-number');
                                counters.forEach(function(counter) {
                                    // Only animate if not already animated
                                    if (!counter.classList.contains('animated')) {
                                        counter.classList.add('animated');
                                        animateCounter(counter);
                                    }
                                });
                                // Stop observing after animation starts
                                observer.unobserve(entry.target);
                            }
                        });
                    }, observerOptions);
                    
                    observer.observe(statsSection);
                }
            })();
        </script>
    <?php endif; ?>


    <!-- category -->
    <?php
        $Section_3 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 3')->first();
        $Section_3_content_value = !empty($Section_3->content_value)
            ? json_decode($Section_3->content_value, true)
            : [];
        
        // Map amenity names to icons and categories
        $amenityIcons = [
            'garden' => ['icon' => 'park', 'category' => 'Nature'],
            'lawn' => ['icon' => 'park', 'category' => 'Nature'],
            'security' => ['icon' => 'security', 'category' => 'Safety'],
            'gym' => ['icon' => 'fitness_center', 'category' => 'Wellness'],
            'fitness' => ['icon' => 'fitness_center', 'category' => 'Wellness'],
            'parking' => ['icon' => 'directions_car', 'category' => 'Convenience'],
            'pool' => ['icon' => 'pool', 'category' => 'Leisure'],
            'swimming' => ['icon' => 'pool', 'category' => 'Leisure'],
        ];
    ?>

    <?php if(empty($Section_3_content_value['section_enabled']) || $Section_3_content_value['section_enabled'] == 'active'): ?>
        <section class="py-20 px-4 md:px-8 max-w-7xl mx-auto overflow-hidden">
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-display font-bold mb-3 text-text-light dark:text-white">
                    <?php echo e($Section_3_content_value['Sec3_title'] ?? __('Available Amenities')); ?>

                </h2>
                <p class="text-muted-light dark:text-muted-dark text-lg max-w-2xl">
                    <?php echo e($Section_3_content_value['Sec3_info'] ?? __('Experience premium facilities that enhance your stay and simplify your daily life.')); ?>

                </p>
                </div>
                <?php if(isset($allAmenities) && count($allAmenities) > 0): ?>
                <div class="relative group">
                    <button id="amenities-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 flex items-center justify-center bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full shadow-lg border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:scale-110 transition-transform duration-300 md:opacity-0 group-hover:opacity-100" onclick="scrollAmenities('left')">
                        <span class="material-icons-outlined">arrow_back</span>
                    </button>
                    <button id="amenities-next" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 flex items-center justify-center bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full shadow-lg border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:scale-110 transition-transform duration-300 md:opacity-0 group-hover:opacity-100" onclick="scrollAmenities('right')">
                        <span class="material-icons-outlined">arrow_forward</span>
                    </button>
                    <div id="amenities-scroll" class="flex gap-6 overflow-x-auto scrollbar-hide pb-8 snap-x snap-mandatory">
                                <?php $__currentLoopData = $allAmenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $image = !empty($amenity->image) ? $amenity->image : 'default.png';
                                $imageUrl = fetch_file($image, 'upload/amenity/');
                                $amenityNameLower = strtolower($amenity->name);
                                $iconData = null;
                                foreach ($amenityIcons as $key => $value) {
                                    if (strpos($amenityNameLower, $key) !== false) {
                                        $iconData = $value;
                                        break;
                                    }
                                }
                                if (!$iconData) {
                                    $iconData = ['icon' => 'star', 'category' => 'Feature'];
                                }
                            ?>
                            <div class="min-w-[280px] md:min-w-[340px] h-[240px] md:h-[280px] relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 snap-center group/card cursor-pointer">
                                <?php if(!empty($imageUrl) && $image != 'default.png'): ?>
                                    <img alt="<?php echo e(ucfirst($amenity->name)); ?>" 
                                         class="w-full h-full object-cover transform group-hover/card:scale-110 transition-transform duration-700" 
                                         src="<?php echo e($imageUrl); ?>"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 <?php echo e(!empty($imageUrl) && $image != 'default.png' ? 'hidden' : 'flex items-center justify-center'); ?>">
                                    <span class="material-icons-outlined text-6xl text-white/30"><?php echo e($iconData['icon']); ?></span>
                                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-6 w-full">
                                    <div class="flex items-center gap-2 mb-1 opacity-0 translate-y-4 group-hover/card:opacity-100 group-hover/card:translate-y-0 transition-all duration-500">
                                        <span class="material-icons-outlined text-primary text-sm"><?php echo e($iconData['icon']); ?></span>
                                        <span class="text-xs font-semibold text-primary uppercase tracking-wider"><?php echo e($iconData['category']); ?></span>
                                    </div>
                                    <h3 class="text-white font-display font-bold text-xl mb-1"><?php echo e(ucfirst($amenity->name)); ?></h3>
                                    <p class="text-gray-200 text-sm font-light">
                                        <?php echo e(\Illuminate\Support\Str::limit(strip_tags($amenity->description ?? ''), 60, '...')); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <p class="text-muted-light dark:text-muted-dark"><?php echo e(__('No Amenities Available')); ?></p>
                    </div>
                <?php endif; ?>
        </section>
        
        <script>
            function scrollAmenities(direction) {
                const container = document.getElementById('amenities-scroll');
                const scrollAmount = 340; // Card width + gap
                if (direction === 'left') {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            }
        </script>
    <?php endif; ?>

    <!-- CTA Banner -->
    <?php
        $Section_4 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 4')->first();
        $Section_4_content_value = !empty($Section_4->content_value)
            ? json_decode($Section_4->content_value, true)
            : [];
        
        // Map box titles to icons and colors
        $boxIcons = [
            'verified' => ['icon' => 'verified', 'color' => 'blue'],
            'quality' => ['icon' => 'verified', 'color' => 'blue'],
            'cost' => ['icon' => 'savings', 'color' => 'green'],
            'hire' => ['icon' => 'savings', 'color' => 'green'],
            'secure' => ['icon' => 'shield', 'color' => 'purple'],
            'safe' => ['icon' => 'shield', 'color' => 'purple'],
            'management' => ['icon' => 'manage_accounts', 'color' => 'orange'],
            'manage' => ['icon' => 'manage_accounts', 'color' => 'orange'],
        ];
    ?>
    <?php if(empty($Section_4_content_value['section_enabled']) || $Section_4_content_value['section_enabled'] == 'active'): ?>
        <section class="py-20 px-4 md:px-8 bg-gray-100 dark:bg-gray-900 rounded-t-[3rem]">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-5 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 dark:bg-primary/20 text-primary text-sm font-semibold">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                            <?php echo e(__('Why Choose Owner Rentex')); ?>

                        </div>
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-text-light dark:text-white leading-tight">
                            <?php
                                $title = $Section_4_content_value['Sec4_title'] ?? 'Smart, Secure & Hassle-Free Property Living.';
                                // Try to split on common patterns
                                if (strpos($title, '&') !== false) {
                                    $parts = explode('&', $title);
                                    $firstPart = trim($parts[0]);
                                    $lastPart = '& ' . trim($parts[1] ?? '');
                                } else {
                                    $titleParts = explode(' ', $title);
                                    $midPoint = ceil(count($titleParts) / 2);
                                    $firstPart = implode(' ', array_slice($titleParts, 0, $midPoint));
                                    $lastPart = implode(' ', array_slice($titleParts, $midPoint));
                                }
                            ?>
                            <?php echo e($firstPart); ?> <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-teal-400"><?php echo e($lastPart); ?></span>
                                </h2>
                        <p class="text-lg text-muted-light dark:text-muted-dark leading-relaxed">
                            <?php echo e($Section_4_content_value['Sec4_info'] ?? __('A whole world of freelance talent at your fingertips. We streamline the rental experience, connecting you with verified properties and ensuring peace of mind at every step.')); ?>

                        </p>
                        <?php if(!empty($Section_4_content_value['Sec4_btn_name'])): ?>
                            <div class="pt-4">
                                <a class="inline-flex items-center font-semibold text-primary hover:text-primary-dark dark:hover:text-teal-400 group" 
                                   href="<?php echo e($Section_4_content_value['Sec4_btn_link'] ?? '#'); ?>">
                                    <?php echo e($Section_4_content_value['Sec4_btn_name']); ?>

                                    <span class="material-icons-outlined ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                        <?php endif; ?>
                        </div>
                    <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if(!empty($Section_4_content_value['Sec4_Box_title'])): ?>
                                <?php $__currentLoopData = $Section_4_content_value['Sec4_Box_title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec4_key => $sec4_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $boxTitleLower = strtolower($sec4_item ?? '');
                                    $iconData = null;
                                    foreach ($boxIcons as $key => $value) {
                                        if (strpos($boxTitleLower, $key) !== false) {
                                            $iconData = $value;
                                            break;
                                        }
                                    }
                                    if (!$iconData) {
                                        $iconData = ['icon' => 'star', 'color' => 'gray'];
                                    }
                                    $colorClass = $iconData['color'];
                                    $bgColorClasses = [
                                        'blue' => 'bg-blue-100 dark:bg-blue-900/30',
                                        'green' => 'bg-green-100 dark:bg-green-900/30',
                                        'purple' => 'bg-purple-100 dark:bg-purple-900/30',
                                        'orange' => 'bg-orange-100 dark:bg-orange-900/30',
                                        'gray' => 'bg-gray-100 dark:bg-gray-900/30',
                                    ];
                                    $iconColorClasses = [
                                        'blue' => 'text-blue-600 dark:text-blue-400',
                                        'green' => 'text-green-600 dark:text-green-400',
                                        'purple' => 'text-purple-600 dark:text-purple-400',
                                        'orange' => 'text-orange-600 dark:text-orange-400',
                                        'gray' => 'text-gray-600 dark:text-gray-400',
                                    ];
                                    $bgClass = $bgColorClasses[$colorClass] ?? $bgColorClasses['gray'];
                                    $iconClass = $iconColorClasses[$colorClass] ?? $iconColorClasses['gray'];
                                ?>
                                <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-transparent dark:border-gray-800">
                                    <div class="w-12 h-12 rounded-xl <?php echo e($bgClass); ?> flex items-center justify-center mb-4 <?php echo e($iconClass); ?>">
                                        <span class="material-icons-outlined text-2xl"><?php echo e($iconData['icon']); ?></span>
                                    </div>
                                    <h3 class="text-xl font-display font-bold text-text-light dark:text-white mb-2">
                                        <?php echo e($sec4_item ?? ''); ?>

                                    </h3>
                                    <p class="text-muted-light dark:text-muted-dark text-sm leading-relaxed">
                                                <?php echo e($Section_4_content_value['Sec4_Box_subtitle'][$sec4_key] ?? ''); ?>

                                            </p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Popular Services -->
    <?php
        $Section_5 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 5')->first();
        $Section_5_content_value = !empty($Section_5->content_value)
            ? json_decode($Section_5->content_value, true)
            : [];
    ?>
    <?php if(empty($Section_5_content_value['section_enabled']) || $Section_5_content_value['section_enabled'] == 'active'): ?>
        <section class="py-16 px-6 md:px-12 lg:px-20 max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-primary dark:text-white mb-3 tracking-tight">
                        <?php echo e($Section_5_content_value['Sec5_title'] ?? __('Find Your Perfect Property')); ?>

                    </h2>
                    <p class="text-text-sub-light dark:text-text-sub-dark max-w-xl text-lg">
                        <?php echo e($Section_5_content_value['Sec5_info'] ?? __('Explore residential and commercial spaces that suit your needs. From modern studios to expansive family homes.')); ?>

                    </p>
                        </div>
                <?php if(!empty($listingTypes) && count($listingTypes) > 0): ?>
                    <div class="flex bg-gray-200 dark:bg-gray-800 rounded-full p-1 shadow-inner">
                                <?php $__currentLoopData = $listingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button class="px-8 py-2.5 rounded-full font-medium shadow-sm transition-all text-sm <?php echo e($key == 0 ? 'bg-primary text-white' : 'text-text-sub-light dark:text-text-sub-dark hover:text-primary dark:hover:text-white'); ?>"
                                    onclick="switchPropertyTab('<?php echo e($type); ?>', this)"
                                    data-tab="<?php echo e($type); ?>">
                                            <?php echo e(ucfirst($type)); ?>

                                        </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                </div>
                <?php if(!empty($propertiesByType)): ?>
                <div class="flex flex-col gap-8" id="properties-container">
                                <?php $__currentLoopData = $listingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($propertiesByType[$type])): ?>
                            <?php $__currentLoopData = $propertiesByType[$type]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propertyIndex => $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $thumbnail = !empty($property->thumbnail) && !empty($property->thumbnail->image) 
                                        ? $property->thumbnail->image 
                                        : 'default.jpg';
                                    $thumbnailUrl = fetch_file($thumbnail, 'upload/property/thumbnail/');
                                    if (empty($thumbnailUrl) && $thumbnail != 'default.jpg') {
                                        $thumbnailUrl = asset('storage/upload/property/thumbnail/' . $thumbnail);
                                    }
                                    
                                    // Get first unit for property details
                                    $firstUnit = $property->totalUnits()->first();
                                    $bedrooms = $firstUnit ? $firstUnit->bedroom : 0;
                                    $bathrooms = $firstUnit ? $firstUnit->baths : 0;
                                    $squareFootage = 0; // Not stored in current schema
                                    
                                    // Determine property type badge
                                    $propertyType = $property->type ?? 'own_property';
                                    $badgeClass = $propertyType == 'own_property' 
                                        ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-100'
                                        : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100';
                                    $badgeText = $propertyType == 'own_property' ? __('Own Property') : __('Rental');
                                    
                                    // Format price
                                    $price = $property->price ?? 0;
                                    $priceFormatted = priceformat($price);
                                    if ($property->listing_type == 'rent') {
                                        $priceDisplay = $priceFormatted . '<span class="text-sm font-normal text-text-sub-light dark:text-text-sub-dark">/mo</span>';
                                    } else {
                                        $priceDisplay = $priceFormatted;
                                    }
                                    
                                    // Location
                                    $location = trim(($property->city ?? '') . ', ' . ($property->state ?? ''));
                                    if (empty($location) || $location == ', ') {
                                        $location = $property->address ?? '';
                                    }
                                ?>
                                <div class="group bg-card-light dark:bg-card-dark rounded-2xl shadow-soft card-hover transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row h-auto md:h-72 property-card" 
                                     data-type="<?php echo e($type); ?>" 
                                     style="<?php echo e($key > 0 ? 'display: none;' : ''); ?>">
                                    <div class="w-full md:w-5/12 h-64 md:h-full relative overflow-hidden">
                                        <?php if(!empty($thumbnailUrl) && $thumbnail != 'default.jpg'): ?>
                                            <img alt="<?php echo e(ucfirst($property->name)); ?>" 
                                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                                 src="<?php echo e($thumbnailUrl); ?>"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 <?php echo e(!empty($thumbnailUrl) && $thumbnail != 'default.jpg' ? 'hidden' : 'flex items-center justify-center'); ?>">
                                            <span class="material-symbols-outlined text-6xl text-white/30">home</span>
                                        </div>
                                        <?php if($key == 0 && $propertyIndex == 0): ?>
                                            <div class="absolute top-4 left-4 bg-white/90 dark:bg-black/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-primary dark:text-white uppercase tracking-wider shadow-sm">
                                                <?php echo e(__('Featured')); ?>

                                            </div>
                                                <?php endif; ?>
                                                        </div>
                                    <div class="flex-1 p-6 md:p-8 flex flex-col justify-between">
                                        <div>
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h3 class="text-2xl font-bold text-primary dark:text-white mb-1"><?php echo e(ucfirst($property->name)); ?></h3>
                                                    <p class="text-text-sub-light dark:text-text-sub-dark text-sm font-medium">
                                                        <?php echo e(\Illuminate\Support\Str::limit(strip_tags($property->description ?? ''), 40, '...')); ?>

                                                    </p>
                                                </div>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo e($badgeClass); ?>">
                                                    <?php echo e($badgeText); ?>

                                                </span>
                                            </div>
                                            <hr class="border-gray-100 dark:border-gray-700 my-4"/>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6">
                                                <div class="flex items-center gap-2 text-text-main-light dark:text-text-main-dark">
                                                    <span class="material-symbols-outlined text-accent text-[20px]">payments</span>
                                                    <span class="font-semibold text-lg"><?php echo $priceDisplay; ?></span>
                                                            </div>
                                                <div class="flex items-center gap-2 text-text-sub-light dark:text-text-sub-dark">
                                                    <span class="material-symbols-outlined text-gray-400 text-[20px]">location_on</span>
                                                    <span class="truncate"><?php echo e($location); ?></span>
                                                        </div>
                                                <?php if($bedrooms > 0 || $bathrooms > 0): ?>
                                                    <div class="col-span-1 sm:col-span-2 flex items-center gap-4 mt-2 text-sm text-text-sub-light dark:text-text-sub-dark">
                                                        <?php if($bedrooms > 0): ?>
                                                            <span class="flex items-center gap-1">
                                                                <span class="material-symbols-outlined text-[18px]">bed</span> 
                                                                <?php echo e($bedrooms); ?> <?php echo e(__('Beds')); ?>

                                                            </span>
                                                            <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                                        <?php endif; ?>
                                                        <?php if($bathrooms > 0): ?>
                                                            <span class="flex items-center gap-1">
                                                                <span class="material-symbols-outlined text-[18px]">shower</span> 
                                                                <?php echo e($bathrooms); ?> <?php echo e(__('Baths')); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                                    </div>
                                                </div>
                                        <div class="mt-6 flex justify-end">
                                            <a href="<?php echo e(route('property.detail', ['code' => $user->code, \Crypt::encrypt($property->id)])); ?>" 
                                               class="flex items-center gap-2 text-primary dark:text-white font-semibold hover:text-accent dark:hover:text-emerald-400 transition-colors group-hover:translate-x-1 duration-300">
                                                <?php echo e(__('View Details')); ?>

                                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <p class="text-text-sub-light dark:text-text-sub-dark"><?php echo e(__('No Properties Available')); ?></p>
                    </div>
                <?php endif; ?>
        </section>
        
        <script>
            function switchPropertyTab(type, button) {
                // Update button states
                document.querySelectorAll('[data-tab]').forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('text-text-sub-light', 'dark:text-text-sub-dark');
                });
                button.classList.add('bg-primary', 'text-white');
                button.classList.remove('text-text-sub-light', 'dark:text-text-sub-dark');
                
                // Show/hide property cards
                document.querySelectorAll('.property-card').forEach(card => {
                    if (card.getAttribute('data-type') === type) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        </script>
    <?php endif; ?>

    <!-- Banner 2 -->
    <?php
        $Section_6 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 6')->first();
        $Section_6_content_value = !empty($Section_6->content_value)
            ? json_decode($Section_6->content_value, true)
            : [];
    ?>
    <?php if(empty($Section_6_content_value['section_enabled']) || $Section_6_content_value['section_enabled'] == 'active'): ?>
        <div class="relative w-full overflow-hidden mt-12">
            
            <section class="gradient-bg relative pt-24 pb-24 px-6 md:px-12 lg:px-20">
                <div class="absolute top-1/4 right-0 w-96 h-96 bg-blue-300/30 dark:bg-blue-600/20 rounded-full blur-3xl -mr-20 pointer-events-none"></div>
                <div class="absolute bottom-0 left-10 w-72 h-72 bg-emerald-300/30 dark:bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12 relative z-10">
                    <div class="w-full md:w-3/5 text-left space-y-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-primary/10 dark:bg-white/10 text-primary dark:text-white text-xs font-bold tracking-widest uppercase">
                            <?php echo e(__('Simplify. Organize. Grow.')); ?>

                        </span>
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-primary dark:text-white leading-tight">
                            <?php
                                $title = $Section_6_content_value['Sec6_title'] ?? 'All-in-One Property Management Made Simple';
                                $titleParts = explode(' ', $title);
                                $midPoint = ceil(count($titleParts) / 2);
                                $firstPart = implode(' ', array_slice($titleParts, 0, $midPoint));
                                $lastPart = implode(' ', array_slice($titleParts, $midPoint));
                            ?>
                            <?php echo e($firstPart); ?> <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300"><?php echo e($lastPart); ?></span>
                            </h2>
                        <p class="text-lg md:text-xl text-text-sub-light dark:text-gray-300 max-w-2xl leading-relaxed">
                            <?php echo e($Section_6_content_value['Sec6_info'] ?? __('Effortlessly manage every aspect of your property. Our system turns complex tasks into simple wins, giving you more time to focus on what matters.')); ?>

                        </p>
                        <div class="flex flex-wrap gap-4 md:gap-8 pt-4">
                            <div class="flex items-center gap-2">
                                <div class="bg-emerald-500/20 p-1 rounded-full">
                                    <span class="material-symbols-outlined text-emerald-700 dark:text-emerald-300 text-sm">check</span>
                                </div>
                                <span class="text-text-main-light dark:text-white font-medium"><?php echo e(__('Automated Billing')); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="bg-emerald-500/20 p-1 rounded-full">
                                    <span class="material-symbols-outlined text-emerald-700 dark:text-emerald-300 text-sm">check</span>
                                </div>
                                <span class="text-text-main-light dark:text-white font-medium"><?php echo e(__('Tenant Portal')); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="bg-emerald-500/20 p-1 rounded-full">
                                    <span class="material-symbols-outlined text-emerald-700 dark:text-emerald-300 text-sm">check</span>
                                </div>
                                <span class="text-text-main-light dark:text-white font-medium"><?php echo e(__('Maintenance Tracking')); ?></span>
                            </div>
                        </div>
                        <div class="pt-8 flex flex-col sm:flex-row gap-4">
                            <?php if(!empty($Section_6_content_value['sec6_btn_name'])): ?>
                                <a href="<?php echo e($Section_6_content_value['sec6_btn_link'] ?? '#'); ?>"
                                   class="bg-primary text-white hover:bg-gray-800 dark:hover:bg-gray-700 transition-all px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                                    <?php echo e($Section_6_content_value['sec6_btn_name']); ?>

                                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">north_east</span>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('property.home', ['code' => $user->code])); ?>"
                                   class="bg-primary text-white hover:bg-gray-800 dark:hover:bg-gray-700 transition-all px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                                    <?php echo e(__('Get Started')); ?>

                                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">north_east</span>
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('contact.home', ['code' => $user->code])); ?>"
                               class="px-8 py-4 rounded-lg font-semibold text-primary dark:text-white border border-primary/20 dark:border-white/20 hover:bg-primary/5 dark:hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                                <?php echo e(__('Learn More')); ?>

                            </a>
                        </div>
                    </div>
                    <div class="w-full md:w-2/5 relative hidden md:block">
                        <div class="relative w-full h-[400px]">
                            <?php if(!empty($Section_6_content_value['banner_image2_path'])): ?>
                                <?php
                                    $ctaImage = fetch_file(basename($Section_6_content_value['banner_image2_path']), 'upload/fronthomepage/');
                                ?>
                                <img src="<?php echo e($ctaImage); ?>" 
                                     alt="Property Management" 
                                     class="w-full h-full object-cover rounded-2xl shadow-2xl"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <?php endif; ?>
                            <div class="absolute top-10 right-0 w-3/4 bg-white/40 dark:bg-black/20 backdrop-blur-md rounded-2xl shadow-lg border border-white/30 p-6 transform rotate-6 z-0 <?php echo e(!empty($Section_6_content_value['banner_image2_path']) ? 'hidden' : ''); ?>">
                                <div class="h-4 w-1/3 bg-gray-400/30 rounded mb-4"></div>
                                <div class="h-2 w-full bg-gray-400/20 rounded mb-2"></div>
                                <div class="h-2 w-5/6 bg-gray-400/20 rounded mb-2"></div>
                                <div class="h-2 w-4/6 bg-gray-400/20 rounded"></div>
                            </div>
                            <div class="absolute top-20 right-12 w-3/4 bg-card-light dark:bg-card-dark rounded-2xl shadow-2xl p-6 border border-gray-100 dark:border-gray-700 transform -rotate-3 z-10 transition-transform hover:-rotate-1 duration-500 <?php echo e(!empty($Section_6_content_value['banner_image2_path']) ? 'hidden' : ''); ?>">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">analytics</span>
                                    </div>
                                    <div>
                                        <div class="h-4 w-24 bg-gray-200 dark:bg-gray-600 rounded mb-1"></div>
                                        <div class="h-3 w-16 bg-gray-100 dark:bg-gray-700 rounded"></div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-text-sub-light dark:text-text-sub-dark"><?php echo e(__('Revenue')); ?></span>
                                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">+24%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-sm text-text-sub-light dark:text-text-sub-dark"><?php echo e(__('Occupancy')); ?></span>
                                        <span class="text-sm font-bold text-primary dark:text-white">98%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary dark:bg-blue-500 h-2 rounded-full" style="width: 98%"></div>
                                    </div>
                                </div>
                                <div class="absolute -top-4 -right-4 bg-emerald-500 text-white p-2 rounded-full shadow-lg">
                                    <span class="material-symbols-outlined text-xl block">verified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </div>
    <?php endif; ?>

    <!--  Testimonials -->
    <?php
        $Section_7 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 7')->first();
        $Section_7_content_value = !empty($Section_7->content_value)
            ? json_decode($Section_7->content_value, true)
            : [];
        
            $testimonials = [];
            foreach ($Section_7_content_value as $key => $value) {
                if (\Illuminate\Support\Str::startsWith($key, 'Sec7_box') && \Illuminate\Support\Str::endsWith($key, '_Enabled') && $value === 'active') {
                    $boxNumber = str_replace(['Sec7_box', '_Enabled'], '', $key);
                    $testimonials[] = $boxNumber;
                }
            }
        ?>
    <?php if(empty($Section_7_content_value['section_enabled']) || $Section_7_content_value['section_enabled'] == 'active'): ?>
        <section class="relative py-12 sm:py-16 lg:py-20 xl:py-32 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute top-10 left-10 w-72 h-72 bg-primary/10 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-lighten animate-blob"></div>
                <div class="absolute bottom-10 right-10 w-72 h-72 bg-blue-400/10 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-lighten animate-blob animation-delay-2000"></div>
                        </div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12 lg:mb-16">
                    <span class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary font-semibold text-xs tracking-wider uppercase mb-3 sm:mb-4">
                        <?php echo e(__('Testimonials')); ?>

                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-display font-bold text-gray-900 dark:text-white mb-4 sm:mb-6 leading-tight px-2 sm:px-0">
                        <?php echo e($Section_7_content_value['Sec7_title'] ?? __('Trusted by Property Owners & Managers')); ?>

                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 leading-relaxed px-2 sm:px-0">
                        <?php echo e($Section_7_content_value['Sec7_info'] ?? __('Interdum et malesuada fames ac ante ipsum. Join thousands of landlords simplifying their workflow today.')); ?>

                    </p>
                </div>
                <?php if(!empty($testimonials)): ?>
                    <div class="max-w-4xl mx-auto relative z-10">
                        <div id="testimonial-carousel" class="glass-card bg-white/70 dark:bg-card-dark/80 shadow-2xl rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12 pb-12 sm:pb-16 md:pb-20 border border-white/20 dark:border-gray-700/50 text-center relative transition-transform duration-500 hover:scale-[1.01]">
                                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $imagePath = $Section_7_content_value["Sec7_box{$num}_image_path"] ?? '';
                                    $imageUrl = !empty($imagePath) ? fetch_file(basename($imagePath), 'upload/fronthomepage/') : asset('assets/images/admin/user.png');
                                    $name = $Section_7_content_value["Sec7_box{$num}_name"] ?? '';
                                    $tag = $Section_7_content_value["Sec7_box{$num}_tag"] ?? '';
                                    $review = $Section_7_content_value["Sec7_box{$num}_review"] ?? '';
                                ?>
                                <div class="testimonial-item <?php echo e($index === 0 ? '' : 'hidden'); ?>" data-index="<?php echo e($index); ?>">
                                    <div class="absolute top-4 sm:top-6 left-1/2 transform -translate-x-1/2 -mt-8 sm:-mt-10 md:-mt-12 bg-primary text-white w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center shadow-lg border-4 border-background-light dark:border-background-dark">
                                        <svg class="h-6 w-6 sm:h-8 sm:w-8 md:h-10 md:w-10" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path>
                                        </svg>
                                    </div>
                                    <div class="mt-6 sm:mt-8 md:mt-10 px-2 sm:px-0">
                                        <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-100 leading-relaxed italic">
                                            "<?php echo e($review); ?>"
                                        </h3>
                                    </div>
                                    <div class="mt-6 sm:mt-8 flex flex-col items-center">
                                        <div class="text-base sm:text-lg font-bold text-gray-900 dark:text-white font-display"><?php echo e($name); ?></div>
                                        <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide mt-1"><?php echo e($tag); ?></div>
                                        <div class="flex gap-1 text-yellow-400 mt-2">
                                            <?php for($i = 0; $i < 5; $i++): ?>
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <div class="flex justify-center items-center flex-wrap gap-3 sm:gap-4 mt-6 sm:mt-8">
                                    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $imagePath = $Section_7_content_value["Sec7_box{$num}_image_path"] ?? '';
                                    $imageUrl = !empty($imagePath) ? fetch_file(basename($imagePath), 'upload/fronthomepage/') : asset('assets/images/admin/user.png');
                                        ?>
                                <button aria-label="View testimonial <?php echo e($index + 1); ?>" 
                                        class="relative group focus:outline-none testimonial-nav-btn <?php echo e($index === 0 ? 'active' : ''); ?>"
                                        onclick="switchTestimonial(<?php echo e($index); ?>)"
                                        data-index="<?php echo e($index); ?>">
                                    <?php if($index === 0): ?>
                                        <div class="absolute -inset-1 bg-gradient-to-r from-primary to-green-400 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                                    <?php endif; ?>
                                    <img alt="<?php echo e($Section_7_content_value["Sec7_box{$num}_name"] ?? 'User ' . ($index + 1)); ?>" 
                                         class="relative h-12 w-12 sm:h-14 sm:w-14 rounded-full border-2 border-white dark:border-gray-800 object-cover <?php echo e($index === 0 ? 'ring-2 ring-primary ring-offset-2 ring-offset-background-light dark:ring-offset-background-dark' : 'opacity-50 grayscale group-hover:opacity-100 group-hover:grayscale-0 transition-all duration-300'); ?>" 
                                         src="<?php echo e($imageUrl); ?>"
                                         onerror="this.src='<?php echo e(asset('assets/images/admin/user.png')); ?>';">
                                            </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        
        <script>
            function switchTestimonial(index) {
                // Hide all testimonial items
                document.querySelectorAll('.testimonial-item').forEach(item => {
                    item.classList.add('hidden');
                });
                
                // Show selected testimonial
                const selectedItem = document.querySelector(`.testimonial-item[data-index="${index}"]`);
                if (selectedItem) {
                    selectedItem.classList.remove('hidden');
                }
                
                // Update nav buttons
                document.querySelectorAll('.testimonial-nav-btn').forEach(btn => {
                    btn.classList.remove('active');
                    const img = btn.querySelector('img');
                    if (img) {
                        img.classList.remove('ring-2', 'ring-primary', 'ring-offset-2', 'ring-offset-background-light', 'dark:ring-offset-background-dark');
                        img.classList.add('opacity-50', 'grayscale');
                    }
                });
                
                // Activate selected button
                const selectedBtn = document.querySelector(`.testimonial-nav-btn[data-index="${index}"]`);
                if (selectedBtn) {
                    selectedBtn.classList.add('active');
                    const img = selectedBtn.querySelector('img');
                    if (img) {
                        img.classList.remove('opacity-50', 'grayscale');
                        img.classList.add('ring-2', 'ring-primary', 'ring-offset-2', 'ring-offset-background-light', 'dark:ring-offset-background-dark');
                    }
                    
                    // Add gradient blur effect
                    if (!selectedBtn.querySelector('.absolute')) {
                        const blurDiv = document.createElement('div');
                        blurDiv.className = 'absolute -inset-1 bg-gradient-to-r from-primary to-green-400 rounded-full blur opacity-75 group-hover:opacity-100 transition duration-200';
                        selectedBtn.insertBefore(blurDiv, selectedBtn.firstChild);
                    }
                }
            }
        </script>
    <?php endif; ?>







<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function() {
            $('#search_button').on('click', function(e) {
                if (!$('#location-id').val()) {
                    e.preventDefault(); // stop form
                    alert('Please select a location from suggestions.');
                }
            });

            // Typing and suggestions (same as before)
            $('#search-query').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: "<?php echo e(route('search.location', $user->code)); ?>",
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('#search-results').html(response.html).show();
                        }
                    });
                } else {
                    $('#search-results').hide();
                }
            });

            // Selecting suggestion
            $(document).on('click', '.suggestion-item', function() {
                let title = $(this).data('title');

                let slug = $(this).data('slug');

                $('#search-query').val(title); // show name
                $('#location-id').val(slug);
                $('#search-results').hide();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/index.blade.php ENDPATH**/ ?>