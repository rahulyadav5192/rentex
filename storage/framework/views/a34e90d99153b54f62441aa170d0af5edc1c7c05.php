<?php $__env->startSection('content'); ?>
    <?php
        // Get main property image (thumbnail or first image)
        $mainImage = null;
        if (!empty($property->thumbnail) && !empty($property->thumbnail->image)) {
            $mainImage = fetch_file($property->thumbnail->image, 'upload/property/thumbnail/');
        } elseif ($property->propertyImages->count() > 0) {
            $firstImage = $property->propertyImages->first();
            $mainImage = fetch_file($firstImage->image, 'upload/property/image/');
        }
        if (empty($mainImage)) {
            $mainImage = asset('assets/images/default-image.png');
        }
        
        // Get all property images for gallery
        $allImages = collect();
        if (!empty($property->thumbnail) && !empty($property->thumbnail->image)) {
            $allImages->push([
                'image' => fetch_file($property->thumbnail->image, 'upload/property/thumbnail/'),
                'alt' => $property->name
            ]);
        }
        foreach ($property->propertyImages as $img) {
            $imgUrl = fetch_file($img->image, 'upload/property/image/');
            if (!empty($imgUrl)) {
                $allImages->push([
                    'image' => $imgUrl,
                    'alt' => $property->name . ' - Image ' . ($allImages->count() + 1)
                ]);
            }
        }
        
        // Calculate totals from units
        $totalBedrooms = $units->sum('bedroom');
        $totalKitchens = $units->sum('kitchen');
        $totalBathrooms = $units->sum('baths');
        
        // Property type badge
        $listingTypeText = '';
        $listingTypeBadge = '';
        if ($property->listing_type == 'rent') {
            $listingTypeText = __('For Lease');
            $listingTypeBadge = 'bg-blue-500/90 dark:bg-blue-600/90';
        } elseif ($property->listing_type == 'sell') {
            $listingTypeText = __('For Sale');
            $listingTypeBadge = 'bg-emerald-500/90 dark:bg-emerald-600/90';
        }
        
        // Property type
        $propertyTypeText = \App\Models\Property::$Type[$property->type] ?? __('Property');
        
        // Price display
        $priceDisplay = '';
        $priceLabel = '';
        if (!empty($property->price) && $property->price > 0) {
            if ($property->listing_type == 'rent') {
                $priceLabel = __('Rent Price');
                $priceDisplay = priceformat($property->price) . '/ ' . __('month');
            } else {
                $priceLabel = __('Sell Price');
                $priceDisplay = priceformat($property->price);
            }
        } else {
            $priceLabel = __('Price');
            $priceDisplay = '$0 / ' . __('negotiable');
        }
        
        // Full address
        $fullAddress = trim(implode(', ', array_filter([
            $property->address,
            $property->city,
            $property->state,
            $property->country,
            $property->zip_code
        ])));
        
        // Google Maps URL
        $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($fullAddress);
        
        // App name from settings
        $appName = !empty($settings['app_name']) ? $settings['app_name'] : 'PropManage';
    ?>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="margin-top: 110px;">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-text-sub-light dark:text-text-sub-dark mb-6 flex-wrap gap-2">
            <a class="hover:text-primary dark:hover:text-emerald-400 transition" href="<?php echo e(route('web.page', $user->code)); ?>"><?php echo e(__('Home')); ?></a>
            <span class="material-icons-outlined text-base">chevron_right</span>
            <a class="hover:text-primary dark:hover:text-emerald-400 transition" href="<?php echo e(route('property.home', $user->code)); ?>"><?php echo e(__('Properties')); ?></a>
            <span class="material-icons-outlined text-base">chevron_right</span>
            <span class="font-medium text-text-main-light dark:text-text-main-dark"><?php echo e(ucfirst($property->name)); ?></span>
                            </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Image Gallery -->
                <div class="relative group">
                    <div class="aspect-w-16 aspect-h-9 w-full overflow-hidden rounded-xl shadow-lg dark:shadow-slate-900/50">
                        <img id="main-property-image" 
                             alt="<?php echo e(ucfirst($property->name)); ?>" 
                             class="w-full h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700 ease-in-out" 
                             src="<?php echo e($mainImage); ?>"
                             onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
                        </div>
                    <div class="absolute top-4 left-4 flex gap-2 flex-wrap">
                        <?php if($property->listing_type): ?>
                            <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg"><?php echo e(__('Featured')); ?></span>
                        <?php endif; ?>
                        <?php if($listingTypeText): ?>
                            <span class="bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark text-xs font-semibold px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-secondary"></span> <?php echo e($listingTypeText); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <?php if($allImages->count() > 1): ?>
                        <div class="flex gap-4 mt-4 overflow-x-auto pb-2 scrollbar-hide">
                            <?php $__currentLoopData = $allImages->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button onclick="changeMainImage('<?php echo e($img['image']); ?>', this)" 
                                        class="thumbnail-btn relative flex-none w-24 h-16 rounded-lg overflow-hidden <?php echo e($index === 0 ? 'ring-2 ring-primary ring-offset-2 dark:ring-offset-gray-900 opacity-100' : 'opacity-70 hover:opacity-100'); ?> hover:ring-2 hover:ring-primary/50 transition-all">
                                    <img alt="<?php echo e($img['alt']); ?>" 
                                         class="w-full h-full object-cover" 
                                         src="<?php echo e($img['image']); ?>"
                                         onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($allImages->count() > 4): ?>
                                <div class="flex-none w-24 h-16 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-text-muted-light dark:text-text-muted-dark hover:bg-gray-300 dark:hover:bg-gray-600 transition cursor-pointer">
                                    <span class="text-xs font-semibold">+<?php echo e($allImages->count() - 4); ?> <?php echo e(__('Photos')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Property Overview -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                    <h2 class="text-xl font-display font-bold mb-4 text-text-main-light dark:text-text-main-dark"><?php echo e(__('Property Overview')); ?></h2>
                    <div class="text-text-sub-light dark:text-text-sub-dark leading-relaxed mb-6 prose dark:prose-invert max-w-none">
                        <?php echo $property->description ?? __('No description available.'); ?>

                                    </div>

                    <!-- Advantages -->
                    <h3 class="text-lg font-semibold mb-3 text-text-main-light dark:text-text-main-dark"><?php echo e(__('Why This Property Stands Out')); ?></h3>
                    <?php if($selectedAdvantages->count() > 0): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php $__currentLoopData = $selectedAdvantages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advantage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-2 text-text-main-light dark:text-text-main-dark">
                                    <span class="material-icons-outlined text-secondary">check_circle</span>
                                    <span><?php echo e($advantage->name); ?></span>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                    <?php else: ?>
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-6 border border-dashed border-gray-300 dark:border-gray-700 text-center">
                            <span class="material-icons-outlined text-4xl text-text-muted-light dark:text-text-muted-dark mb-2">star_border</span>
                            <p class="text-text-muted-light dark:text-text-muted-dark"><?php echo e(__('No specific advantages listed for this property yet.')); ?></p>
                                                </div>
                                                    <?php endif; ?>
                                            </div>

                <!-- Amenities -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                    <h2 class="text-xl font-display font-bold mb-4 text-text-main-light dark:text-text-main-dark"><?php echo e(__('Amenities')); ?></h2>
                    <?php if($selectedAmenities->count() > 0): ?>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                                        <?php $__currentLoopData = $selectedAmenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amenity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition">
                                                                    <?php if($amenity->image): ?>
                                        <img src="<?php echo e(fetch_file($amenity->image, 'upload/amenity/')); ?>" 
                                                                            alt="<?php echo e($amenity->name); ?>"
                                             class="w-16 h-16 object-cover rounded-lg mb-2"
                                             onerror="this.style.display='none';">
                                    <?php else: ?>
                                        <span class="material-icons-outlined text-4xl text-primary mb-2">check_circle_outline</span>
                                                                    <?php endif; ?>
                                    <span class="text-sm font-medium text-text-main-light dark:text-text-main-dark text-center"><?php echo e($amenity->name); ?></span>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php else: ?>
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-6 border border-dashed border-gray-300 dark:border-gray-700 text-center">
                            <span class="material-icons-outlined text-4xl text-text-muted-light dark:text-text-muted-dark mb-2">check_circle_outline</span>
                            <p class="text-text-muted-light dark:text-text-muted-dark"><?php echo e(__('No amenities selected for this property.')); ?></p>
                        </div>
                                                <?php endif; ?>
                                        </div>

                <!-- Location -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                    <h2 class="text-xl font-display font-bold mb-4 text-text-main-light dark:text-text-main-dark"><?php echo e(__('Location')); ?></h2>
                    <div class="flex items-start gap-3 mb-4">
                        <span class="material-icons-outlined text-primary mt-1">location_on</span>
                        <div>
                            <p class="text-text-main-light dark:text-text-main-dark font-medium"><?php echo e($fullAddress); ?></p>
                                            </div>
                                        </div>
                    <div class="h-64 bg-gray-200 dark:bg-gray-700 rounded-lg w-full overflow-hidden relative">
                        <img alt="<?php echo e(__('Map Preview')); ?>" 
                             class="w-full h-full object-cover opacity-80 dark:opacity-60 grayscale" 
                             src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo e(urlencode($fullAddress)); ?>&zoom=15&size=600x400&markers=color:red|<?php echo e(urlencode($fullAddress)); ?>&key=<?php echo e(env('GOOGLE_MAPS_API_KEY', '')); ?>"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'400\'%3E%3Crect fill=\'%23e5e7eb\' width=\'600\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%236b7280\' font-family=\'sans-serif\' font-size=\'16\'%3EMap Preview%3C/text%3E%3C/svg%3E';">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <a href="<?php echo e($googleMapsUrl); ?>" target="_blank" 
                               class="bg-white dark:bg-gray-800 text-primary px-4 py-2 rounded-lg shadow-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <?php echo e(__('View on Google Maps')); ?>

                            </a>
                                                </div>
                                            </div>
                                        </div>

                <!-- Property Unit Specification -->
                <?php if($units->count() > 0): ?>
                    <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                        <h2 class="text-xl font-display font-bold mb-6 text-text-main-light dark:text-text-main-dark"><?php echo e(__('Property Unit Specification')); ?></h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="group bg-gray-50 dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-sub-light dark:text-text-sub-dark font-medium"><?php echo e(__('Bedrooms')); ?></span>
                                    <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-2 rounded-full">
                                        <span class="material-icons-outlined text-xl">bed</span>
                                    </span>
                                </div>
                                <p class="text-3xl font-display font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors"><?php echo e($totalBedrooms); ?></p>
                                <p class="text-xs text-text-sub-light dark:text-text-sub-dark mt-1"><?php echo e(__('Total Rooms')); ?></p>
                            </div>
                            <div class="group bg-gray-50 dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-sub-light dark:text-text-sub-dark font-medium"><?php echo e(__('Kitchens')); ?></span>
                                    <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 p-2 rounded-full">
                                        <span class="material-icons-outlined text-xl">kitchen</span>
                                    </span>
                                </div>
                                <p class="text-3xl font-display font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors"><?php echo e($totalKitchens); ?></p>
                                <p class="text-xs text-text-sub-light dark:text-text-sub-dark mt-1"><?php echo e(__('Fully Equipped')); ?></p>
                                                                    </div>
                            <div class="group bg-gray-50 dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-sub-light dark:text-text-sub-dark font-medium"><?php echo e(__('Bathrooms')); ?></span>
                                    <span class="bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 p-2 rounded-full">
                                        <span class="material-icons-outlined text-xl">bathtub</span>
                                    </span>
                                                                </div>
                                <p class="text-3xl font-display font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors"><?php echo e($totalBathrooms); ?></p>
                                <p class="text-xs text-text-sub-light dark:text-text-sub-dark mt-1"><?php echo e(__('Luxury Fittings')); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <!-- Property Info Card -->
                    <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft-hover dark:shadow-none dark:border dark:border-border-dark">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-2xl font-display font-bold text-text-main-light dark:text-text-main-dark mb-1"><?php echo e(ucfirst($property->name)); ?></h1>
                                <div class="flex items-center text-sm text-text-sub-light dark:text-text-sub-dark">
                                    <span class="material-icons-outlined text-sm mr-1">place</span>
                                    <span><?php echo e($property->city ?? __('Location not specified')); ?></span>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-red-500 transition" aria-label="<?php echo e(__('Add to favorites')); ?>">
                                <span class="material-icons-outlined">favorite_border</span>
                            </button>
                                            </div>
                        
                        <!-- Price -->
                        <div class="my-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-text-sub-light dark:text-text-sub-dark uppercase tracking-wide"><?php echo e($priceLabel); ?></p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-primary"><?php echo e($priceDisplay); ?></span>
                            </div>
                        </div>
                        
                        <!-- Property Details -->
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div class="flex items-center gap-2 text-text-sub-light dark:text-text-sub-dark">
                                <span class="material-icons-outlined">home</span>
                                <span><?php echo e($propertyTypeText); ?></span>
                                    </div>
                            <?php if($property->created_at): ?>
                                <div class="flex items-center gap-2 text-text-sub-light dark:text-text-sub-dark">
                                    <span class="material-icons-outlined">calendar_today</span>
                                    <span><?php echo e(__('Built')); ?> <?php echo e($property->created_at->format('Y')); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex items-center gap-2 text-secondary">
                                <span class="material-icons-outlined">verified</span>
                                <span><?php echo e(__('Verified')); ?></span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="<?php echo e(route('contact.home', ['code' => $user->code, 'property_id' => \Crypt::encrypt($property->id)])); ?>" 
                               class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <span class="material-icons-outlined">mail_outline</span>
                                <?php echo e(__('Contact Owner')); ?>

                            </a>
                        </div>
                    </div>
                    
                    <!-- Owner/Manager Card -->
                    <div class="bg-card-light dark:bg-card-dark rounded-xl p-5 shadow-soft dark:shadow-none dark:border dark:border-border-dark flex items-center gap-4">
                        <div class="relative">
                            <?php
                                $ownerAvatar = !empty($user->avatar) ? fetch_file($user->avatar, 'upload/avatar/') : asset('assets/images/admin/user.png');
                            ?>
                            <img alt="<?php echo e(__('Owner Avatar')); ?>" 
                                 class="w-12 h-12 rounded-full object-cover" 
                                 src="<?php echo e($ownerAvatar); ?>"
                                 onerror="this.src='<?php echo e(asset('assets/images/admin/user.png')); ?>';">
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-secondary border-2 border-white dark:border-gray-800 rounded-full"></span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-text-main-light dark:text-text-main-dark"><?php echo e(__('Managed by')); ?></p>
                            <p class="text-xs text-text-sub-light dark:text-text-sub-dark"><?php echo e($appName); ?></p>
                        </div>
                        <button class="ml-auto text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 p-2 rounded-full transition" aria-label="<?php echo e(__('Chat')); ?>">
                            <span class="material-icons-outlined">chat</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .aspect-w-16 {
            position: relative;
            padding-bottom: 56.25%;
        }
        .aspect-w-16 > * {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>

    <script>
        function changeMainImage(imageUrl, buttonElement) {
            document.getElementById('main-property-image').src = imageUrl;
            // Update active state on thumbnails
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-primary', 'ring-offset-2', 'dark:ring-offset-gray-900');
                btn.classList.add('opacity-70');
            });
            if (buttonElement) {
                buttonElement.classList.add('ring-2', 'ring-primary', 'ring-offset-2', 'dark:ring-offset-gray-900');
                buttonElement.classList.remove('opacity-70');
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/detail.blade.php ENDPATH**/ ?>