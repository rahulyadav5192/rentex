<?php if($blogs->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $imageUrl = !empty($blog->image) ? fetch_file($blog->image, 'upload/blog/image/') : asset('assets/images/default-image.png');
            ?>
            <article class="group blog-card rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2" style="background-color: white; border: 1px solid #e2e8f0;">
                <a href="<?php echo e(route('blog.detail', ['code' => $user->code, 'slug' => $blog->slug])); ?>" class="block">
                    <div class="relative h-56 md:h-64 overflow-hidden">
                        <img src="<?php echo e($imageUrl); ?>" 
                             alt="<?php echo e($blog->title); ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute top-4 right-4">
                            <?php if($blog->enabled == 1): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/90 dark:bg-emerald-600/90 text-white text-xs font-semibold backdrop-blur-sm">
                                    <?php echo e(__('Published')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span><?php echo e(dateformat($blog->created_at)); ?></span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 line-clamp-2 group-hover:text-primary dark:group-hover:text-emerald-400 transition-colors">
                            <?php echo e($blog->title); ?>

                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                            <?php echo e(\Illuminate\Support\Str::limit(strip_tags($blog->content), 120, '...')); ?>

                        </p>
                        <div class="mt-4 flex items-center text-primary dark:text-emerald-400 font-semibold text-sm group-hover:gap-2 transition-all">
                            <span><?php echo e(__('Read More')); ?></span>
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <?php if($blogs->hasPages()): ?>
        <div class="mt-12 md:mt-16">
            <nav class="flex flex-col items-center gap-4">
                <ul class="flex flex-wrap items-center justify-center gap-2">
                    <?php if($blogs->onFirstPage()): ?>
                        <li>
                            <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo e($blogs->previousPageUrl()); ?>" 
                               class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php $__currentLoopData = $blogs->links()->elements[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_string($page)): ?>
                            <li>
                                <span class="px-4 py-2 text-slate-500 dark:text-slate-400"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?php echo e($url); ?>" 
                                   class="px-4 py-2 rounded-lg <?php echo e($page == $blogs->currentPage() ? 'bg-primary text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary'); ?> transition-all shadow-md hover:shadow-lg">
                                    <?php echo e($page); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($blogs->hasMorePages()): ?>
                        <li>
                            <a href="<?php echo e($blogs->nextPageUrl()); ?>" 
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
                    <?php echo e(__('Showing')); ?> <?php echo e(($blogs->currentPage() - 1) * $blogs->perPage() + 1); ?> – 
                    <?php echo e(min($blogs->currentPage() * $blogs->perPage(), $blogs->total())); ?> 
                    <?php echo e(__('of')); ?> <?php echo e($blogs->total()); ?> <?php echo e(__('posts')); ?>

                </p>
            </nav>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="text-center py-16 md:py-24">
        <div class="max-w-md mx-auto">
            <svg class="w-24 h-24 mx-auto text-slate-400 dark:text-slate-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2"><?php echo e(__('No Blog Posts Yet')); ?></h3>
            <p class="text-slate-600 dark:text-slate-400"><?php echo e(__('Check back soon for new content!')); ?></p>
        </div>
    </div>
<?php endif; ?>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    /* Force dark mode for blog cards */
    .dark .blog-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
    }
    .dark .blog-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3) !important;
    }
</style>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/blogbox.blade.php ENDPATH**/ ?>