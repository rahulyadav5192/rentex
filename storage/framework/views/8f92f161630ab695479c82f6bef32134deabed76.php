<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $thumbnail = !empty($property->thumbnail) && !empty($property->thumbnail->image) ? $property->thumbnail->image : '';
            $thumbnailUrl = !empty($thumbnail) ? fetch_file($thumbnail, 'upload/property/thumbnail/') : asset('assets/images/default-image.png');
            $listingType = !empty($property->listing_type) ? $property->listing_type : '';
            $price = !empty($property->price) ? $property->price : 0;
        ?>
        <div class="property-card bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-lg dark:shadow-slate-900/50 border border-slate-200 dark:border-slate-700 hover:shadow-xl dark:hover:shadow-slate-900/70 transition-all duration-300 hover:-translate-y-1">
            <a href="<?php echo e(route('property.detail', ['code' => $user->code, \Crypt::encrypt($property->id)])); ?>" class="block">
                <div class="relative h-56 overflow-hidden">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        src="<?php echo e($thumbnailUrl); ?>" 
                        alt="<?php echo e($property->name); ?>"
                        onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
                    <div class="absolute top-4 right-4">
                        <?php if($listingType == 'rent'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-500/90 dark:bg-purple-600/90 text-white text-xs font-semibold backdrop-blur-sm">
                                <?php echo e(__('Lease Property')); ?>

                            </span>
                        <?php elseif($listingType == 'sell'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-500/90 dark:bg-blue-600/90 text-white text-xs font-semibold backdrop-blur-sm">
                                <?php echo e(__('Own Property')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-5">
                    <div class="mb-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-medium">
                            <?php echo e(\App\Models\Property::$Type[$property->type] ?? __('Property')); ?>

                        </span>
                    </div>
                    <h5 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-1 hover:text-primary dark:hover:text-emerald-400 transition-colors">
                        <?php echo e(ucfirst($property->name)); ?>

                    </h5>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2">
                        <?php echo e(\Illuminate\Support\Str::limit(strip_tags($property->description ?? ''), 80, '...')); ?>

                    </p>
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="line-clamp-1"><?php echo e($property->address ?? __('No address')); ?></span>
                    </div>
                    <?php if($price > 0): ?>
                        <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <p class="text-lg font-bold text-slate-900 dark:text-white">
                                <?php if($listingType == 'rent'): ?>
                                    $<?php echo e(number_format($price)); ?>/<?php echo e(__('month')); ?>

                                <?php else: ?>
                                    $<?php echo e(number_format($price)); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </a>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full">
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-slate-400 dark:text-slate-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2"><?php echo e(__('No Properties Found')); ?></h3>
                <p class="text-slate-600 dark:text-slate-400"><?php echo e($noPropertiesMessage ?? __('Try adjusting your search filters.')); ?></p>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .property-card {
        background-color: white;
        border: 1px solid #e2e8f0;
    }
    .dark .property-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
    }
    .dark .property-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3) !important;
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Pagination -->
<?php if($properties->hasPages()): ?>
    <div class="mt-12 md:mt-16">
        <nav class="flex flex-col items-center gap-4">
            <ul class="flex flex-wrap items-center justify-center gap-2">
                <?php if($properties->onFirstPage()): ?>
                    <li>
                        <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?php echo e($properties->previousPageUrl()); ?>" 
                           class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>

                <?php $__currentLoopData = $properties->links()->elements[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_string($page)): ?>
                        <li>
                            <span class="px-4 py-2 text-slate-500 dark:text-slate-400"><?php echo e($page); ?></span>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo e($url); ?>" 
                               class="px-4 py-2 rounded-lg <?php echo e($page == $properties->currentPage() ? 'bg-primary text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary'); ?> transition-all shadow-md hover:shadow-lg">
                                <?php echo e($page); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($properties->hasMorePages()): ?>
                    <li>
                        <a href="<?php echo e($properties->nextPageUrl()); ?>" 
                           class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                <?php echo e(__('Showing')); ?> <?php echo e(($properties->currentPage() - 1) * $properties->perPage() + 1); ?> – 
                <?php echo e(min($properties->currentPage() * $properties->perPage(), $properties->total())); ?> 
                <?php echo e(__('of')); ?> <?php echo e($properties->total()); ?> <?php echo e(__('properties')); ?>

            </p>
        </nav>
    </div>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/propertybox.blade.php ENDPATH**/ ?>