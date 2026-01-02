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
    ?>

    <!-- Properties Header & Filter Section -->
    <div class="bg-background-light dark:bg-background-dark pt-32 md:pt-36 pb-6" style="padding-top: 110px !important;">
        <div class="w-full max-w-7xl mx-auto mb-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-semibold text-text-main-light dark:text-text-main-dark mb-3 tracking-tight">
                <?php echo e(!empty($Section_3_content_value['sec3_title']) ? $Section_3_content_value['sec3_title'] : __('Explore Available Properties Instantly')); ?>

            </h1>
            <p class="text-lg text-text-sub-light dark:text-text-sub-dark max-w-2xl font-light">
                <?php echo e(!empty($Section_3_content_value['sec3_sub_title']) ? $Section_3_content_value['sec3_sub_title'] : __('Your complete property overview with photos, amenities, and key details.')); ?>

            </p>
        </div>

        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-card-light dark:bg-card-dark rounded-xl shadow-soft dark:shadow-none dark:border dark:border-border-dark p-6 md:p-8 transition-all duration-300">
                <?php echo e(Form::open(['route' => ['search.filter', 'code' => $user->code], 'method' => 'GET', 'id' => 'package_filter', 'class' => 'flex flex-col xl:flex-row gap-6 items-end'])); ?>

                
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
                            <option disabled selected value=""><?php echo e(__('Select Country')); ?></option>
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
            $('#country').on('change', function () {
                var country = $(this).val();
                $('#state').html('<option>Loading...</option>');
                $('#city').html('<option value="">Select City</option>'); // Reset city

                $.ajax({
                    url: "<?php echo e(route('get-states', ['code' => $user->code])); ?>",
                    type: 'GET',
                    data: { country: country },
                    success: function (res) {
                        $('#state').empty().append('<option value="">Select State</option>');
                        $.each(res, function (index, value) {
                            $('#state').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                    error: function () {
                        alert('Failed to load states.');
                    }
                });
            });

            // State -> City
            $('#state').on('change', function () {
                var state = $(this).val();
                $('#city').html('<option>Loading...</option>');

                $.ajax({
                     url: "<?php echo e(route('get-cities', ['code' => $user->code])); ?>",
                    type: 'GET',
                    data: { state: state },
                    success: function (res) {
                        $('#city').empty().append('<option value="">Select City</option>');
                        $.each(res, function (index, value) {
                            $('#city').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                    error: function () {
                        alert('Failed to load cities.');
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
                    },
                    error: function() {
                        alert('Failed to reset.');
                    }
                });
            });


        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/property.blade.php ENDPATH**/ ?>