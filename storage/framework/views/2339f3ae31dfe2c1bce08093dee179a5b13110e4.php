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
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-semibold text-text-main-light dark:text-text-main-dark mb-3 tracking-tight">
                        <?php echo e(!empty($Section_3_content_value['sec3_title']) ? $Section_3_content_value['sec3_title'] : __('Explore Available Properties Instantly')); ?>

                    </h1>
                    <p class="text-lg text-text-sub-light dark:text-text-sub-dark max-w-2xl font-light">
                        <?php echo e(!empty($Section_3_content_value['sec3_sub_title']) ? $Section_3_content_value['sec3_sub_title'] : __('Your complete property overview with photos, amenities, and key details.')); ?>

                    </p>
                </div>
                <?php if(!empty($listingTypes) && count($listingTypes) > 0): ?>
                    <div class="flex bg-gray-200 dark:bg-gray-800 rounded-full p-1 shadow-inner">
                        <button class="px-6 md:px-8 py-2.5 rounded-full font-medium shadow-sm transition-all text-sm <?php echo e($currentListingType == 'all' ? 'bg-primary text-white' : 'text-text-sub-light dark:text-text-sub-dark hover:text-primary dark:hover:text-white'); ?>"
                                onclick="switchListingType('all', this)"
                                data-listing-type="all">
                            <?php echo e(__('All')); ?>

                        </button>
                        <?php $__currentLoopData = $listingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button class="px-6 md:px-8 py-2.5 rounded-full font-medium shadow-sm transition-all text-sm <?php echo e($currentListingType == $type ? 'bg-primary text-white' : 'text-text-sub-light dark:text-text-sub-dark hover:text-primary dark:hover:text-white'); ?>"
                                    onclick="switchListingType('<?php echo e($type); ?>', this)"
                                    data-listing-type="<?php echo e($type); ?>">
                                <?php echo e($type == 'rent' ? __('Rent') : __('Buy')); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-card-light dark:bg-card-dark rounded-xl shadow-soft dark:shadow-none dark:border dark:border-border-dark p-6 md:p-8 transition-all duration-300">
                <?php echo e(Form::open(['route' => ['search.filter', 'code' => $user->code], 'method' => 'GET', 'id' => 'package_filter', 'class' => 'flex flex-col xl:flex-row gap-6 items-end'])); ?>

                
                <!-- Hidden field for listing_type -->
                <input type="hidden" name="listing_type" id="listing_type_filter" value="<?php echo e($currentListingType); ?>">
                
                <!-- Name Input -->
                <div class="w-full xl:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="name">
                        <?php echo e(__('Property Name')); ?>

                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo e(request('name')); ?>"
                               placeholder="<?php echo e(__('Search by name...')); ?>"
                               class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-3.5 pl-4 pr-4 focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none hover:border-gray-400 dark:hover:border-gray-500">
                    </div>
                </div>

                <!-- Country Dropdown -->
                <div class="w-full xl:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="country">
                        <?php echo e(__('Select Country')); ?>

                    </label>
                    <div class="relative">
                        <select class="custom-select w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-3.5 pl-4 pr-10 focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none cursor-pointer hover:border-gray-400 dark:hover:border-gray-500" 
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
                <div class="w-full xl:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="state">
                        <?php echo e(__('Select State')); ?>

                    </label>
                    <div class="relative">
                        <select class="custom-select w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-3.5 pl-4 pr-10 focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none cursor-pointer hover:border-gray-400 dark:hover:border-gray-500" 
                                id="state" 
                                name="state">
                            <option disabled selected value=""><?php echo e(__('Select State')); ?></option>
                            <?php if(request('state')): ?>
                                <option value="<?php echo e(request('state')); ?>" selected><?php echo e(request('state')); ?></option>
                            <?php endif; ?>
                                </select>
                            </div>
                        </div>

                <!-- City Dropdown -->
                <div class="w-full xl:w-1/4 group">
                    <label class="block text-sm font-medium text-text-sub-light dark:text-text-sub-dark mb-2 group-focus-within:text-accent transition-colors" for="city">
                        <?php echo e(__('Select City')); ?>

                    </label>
                    <div class="relative">
                        <select class="custom-select w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark text-text-main-light dark:text-text-main-dark rounded-lg py-3.5 pl-4 pr-10 focus:ring-2 focus:ring-accent focus:border-accent dark:focus:border-accent transition-all duration-200 outline-none cursor-pointer hover:border-gray-400 dark:hover:border-gray-500" 
                                id="city" 
                                name="city">
                            <option disabled selected value=""><?php echo e(__('Select City')); ?></option>
                            <?php if(request('city')): ?>
                                <option value="<?php echo e(request('city')); ?>" selected><?php echo e(request('city')); ?></option>
                            <?php endif; ?>
                                </select>
                            </div>
                        </div>

                <!-- Buttons -->
                <div class="w-full xl:w-1/4 flex gap-3 pt-2 xl:pt-0">
                    <button type="submit" 
                            class="flex-1 bg-primary hover:bg-primary-hover text-white dark:text-white font-medium py-3.5 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 group active:scale-[0.98]" 
                            id="search_button">
                        <span class="material-icons-round text-xl group-hover:scale-110 transition-transform">search</span>
                        <span><?php echo e(__('Search')); ?></span>
                            </button>
                           <a href="<?php echo e(route('search.filter', ['code' => $user->code])); ?>"
                       class="w-auto min-w-[100px] bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark hover:bg-gray-100 dark:hover:bg-gray-800 text-text-main-light dark:text-text-main-dark font-medium py-3.5 px-6 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 group active:scale-[0.98]" 
                       id="reset_button">
                        <span class="material-icons-round text-xl text-text-sub-light dark:text-text-sub-dark group-hover:rotate-[-45deg] transition-transform">restart_alt</span>
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
            // Function to load states
            function loadStates(country, selectedState) {
                if (!country || country === '' || country === null) {
                    $('#state').html('<option value="">Select State</option>');
                    $('#city').html('<option value="">Select City</option>');
                    return;
                }
                
                $('#state').html('<option>Loading...</option>');
                $('#city').html('<option value="">Select City</option>');

                var url = "<?php echo e(route('get-states', ['code' => $user->code])); ?>";
                console.log('Loading states for country:', country, 'URL:', url, 'Full URL with params:', url + '?country=' + encodeURIComponent(country));

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { country: country },
                    dataType: 'json',
                    cache: false,
                    success: function (res) {
                        console.log('States response received:', res, 'Type:', typeof res, 'Is Array:', Array.isArray(res));
                        $('#state').empty().append('<option value="">Select State</option>');
                        if (res && Array.isArray(res) && res.length > 0) {
                            $.each(res, function (index, value) {
                                if (value && value.trim() !== '') { // Only add non-null, non-empty values
                                    var selected = (selectedState && value == selectedState) ? 'selected' : '';
                                    $('#state').append('<option value="' + value + '" ' + selected + '>' + value + '</option>');
                                }
                            });
                            console.log('States populated successfully. Count:', res.length);
                            
                            // If state was selected, load cities
                            if (selectedState && selectedState !== '') {
                                loadCities(selectedState, '<?php echo e(request("city")); ?>');
                            }
                        } else {
                            console.warn('No states found for country:', country, 'Response:', res);
                            $('#state').html('<option value="">No states found</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error loading states:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status,
                            readyState: xhr.readyState
                        });
                        $('#state').html('<option value="">Error loading states</option>');
                        // Don't show alert, just log to console
                    }
                });
            }

            // Function to load cities
            function loadCities(state, selectedCity) {
                if (!state || state === '' || state === null) {
                    $('#city').html('<option value="">Select City</option>');
                    return;
                }
                
                $('#city').html('<option>Loading...</option>');

                var url = "<?php echo e(route('get-cities', ['code' => $user->code])); ?>";
                console.log('Loading cities for state:', state, 'URL:', url, 'Full URL with params:', url + '?state=' + encodeURIComponent(state));

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { state: state },
                    dataType: 'json',
                    cache: false,
                    success: function (res) {
                        console.log('Cities response received:', res, 'Type:', typeof res, 'Is Array:', Array.isArray(res));
                        $('#city').empty().append('<option value="">Select City</option>');
                        if (res && Array.isArray(res) && res.length > 0) {
                            $.each(res, function (index, value) {
                                if (value && value.trim() !== '') { // Only add non-null, non-empty values
                                    var selected = (selectedCity && value == selectedCity) ? 'selected' : '';
                                    $('#city').append('<option value="' + value + '" ' + selected + '>' + value + '</option>');
                                }
                            });
                            console.log('Cities populated successfully. Count:', res.length);
                        } else {
                            console.warn('No cities found for state:', state, 'Response:', res);
                            $('#city').html('<option value="">No cities found</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error loading cities:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status,
                            readyState: xhr.readyState
                        });
                        $('#city').html('<option value="">Error loading cities</option>');
                        // Don't show alert, just log to console
                    }
                });
            }

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

            // Country -> State
            $(document).on('change', '#country', function () {
                var country = $(this).val();
                console.log('Country changed to:', country, 'Type:', typeof country);
                if (country && country !== '') {
                    loadStates(country, null);
                } else {
                    $('#state').html('<option value="">Select State</option>');
                    $('#city').html('<option value="">Select City</option>');
                }
            });
            
            // Also trigger on page load if country is already selected
            $(document).ready(function() {
                var initialCountry = $('#country').val();
                if (initialCountry && initialCountry !== '') {
                    console.log('Initial country found:', initialCountry);
                    var initialState = '<?php echo e(request("state")); ?>';
                    loadStates(initialCountry, initialState);
                }
            });

            // State -> City
            $(document).on('change', '#state', function () {
                var state = $(this).val();
                console.log('State changed to:', state);
                if (state) {
                    loadCities(state, null);
                } else {
                    $('#city').html('<option value="">Select City</option>');
                }
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