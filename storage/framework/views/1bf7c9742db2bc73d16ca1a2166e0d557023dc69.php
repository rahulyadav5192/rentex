<?php
    $settings = settings();
    $user = \App\Models\User::find(1);
    \App::setLocale($user->lang);
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo e(!empty($settings['meta_seo_description']) ? $settings['meta_seo_description'] : 'SaasoX - saas & software HTML Template'); ?>">
    <meta name="author" content="<?php echo e(!empty($settings['app_name']) ? $settings['app_name'] : 'Themeservices'); ?>">
    <!-- Favicon Icon -->
    <link rel="icon" href="<?php echo e(!empty($settings['company_favicon']) ? fetch_file($settings['company_favicon'], 'upload/logo/') : asset('landing/assets/img/favicon.png')); ?>">
    <!-- Site Title -->
    <title><?php echo e(!empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME')); ?> - <?php echo $__env->yieldContent('page-title', 'Home'); ?></title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('landing/assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/assets/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/assets/css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/assets/css/odometer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/assets/css/slick.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('landing/assets/css/style.css')); ?>">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <!-- Start Preloader -->
    <div class="cs_preloader cs_white_bg">
        <div class="cs_preloader_in position-relative">
            <span></span>
        </div>
    </div>
    <!-- End Preloader -->
    
    <?php echo $__env->make('landing.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->yieldContent('content'); ?>
    
    <?php echo $__env->make('landing.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Script -->
    <script src="<?php echo e(asset('landing/assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/assets/js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/assets/js/jquery.slick.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/assets/js/isotope.pkgd.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/assets/js/odometer.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/assets/js/main.js')); ?>"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/landing/layout.blade.php ENDPATH**/ ?>