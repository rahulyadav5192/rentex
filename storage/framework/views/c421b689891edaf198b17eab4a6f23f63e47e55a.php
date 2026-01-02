<?php
    if (!empty($user)) {
        \App::setLocale($user->lang);
    }
    $routeName = \Request::route()->getName();
?>

<!DOCTYPE html>
<html class="scroll-smooth" dir="ltr" lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="<?php echo e(!empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(!empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME')); ?> </title>

    <meta name="title" content="<?php echo e($settings['meta_seo_title']); ?>">
    <meta name="keywords" content="<?php echo e($settings['meta_seo_keyword']); ?>">
    <meta name="description" content="<?php echo e($settings['meta_seo_description']); ?>">


    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($settings['meta_seo_title']); ?>">
    <meta property="og:description" content="<?php echo e($settings['meta_seo_description']); ?>">
    <meta property="og:image" content="<?php echo e(asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image']); ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($settings['meta_seo_title']); ?>">
    <meta property="twitter:description" content="<?php echo e($settings['meta_seo_description']); ?>">
    <meta property="twitter:image"
        content="<?php echo e(asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image']); ?>">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#F97316",
                        "primary-dark": "#0d9488",
                        secondary: "#1E293B",
                        accent: "#10B981",
                        "background-light": "#F3F4F6",
                        "background-dark": "#0F172A",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1F2937",
                        "text-main-light": "#1F2937",
                        "text-main-dark": "#F3F4F6",
                        "text-muted-light": "#6B7280",
                        "text-muted-dark": "#9CA3AF",
                        "text-light": "#1e293b",
                        "text-dark": "#e2e8f0",
                        "muted-light": "#64748b",
                        "muted-dark": "#94a3b8",
                        "card-light": "#FFFFFF",
                        "card-dark": "#1E293B",
                        "text-sub-light": "#64748B",
                        "text-sub-dark": "#94A3B8",
                        "primary-hover": "#1e293b",
                        "border-light": "#e2e8f0",
                        "border-dark": "#334155",
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                        display: ["Poppins", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                        'xl': "1rem",
                        '2xl': "1.5rem",
                        '3xl': "2rem",
                        '4xl': "2rem",
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'soft-hover': '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                        'glow': '0 0 20px -5px rgba(249, 115, 22, 0.3)',
                    }
                },
            },
        };
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    
    <!-- css file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/jquery-ui.min.css')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/ace-responsive-menu.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/menu.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/flaticon.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/bootstrap-select.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/slider.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/style.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link" />


    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/notifier.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>" />

    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/ud-custom-spacing.css')); ?>">

    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/web/css/responsive.css')); ?>">
    <!-- Title -->
    <!-- Favicon -->
    <?php
        // Check Section 9 for favicon first, then fall back to default
        $faviconUrl = asset('images/favicon.ico'); // Default fallback
        $section9 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 9')->first();
        
        if ($section9 && !empty($section9->content_value)) {
            $section9_content = json_decode($section9->content_value, true);
            $favicon_path = !empty($section9_content['favicon_path']) ? $section9_content['favicon_path'] : '';
            
            if (!empty($favicon_path)) {
                $faviconUrl = fetch_file(basename($favicon_path), 'upload/favicon/');
                // If fetch_file returns empty, use default
                if (empty($faviconUrl)) {
                    $faviconUrl = asset('images/favicon.ico');
                }
            }
        }
        
        // Final fallback
        if (empty($faviconUrl)) {
            $faviconUrl = asset('images/favicon.ico');
        }
    ?>
    <link href="<?php echo e($faviconUrl); ?>" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="<?php echo e($faviconUrl); ?>" sizes="128x128" rel="shortcut icon" />
    <!-- Apple Touch Icon -->
    <link href="<?php echo e($faviconUrl); ?>" sizes="60x60" rel="apple-touch-icon">
    <link href="<?php echo e($faviconUrl); ?>" sizes="72x72" rel="apple-touch-icon">
    <link href="<?php echo e($faviconUrl); ?>" sizes="114x114" rel="apple-touch-icon">
    <link href="<?php echo e($faviconUrl); ?>" sizes="180x180" rel="apple-touch-icon">


    <?php echo $__env->yieldPushContent('css-page'); ?>


    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
        h1, h2, h3, h4, h5, h6, .font-display { 
            font-family: 'Poppins', sans-serif; 
        }
        
        /* Dark mode initialization */
        html {
            scroll-behavior: smooth;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #1d6061 0%, #154c4d 100%);
        }
        .circle-pattern {
            background-image: repeating-radial-gradient( circle at 100% 50%, transparent 0, transparent 20px, rgba(255,255,255,0.03) 21px, rgba(255,255,255,0.03) 40px );
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #d1fae5 0%, #e0f2fe 100%);
        }
        .dark .gradient-bg {
            background: linear-gradient(135deg, #064e3b 0%, #0c4a6e 100%);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .glass-card {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        /* Custom Select Styles */
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23334155' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
        .dark .custom-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        }
    </style>
    
    <script>
        // Theme toggle logic - Initialize on page load
        (function() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
        
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>

    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">



</head>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/rentex/resources/views/theme/head.blade.php ENDPATH**/ ?>