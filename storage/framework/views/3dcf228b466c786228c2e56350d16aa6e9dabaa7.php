<?php $__env->startSection('content'); ?>
    <?php
        $imageUrl = !empty($blog->image) ? fetch_file($blog->image, 'upload/blog/image/') : asset('assets/images/default-image.png');
        $relatedBlogs = \App\Models\Blog::where('parent_id', $user->id)
            ->where('id', '!=', $blog->id)
            ->where('enabled', 1)
            ->latest()
            ->take(3)
            ->get();
    ?>

    <article class="min-h-screen bg-background-light dark:bg-background-dark">
        <!-- Hero Image Section -->
        <div class="relative w-full h-[50vh] md:h-[60vh] lg:h-[70vh] overflow-hidden">
            <img src="<?php echo e($imageUrl); ?>" 
                 alt="<?php echo e($blog->title); ?>"
                 class="w-full h-full object-cover"
                 onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent"></div>
        </div>

        <!-- Content Section -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 md:-mt-32 relative z-10">
            <!-- Article Card -->
            <div class="blog-detail-card rounded-2xl md:rounded-3xl shadow-2xl overflow-hidden" style="background-color: white; border: 1px solid #e2e8f0;">
                <!-- Article Header -->
                <div class="px-6 md:px-8 lg:px-12 pt-8 md:pt-12 pb-6">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo e(dateformat($blog->created_at)); ?>

                        </span>
                        <?php if($blog->enabled == 1): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-sm font-medium">
                                <?php echo e(__('Published')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                        <?php echo e(ucfirst($blog->title)); ?>

                    </h1>
                </div>

                <!-- Article Image (Mobile) -->
                <div class="block md:hidden px-6 pb-6">
                    <img src="<?php echo e($imageUrl); ?>" 
                         alt="<?php echo e($blog->title); ?>"
                         class="w-full h-64 object-cover rounded-xl shadow-lg"
                         onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
                </div>

                <!-- Article Content -->
                <div class="px-6 md:px-8 lg:px-12 pb-8 md:pb-12">
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <div class="text-slate-700 dark:text-slate-300 leading-relaxed">
                            <?php echo $blog->content; ?>

                        </div>
                    </div>
                </div>

                <!-- Article Footer -->
                <div class="px-6 md:px-8 lg:px-12 py-6 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex flex-wrap items-center justify-end gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-slate-500 dark:text-slate-400"><?php echo e(__('Share')); ?>:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(request()->fullUrl())); ?>" 
                               target="_blank"
                               class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(request()->fullUrl())); ?>&text=<?php echo e(urlencode($blog->title)); ?>" 
                               target="_blank"
                               class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(urlencode(request()->fullUrl())); ?>&title=<?php echo e(urlencode($blog->title)); ?>" 
                               target="_blank"
                               class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-primary hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Blogs Section -->
            <?php if($relatedBlogs->count() > 0): ?>
                <div class="mt-12 md:mt-16">
                    <h2 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white mb-8">
                        <?php echo e(__('Related Posts')); ?>

                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $relatedBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedBlog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $relatedImageUrl = !empty($relatedBlog->image) ? fetch_file($relatedBlog->image, 'upload/blog/image/') : asset('assets/images/default-image.png');
                            ?>
                            <a href="<?php echo e(route('blog.detail', ['code' => $user->code, 'slug' => $relatedBlog->slug])); ?>" 
                               class="group blog-related-card rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1" style="background-color: white; border: 1px solid #e2e8f0;">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="<?php echo e($relatedImageUrl); ?>" 
                                         alt="<?php echo e($relatedBlog->title); ?>"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         onerror="this.src='<?php echo e(asset('assets/images/default-image.png')); ?>';">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span><?php echo e(dateformat($relatedBlog->created_at)); ?></span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-primary dark:group-hover:text-emerald-400 transition-colors">
                                        <?php echo e(\Illuminate\Support\Str::limit($relatedBlog->title, 60)); ?>

                                    </h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                        <?php echo e(\Illuminate\Support\Str::limit(strip_tags($relatedBlog->content), 100)); ?>

                                    </p>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </article>

    <style>
        /* Prose styling for blog content */
        .prose {
            color: inherit;
        }
        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.75;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: inherit;
        }
        .prose h2 {
            font-size: 1.875rem;
        }
        .prose h3 {
            font-size: 1.5rem;
        }
        .prose ul, .prose ol {
            margin: 1.5rem 0;
            padding-left: 1.5rem;
        }
        .prose li {
            margin: 0.5rem 0;
        }
        .prose a {
            color: #10B981;
            text-decoration: underline;
        }
        .dark .prose a {
            color: #34D399;
        }
        .prose a:hover {
            color: #059669;
        }
        .dark .prose a:hover {
            color: #10B981;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }
        .prose blockquote {
            border-left: 4px solid #10B981;
            padding-left: 1.5rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6B7280;
        }
        .dark .prose blockquote {
            border-left-color: #34D399;
            color: #9CA3AF;
        }
        .prose code {
            background-color: #F3F4F6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
            color: #1F2937;
        }
        .dark .prose code {
            background-color: #374151;
            color: #E5E7EB;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #111827;
        }
        .dark .prose h1, .dark .prose h2, .dark .prose h3, .dark .prose h4, .dark .prose h5, .dark .prose h6 {
            color: #F9FAFB;
        }
        .prose p, .prose li {
            color: #374151;
        }
        .dark .prose p, .dark .prose li {
            color: #D1D5DB;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Force dark mode for blog detail cards */
        .dark .blog-detail-card {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }
        .dark .blog-related-card {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
        }
        .dark .blog-related-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3) !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/blog-detail.blade.php ENDPATH**/ ?>