<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-background-light dark:bg-background-dark">
        <!-- Hero Section -->
        <section class="relative py-16 md:py-24 lg:py-32 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-blue-500/5"></div>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                        <?php echo e(__('Our Blog')); ?>

                    </h1>
                    <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
                        <?php echo e(__('Stay updated with the latest insights, tips, and news about property management.')); ?>

                    </p>
                </div>
            </div>
        </section>

        <!-- Blog Posts Section -->
        <section class="py-12 md:py-16 lg:py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div id="blog-wrapper">
                    <?php echo $__env->make('theme.blogbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('click', '.mbp_pagination .page-link', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function() {
                    $('#blog-wrapper').html('<div class="text-center py-5 text-slate-900 dark:text-slate-100">Loading...</div>');
                },
                success: function(data) {
                    $('#blog-wrapper').html(data);
                    window.history.pushState(null, null, url);
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('theme.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/blog.blade.php ENDPATH**/ ?>