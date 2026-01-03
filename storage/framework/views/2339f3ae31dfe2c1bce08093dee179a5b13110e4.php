<?php $__env->startSection('content'); ?>
    <?php
        $Section_3 = App\Models\Additional::where('parent_id', $user->id)->where('section', 'Section 3')->first();
        $Section_3_content_value = !empty($Section_3->content_value)
            ? json_decode($Section_3->content_value, true)
            : [];
        
        // Get countries from owner's properties
        $countries = \App\Models\Property::where('parent_id', $user->id)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');
        
        // Use listingTypes from controller, or calculate if not provided
        if (!isset($listingTypes)) {
            $listingTypes = \App\Models\Property::where('parent_id', $user->id)
                ->whereIn('listing_type', ['sell', 'rent'])
                ->select('listing_type')
                ->distinct()
                ->pluck('listing_type')
                ->toArray();
        }
        
        $currentListingType = request('listing_type', 'all');
    ?>

    <!-- Properties Header & Filter Section -->
    <div class="bg-background-light dark:bg-background-dark pt-32 md:pt-36 pb-6" style="padding-top: 110px !important;">
        <div class="w-full max-w-7xl mx-auto mb-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-6">
                <div class="flex-1">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-semibold text-text-main-light dark:text-text-main-dark mb-2 sm:mb-3 tracking-tight">
                        <?php echo e(!empty($Section_3_content_value['sec3_title']) ? $Section_3_content_value['sec3_title'] : __('Explore Available Properties Instantly')); ?>

                    </h1>
                    <p class="text-base sm:text-lg text-text-sub-light dark:text-text-sub-dark max-w-2xl font-light">
                        <?php echo e(!empty($Section_3_content_value['sec3_sub_title']) ? $Section_3_content_value['sec3_sub_title'] : __('Your complete property overview with photos, amenities, and key details.')); ?>

                    </p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <?php if(!empty($listingTypes) && count($listingTypes) > 0): ?>
                        <div class="flex bg-gray-200 dark:bg-gray-800 rounded-full p-1 shadow-inner">
                            <button class="px-4 sm:px-6 md:px-8 py-2 sm:py-2.5 rounded-full font-medium shadow-sm transition-all text-xs sm:text-sm <?php echo e($currentListingType == 'all' ? 'bg-primary text-white' : 'text-text-sub-light dark:text-text-sub-dark hover:text-primary dark:hover:text-white'); ?>"
                                    onclick="switchListingType('all', this)"
                                    data-listing-type="all">
                                <?php echo e(__('All')); ?>

                            </button>
                            <?php $__currentLoopData = $listingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button class="px-4 sm:px-6 md:px-8 py-2 sm:py-2.5 rounded-full font-medium shadow-sm transition-all text-xs sm:text-sm <?php echo e($currentListingType == $type ? 'bg-primary text-white' : 'text-text-sub-light dark:text-text-sub-dark hover:text-primary dark:hover:text-white'); ?>"
                                        onclick="switchListingType('<?php echo e($type); ?>', this)"
                                        data-listing-type="<?php echo e($type); ?>">
                                    <?php echo e($type == 'rent' ? __('Rent') : __('Buy')); ?>

                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    <button id="filterToggleBtn" 
                            class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-full shadow-sm hover:shadow-md transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 active:scale-95"
                            onclick="toggleFilterSection()"
                            aria-label="Toggle Filters">
                        <span class="material-icons-round text-xl sm:text-2xl text-text-main-light dark:text-text-main-dark">tune</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="filterSection" class="bg-card-light dark:bg-card-dark rounded-xl shadow-soft dark:shadow-none dark:border dark:border-border-dark p-4 sm:p-6 md:p-8 transition-all duration-300 overflow-hidden hidden">
                <?php echo e(Form::open(['route' => ['search.filter', 'code' => $user->code], 'method' => 'GET', 'id' => 'package_filter', 'class' => 'flex flex-col lg:flex-row gap-4 sm:gap-6 items-end'])); ?>

                
                <!-- Hidden field for listing_type -->
                <input type="hidden" name="listing_type" id="listing_type_filter" value="<?php echo e($currentListingType); ?>">
                
                <!-- Name Input -->
                <div class="w-full lg:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="name">
                        <?php echo e(__('Property Name')); ?>

                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo e(request('name')); ?>"
                               placeholder="<?php echo e(__('Search by name...')); ?>"
                               class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-2.5 sm:py-3.5 pl-3 sm:pl-4 pr-3 sm:pr-4 text-sm sm:text-base focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none hover:border-gray-400 dark:hover:border-gray-500">
                    </div>
                </div>

                <!-- Country Dropdown -->
                <div class="w-full lg:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="country">
                        <?php echo e(__('Select Country')); ?>

                    </label>
                    <div class="relative">
                        <select class="custom-select w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-2.5 sm:py-3.5 pl-3 sm:pl-4 pr-8 sm:pr-10 text-sm sm:text-base focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none cursor-pointer hover:border-gray-400 dark:hover:border-gray-500" 
                                id="country" 
                                name="country">
                                    <option value=""><?php echo e(__('Select Country')); ?></option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($country); ?>" <?php echo e(request('country') == $country ? 'selected' : ''); ?>><?php echo e($country); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                <!-- State Dropdown -->
                <div class="w-full lg:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="state">
                        <?php echo e(__('Select State')); ?>

                    </label>
                    <div class="relative">
                        <select class="custom-select w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-2.5 sm:py-3.5 pl-3 sm:pl-4 pr-8 sm:pr-10 text-sm sm:text-base focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none cursor-pointer hover:border-gray-400 dark:hover:border-gray-500" 
                                id="state" 
                                name="state">
                                    <option value=""><?php echo e(__('Select State')); ?></option>
                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($state); ?>" <?php echo e(request('state') == $state ? 'selected' : ''); ?>><?php echo e($state); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                <!-- City Dropdown -->
                <div class="w-full lg:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="city">
                        <?php echo e(__('Select City')); ?>

                    </label>
                    <div class="relative">
                        <select class="custom-select w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-2.5 sm:py-3.5 pl-3 sm:pl-4 pr-8 sm:pr-10 text-sm sm:text-base focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none cursor-pointer hover:border-gray-400 dark:hover:border-gray-500" 
                                id="city" 
                                name="city">
                                    <option value=""><?php echo e(__('Select City')); ?></option>
                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city); ?>" <?php echo e(request('city') == $city ? 'selected' : ''); ?>><?php echo e($city); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                <!-- Buttons -->
                <div class="w-full lg:w-1/4 flex flex-col sm:flex-row gap-3 pt-2 lg:pt-0">
                    <button type="submit" 
                            class="flex-1 bg-primary hover:bg-primary-hover text-white dark:text-white font-medium py-2.5 sm:py-3.5 px-4 sm:px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 group active:scale-[0.98] text-sm sm:text-base" 
                            id="search_button">
                        <span class="material-icons-round text-lg sm:text-xl group-hover:scale-110 transition-transform">search</span>
                        <span><?php echo e(__('Search')); ?></span>
                            </button>
                           <a href="<?php echo e(route('search.filter', ['code' => $user->code])); ?>"
                       class="w-full sm:w-auto sm:min-w-[100px] bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark hover:bg-gray-100 dark:hover:bg-gray-800 text-text-main-light dark:text-text-main-dark font-medium py-2.5 sm:py-3.5 px-4 sm:px-6 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 group active:scale-[0.98] text-sm sm:text-base" 
                       id="reset_button">
                        <span class="material-icons-round text-lg sm:text-xl text-text-sub-light dark:text-text-sub-dark group-hover:rotate-[-45deg] transition-transform">restart_alt</span>
                        <span><?php echo e(__('Reset')); ?></span>
                    </a>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>

    <!-- Properties List Section -->
    <section class="py-6 md:py-8">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="package-wrapper">
                    <?php echo $__env->make('theme.propertybox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </section>

    <style>
        #filterSection {
            max-height: 0;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
        }
        
        #filterSection.show {
            max-height: 2000px;
            opacity: 1;
            padding-top: 1rem;
            padding-bottom: 1rem;
            margin-top: 1rem;
            margin-bottom: 0;
        }
        
        #filterSection.hidden {
            max-height: 0;
            opacity: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
        }
        
        @media (min-width: 640px) {
            #filterSection.show {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }
        }
        
        @media (min-width: 768px) {
            #filterSection.show {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }
    </style>

    <script>
        function toggleFilterSection() {
            const filterSection = document.getElementById('filterSection');
            const filterBtn = document.getElementById('filterToggleBtn');
            const icon = filterBtn.querySelector('.material-icons-round');
            
            if (filterSection.classList.contains('hidden')) {
                // Show filter section
                filterSection.classList.remove('hidden');
                filterSection.classList.add('show');
                icon.textContent = 'close';
                filterBtn.classList.add('bg-primary', 'text-white');
                filterBtn.classList.remove('bg-card-light', 'dark:bg-card-dark');
            } else {
                // Hide filter section
                filterSection.classList.remove('show');
                filterSection.classList.add('hidden');
                icon.textContent = 'tune';
                filterBtn.classList.remove('bg-primary', 'text-white');
                filterBtn.classList.add('bg-card-light', 'dark:bg-card-dark');
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>

        $(document).ready(function() {

            // Pagination via AJAX
            $(document).on('click', '.mbp_pagination .page-link', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        $('#package-wrapper').html(
                            '<div class="text-center py-5 text-slate-900 dark:text-slate-100">Loading...</div>');
                    },
                    success: function(data) {
                        $('#package-wrapper').html(data);
                        window.history.pushState(null, null, url);
                    },
                    error: function() {
                        alert('Something went wrong.');
                    }
                });
            });
        });




    </script>

    <script>
        $(document).ready(function () {
            // Form submission with AJAX
            $('#package_filter').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let url = $(this).attr('action');

                $.ajax({
                    url: url + '?ajax=1',
                    type: 'GET',
                    data: formData,
                    beforeSend: function() {
                        $('#package-wrapper').html('<div class="text-center py-5 text-slate-900 dark:text-slate-100">Loading...</div>');
                    },
                    success: function(data) {
                        $('#package-wrapper').html(data);
                        // Update URL without reload
                        let newUrl = url + '?' + formData;
                        window.history.pushState(null, null, newUrl);
                    },
                    error: function() {
                        alert('Something went wrong.');
                    }
                });
            });

            $('#reset_button').on('click', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    beforeSend: function() {
                        $('#package-wrapper').html('<div class="text-center py-5 text-slate-900 dark:text-slate-100">Loading...</div>');
                    },
                    success: function(data) {
                        $('#package-wrapper').html(data);
                        window.history.pushState(null, null, url);
                        // Reset all form fields
                        $('#country, #state, #city, #name').val('');
                        $('#state').html('<option value="">Select State</option>');
                        $('#city').html('<option value="">Select City</option>');
                        // Reset listing type to 'all'
                        $('#listing_type_filter').val('all');
                        // Update toggle buttons
                        document.querySelectorAll('[data-listing-type]').forEach(btn => {
                            btn.classList.remove('bg-primary', 'text-white');
                            btn.classList.add('text-text-sub-light', 'dark:text-text-sub-dark');
                            if (btn.getAttribute('data-listing-type') === 'all') {
                                btn.classList.add('bg-primary', 'text-white');
                                btn.classList.remove('text-text-sub-light', 'dark:text-text-sub-dark');
                            }
                        });
                    },
                    error: function() {
                        alert('Failed to reset.');
                    }
                });
            });


        });

        // Function to switch listing type (All/Rent/Buy)
        function switchListingType(type, button) {
            // Update button states
            document.querySelectorAll('[data-listing-type]').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('text-text-sub-light', 'dark:text-text-sub-dark');
            });
            button.classList.add('bg-primary', 'text-white');
            button.classList.remove('text-text-sub-light', 'dark:text-text-sub-dark');
            
            // Update hidden field
            $('#listing_type_filter').val(type);
            
            // Get current form data
            let formData = $('#package_filter').serialize();
            let url = $('#package_filter').attr('action');
            
            // Make AJAX call to filter properties
            $.ajax({
                url: url + '?ajax=1',
                type: 'GET',
                data: formData,
                beforeSend: function() {
                    $('#package-wrapper').html('<div class="text-center py-5 text-slate-900 dark:text-slate-100">Loading...</div>');
                },
                success: function(data) {
                    $('#package-wrapper').html(data);
                    // Update URL without reload
                    let newUrl = url + '?' + formData;
                    window.history.pushState(null, null, newUrl);
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/property.blade.php ENDPATH**/ ?>