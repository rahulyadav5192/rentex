@extends('theme.main')
@section('content')

@php
    // Get all sections
    $Section_0 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 0')->first();
    $Section_0_content_value = !empty($Section_0->content_value) ? json_decode($Section_0->content_value, true) : [];
    
    $Section_1 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 1')->first();
    $Section_1_content_value = !empty($Section_1->content_value) ? json_decode($Section_1->content_value, true) : [];
    
    $Section_2 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 2')->first();
    $Section_2_content_value = !empty($Section_2->content_value) ? json_decode($Section_2->content_value, true) : [];
    
    $Section_3 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 3')->first();
    $Section_3_content_value = !empty($Section_3->content_value) ? json_decode($Section_3->content_value, true) : [];
    
    $Section_4 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 4')->first();
    $Section_4_content_value = !empty($Section_4->content_value) ? json_decode($Section_4->content_value, true) : [];
    
    $Section_5 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 5')->first();
    $Section_5_content_value = !empty($Section_5->content_value) ? json_decode($Section_5->content_value, true) : [];
    
    $Section_6 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 6')->first();
    $Section_6_content_value = !empty($Section_6->content_value) ? json_decode($Section_6->content_value, true) : [];
    
    $Section_7 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 7')->first();
    $Section_7_content_value = !empty($Section_7->content_value) ? json_decode($Section_7->content_value, true) : [];
    
    // Get logo for prompt container
    $logoUrl1 = asset('logo.png');
    $section9 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 9')->first();
    if ($section9 && !empty($section9->content_value)) {
        $section9_content = json_decode($section9->content_value, true);
        $logo_path = !empty($section9_content['logo_path']) ? $section9_content['logo_path'] : '';
        if (!empty($logo_path)) {
            $logoUrl1 = fetch_file(basename($logo_path), 'upload/logo/');
        }
    }
    if (empty($logoUrl1)) {
        $logoUrl1 = asset('logo.png');
    }
    
    // Get banner image for prompt container
    $bannerImageUrl = null;
    if (!empty($Section_0_content_value['banner_image1_path'])) {
        $bannerImageUrl = fetch_file(basename($Section_0_content_value['banner_image1_path']), 'upload/fronthomepage/');
    }
    
    $appName = !empty($settings['app_name']) ? $settings['app_name'] : 'Rentex';
    
    // Get testimonials
    $testimonials = [];
    if (!empty($Section_7_content_value)) {
        foreach ($Section_7_content_value as $key => $value) {
            if (\Illuminate\Support\Str::startsWith($key, 'Sec7_box') && \Illuminate\Support\Str::endsWith($key, '_Enabled') && $value === 'active') {
                $boxNumber = str_replace(['Sec7_box', '_Enabled'], '', $key);
                $testimonials[] = $boxNumber;
            }
        }
    }
@endphp

<section class="hero-section tw-relative tw-flex tw-min-h-[100vh] tw-w-full tw-max-w-[100vw] tw-flex-col tw-overflow-hidden" id="hero-section" style="background-image: url('{{ asset('theme-new/assets/images/background/dots-dark.svg') }}'); background-position: center; background-repeat: repeat; background-size: 40px 40px; margin-top: 80px;">
    <!-- video container -->
    <div class="tw-fixed tw-bg-[#000000af] dark:tw-bg-[#80808085] tw-top-0 tw-left-1/2 tw--translate-x-1/2 tw-z-20 tw-transition-opacity tw-duration-300 tw-scale-0 tw-opacity-0 tw-p-2 tw-w-full tw-h-full tw-flex tw-place-content-center tw-place-items-center" id="video-container-bg">
        <div class="tw-max-w-[80vw] max-lg:tw-max-w-full max-lg:tw-w-full tw-scale-0 tw-transition-transform tw-duration-500 tw-p-6 tw-rounded-xl max-lg:tw-px-2 tw-w-full tw-gap-2 tw-shadow-md tw-h-[90vh] max-lg:tw-h-auto max-lg:tw-min-h-[400px] tw-bg-white dark:tw-bg-[#16171A] tw-max-h-full" id="video-container">
            <div class="tw-w-full tw-flex">
                <button type="button" onclick="closeVideo()" class="tw-ml-auto tw-text-xl" title="close">
                    <i class="bi bi-x-circle-fill"></i>
                </button>
            </div>
            <div class="tw-flex tw-w-full tw-rounded-xl tw-px-[5%] max-md:tw-px-2 tw-min-h-[300px] tw-max-h-[90%] tw-h-full">
                <div class="tw-relative tw-bg-black tw-min-w-full tw-min-h-full tw-overflow-clip tw-rounded-md">
                    <iframe class="tw-absolute tw-top-[50%] tw--translate-y-[50%] tw-left-[50%] tw--translate-x-[50%] tw-w-full tw-h-full" src="https://www.youtube.com/embed/kT8JyzNE-dI?si=krS8zHVJy4JzSaEJ&amp;controls=0&rel=0&showinfo=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-bg-gradient tw-relative tw-flex tw-h-full tw-min-h-[100vh] tw-w-full tw-flex-col tw-place-content-center tw-gap-6 tw-p-[5%] max-xl:tw-place-items-center max-lg:tw-p-4">
        <!-- Moving bubbles -->
        <div class="purple-bg-grad reveal-up tw-absolute tw-left-1/2 tw--translate-1/2 tw-top-[10%] tw-h-[120px] tw-w-[120px]" style="animation-duration: 6s; animation-delay: 0s;"></div>
        <div class="purple-bg-grad tw-absolute tw-left-[20%] tw-top-[30%] tw-h-[80px] tw-w-[80px]" style="animation-duration: 5s; animation-delay: 1s;"></div>
        <div class="purple-bg-grad tw-absolute tw-right-[15%] tw-top-[50%] tw-h-[100px] tw-w-[100px]" style="animation-duration: 7s; animation-delay: 2s;"></div>
        <div class="purple-bg-grad tw-absolute tw-left-[10%] tw-bottom-[20%] tw-h-[90px] tw-w-[90px]" style="animation-duration: 4.5s; animation-delay: 0.5s;"></div>
        <div class="purple-bg-grad tw-absolute tw-right-[25%] tw-bottom-[30%] tw-h-[70px] tw-w-[70px]" style="animation-duration: 6.5s; animation-delay: 1.5s;"></div>

        <div class="tw-flex tw-flex-col tw-min-h-[60vh] tw-place-content-center tw-items-center">
            @php
                $fullTitle = $Section_0_content_value['title'] ?? 'Property Management';
                // Split title by common delimiters: | or - or newline
                $titleParts = [];
                if (strpos($fullTitle, '|') !== false) {
                    $titleParts = explode('|', $fullTitle, 2);
                } elseif (strpos($fullTitle, ' - ') !== false) {
                    $titleParts = explode(' - ', $fullTitle, 2);
                } elseif (strpos($fullTitle, "\n") !== false) {
                    $titleParts = explode("\n", $fullTitle, 2);
                } else {
                    // If no delimiter, try to split by middle space
                    $words = explode(' ', $fullTitle);
                    $wordCount = count($words);
                    if ($wordCount > 1) {
                        $midPoint = ceil($wordCount / 2);
                        $titleParts[0] = implode(' ', array_slice($words, 0, $midPoint));
                        $titleParts[1] = implode(' ', array_slice($words, $midPoint));
                    } else {
                        // Single word, show on first line only
                        $titleParts[0] = $fullTitle;
                        $titleParts[1] = '';
                    }
                }
                $titlePart1 = trim($titleParts[0] ?? $fullTitle);
                $titlePart2 = trim($titleParts[1] ?? '');
            @endphp
            <h2 class="reveal-up tw-text-center tw-text-7xl tw-font-semibold tw-uppercase tw-leading-[90px] max-lg:tw-text-4xl max-md:tw-leading-snug">
                <span class="">{{ $titlePart1 }}</span>
                @if (!empty($titlePart2))
                    <br />
                    <span class="tw-font-thin tw-font-serif">{{ $titlePart2 }}</span>
                @endif
            </h2>
            <div class="reveal-up tw-mt-8 tw-max-w-[450px] tw-text-lg max-lg:tw-text-base tw-p-2 tw-text-center tw-text-gray-800 dark:tw-text-white max-lg:tw-max-w-full">
                {{ $Section_0_content_value['sub_title'] ?? 'Experience the most extensive and thorough real-estate management platform. Streamline your property workflow, from tenant screening to maintenance requests.' }}
            </div>

            <div class="reveal-up tw-mt-10 max-md:tw-flex-col tw-flex tw-place-items-center tw-gap-4">
                <a href="{{ route('property.home', ['code' => $user->code]) }}">
                <button class="btn !tw-w-[170px] max-lg:!tw-w-[160px] !tw-rounded-xl !tw-py-4 max-lg:!tw-py-2 tw-flex tw-gap-2 tw-group !tw-bg-transparent !tw-text-black dark:!tw-text-white tw-transition-colors tw-duration-[0.3s] tw-border-[1px] tw-border-black dark:tw-border-white">
                    <div class="tw-relative tw-flex tw-place-items-center tw-place-content-center tw-w-6 tw-h-6">
                        <div class="tw-absolute tw-inset-0 tw-top-0 tw-left-0 tw-scale-0 tw-duration-300 group-hover:tw-scale-100 tw-border-2 tw-border-gray-600 dark:tw-border-gray-200 tw-rounded-full tw-w-full tw-h-full"></div>
                        <span class="bi bi-play-circle-fill"></span>
                    </div>
                    <span>{{ __('Properties') }}</span>
                </button>
                </a>

                <a class="btn tw-group max-lg:!tw-w-[160px] tw-flex tw-gap-2 tw-shadow-lg !tw-w-[170px] !tw-rounded-xl !tw-py-4 max-lg:!tw-py-2 tw-transition-transform tw-duration-[0.3s] hover:tw-scale-x-[1.03]" href="{{ !empty($Section_0_content_value['btn_link']) ? $Section_0_content_value['btn_link'] : route('contact.home', ['code' => $user->code]) }}">
                    <span>{{ !empty($Section_0_content_value['btn_name']) ? $Section_0_content_value['btn_name'] : __('Contact Us') }}</span>
                    <i class="bi bi-arrow-right group-hover:tw-translate-x-1 tw-duration-300"></i>
                </a>
            </div>
        </div>

        <!-- prompt container -->
        <div class="reveal-up tw-relative tw-mt-8 tw-flex tw-w-full tw-place-content-center tw-place-items-center" id="dashboard-container">
            <div class="purple-bg-grad reveal-up tw-absolute tw-left-1/2 tw--translate-x-1/2 tw-top-[5%] tw-h-[200px] tw-w-[200px]"></div>

            <div class="tw-relative tw-max-w-[80%] tw-bg-white dark:tw-bg-black tw-border-[1px] dark:tw-border-[#36393c] lg:tw-w-[1024px] lg:tw-h-[650px] tw-flex tw-shadow-xl max-lg:tw-h-[450px] max-lg:tw-w-full tw-overflow-hidden tw-min-w-[320px] md:tw-w-full tw-min-h-[450px] tw-rounded-xl tw-bg-transparent max-md:tw-max-w-full" id="dashboard" style="transform: perspective(1200px) translateX(0px) translateY(0px) scale(1) rotate(0deg) rotateX(0deg);">
                @if ($bannerImageUrl)
                    <img src="{{ $bannerImageUrl }}" alt="Banner" class="tw-w-full tw-h-full tw-object-cover tw-rounded-xl">
                @else
                    <div class="tw-w-full tw-h-full tw-bg-gray-200 dark:tw-bg-gray-800 tw-rounded-xl tw-flex tw-items-center tw-justify-center">
                        <span class="tw-text-gray-400 dark:tw-text-gray-600">{{ __('Banner Image') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if (empty($Section_1_content_value['section_enabled']) || $Section_1_content_value['section_enabled'] == 'active')
<section class="tw-relative tw-flex tw-w-full tw-max-w-[100vw] tw-flex-col tw-place-content-center tw-place-items-center tw-overflow-hidden tw-p-8">
    <h2 class="reveal-up tw-text-3xl max-md:tw-text-xl">
        {{ $Section_1_content_value['Sec1_title'] ?? __('Trusted Features') }}
    </h2>
    <div class="reveal-up carousel-container">
        <div class="carousel lg:w-place-content-center tw-mt-10 tw-flex tw-w-full tw-gap-5 max-md:tw-gap-2">
            @for ($is4 = 1; $is4 <= 4; $is4++)
                @if (!empty($Section_1_content_value['Sec1_box' . $is4 . '_enabled']) && $Section_1_content_value['Sec1_box' . $is4 . '_enabled'] == 'active')
                    <div class="carousel-img tw-h-[30px] tw-w-[150px]">
                        @if (!empty($Section_1_content_value['Sec1_box' . $is4 . '_image_path']))
                            <img src="{{ fetch_file(basename($Section_1_content_value['Sec1_box' . $is4 . '_image_path']), 'upload/fronthomepage/') }}" alt="{{ $Section_1_content_value['Sec1_box' . $is4 . '_title'] ?? '' }}" class="tw-h-full tw-w-full tw-object-contain tw-grayscale tw-transition-colors hover:tw-grayscale-0" onerror="this.style.display='none';">
                        @endif
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>
@endif

@if (empty($Section_4_content_value['section_enabled']) || $Section_4_content_value['section_enabled'] == 'active')
<section class="tw-relative tw-flex tw-w-full tw-min-h-[100vh] max-lg:tw-min-h-[80vh] tw-flex-col tw-place-content-center tw-place-items-center tw-overflow-hidden">
    <div class="tw-w-full tw-place-content-center tw-items-center tw-flex tw-flex-col tw-max-w-[900px] tw-gap-4 tw-p-4">
        <div class="purple-bg-grad reveal-up tw-absolute tw-right-[20%] tw-top-[20%] tw-h-[200px] tw-w-[200px]"></div>
        <h2 class="reveal-up tw-text-6xl max-lg:tw-text-4xl tw-text-center tw-leading-normal tw-uppercase">
            <span class="tw-font-semibold">{{ $Section_4_content_value['Sec4_title'] ?? __('Build Your Property Portfolio') }}</span>
            <br>
            <span class="tw-font-serif">{{ __('With Our Platform') }}</span>
        </h2>
        <p class="reveal-up tw-mt-8 tw-max-w-[650px] tw-text-gray-900 dark:tw-text-gray-200 tw-text-center max-md:tw-text-sm">
            {{ $Section_4_content_value['Sec4_info'] ?? __('Our powerful platform simplifies property management, offering advanced capabilities in tenant management, billing automation, and maintenance tracking.') }}
        </p>
        <div class="reveal-up tw-flex tw-mt-8">
            <a href="{{ route('property.home', ['code' => $user->code]) }}" target="_blank" rel="noopener" class="tw-shadow-md hover:tw-shadow-xl dark:tw-shadow-gray-800 tw-transition-all tw-duration-300 tw-border-[1px] tw-p-3 tw-px-4 tw-border-black dark:tw-border-white tw-rounded-md">
                {{ __('Explore Properties') }}
            </a>
        </div>
    </div>
</section>
@endif

@if (empty($Section_1_content_value['section_enabled']) || $Section_1_content_value['section_enabled'] == 'active')
<section class="tw-relative tw-flex tw-max-w-[100vw] tw-flex-col tw-place-content-center tw-place-items-center tw-overflow-hidden">
    <div class="tw-mt-8 tw-flex tw-flex-col tw-w-full tw-h-full tw-place-items-center tw-gap-5">
        <div class="reveal-up tw-mt-5 tw-flex tw-flex-col tw-gap-3 tw-text-center">
            <h2 class="tw-text-6xl tw-font-medium max-md:tw-text-3xl tw-p-2">
                {{ $Section_1_content_value['Sec1_title'] ?? __('Experience All The Benefits') }}
            </h2>
        </div>
        <div class="tw-mt-6 tw-flex tw-flex-col tw-max-w-[1150px] max-lg:tw-max-w-full tw-h-full tw-p-4 max-lg:tw-place-content-center tw-gap-8">
            <div class="max-xl:tw-flex max-xl:tw-flex-col tw-place-items-center tw-grid tw-grid-cols-3 tw-gap-8 tw-place-content-center tw-auto-rows-auto">
                @for ($is4 = 1; $is4 <= 4; $is4++)
                    @if (!empty($Section_1_content_value['Sec1_box' . $is4 . '_enabled']) && $Section_1_content_value['Sec1_box' . $is4 . '_enabled'] == 'active')
                        <div class="reveal-up tw-w-[350px] tw-h-[540px] tw-flex max-md:tw-w-full">
                            <a href="{{ route('property.home', ['code' => $user->code]) }}" class="tw-relative tw-p-10 tw-transition-all tw-duration-300 tw-group/card tw-gap-5 tw-flex tw-flex-col tw-w-full tw-h-full tw-bg-[#f2f3f4] dark:tw-bg-[#080808] tw-rounded-3xl hover:tw-scale-[1.02]">
                                <div class="tw-w-full tw-flex tw-place-contet-center tw-min-h-[180px] tw-h-[180px] tw-rounded-xl tw-overflow-hidden">
                                    @if (!empty($Section_1_content_value['Sec1_box' . $is4 . '_image_path']))
                                        <img src="{{ fetch_file(basename($Section_1_content_value['Sec1_box' . $is4 . '_image_path']), 'upload/fronthomepage/') }}" class="tw-w-full tw-h-auto tw-object-contain" alt="{{ $Section_1_content_value['Sec1_box' . $is4 . '_title'] ?? '' }}" onerror="this.style.display='none';">
                                    @endif
                                </div>
                                <h2 class="tw-text-3xl max-md:tw-text-2xl tw-font-medium">{{ $Section_1_content_value['Sec1_box' . $is4 . '_title'] ?? '' }}</h2>
                                <p class="tw-text-base tw-leading-normal tw-text-gray-800 dark:tw-text-gray-200">
                                    {{ $Section_1_content_value['Sec1_box' . $is4 . '_info'] ?? '' }}
                                </p>
                                <div class="tw-flex tw-items-center tw-gap-2 tw-mt-auto">
                                    <span>{{ __('Learn more') }}</span>
                                    <i class="bi bi-arrow-right tw-transform tw-transition-transform tw-duration-300 group-hover/card:tw-translate-x-2"></i>
                                </div>
                            </a>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>
@endif

@if (empty($Section_2_content_value['section_enabled']) || $Section_2_content_value['section_enabled'] == 'active')
<section class="tw-relative tw-mt-10 tw-flex tw-min-h-[100vh] tw-w-full tw-max-w-[100vw] tw-flex-col tw-place-items-center lg:tw-p-6">
    <div class="reveal-up tw-mt-[5%] tw-flex tw-h-full tw-w-full tw-place-content-center tw-gap-2 tw-p-4 max-lg:tw-max-w-full max-lg:tw-flex-col">
        <div class="tw-relative tw-flex tw-max-w-[30%] max-lg:tw-max-w-full tw-flex-col tw-place-items-start tw-gap-4 tw-p-2 max-lg:tw-place-items-center max-lg:tw-place-content-center max-lg:tw-w-full">
            <div class="tw-top-40 tw-flex tw-flex-col lg:tw-sticky tw-place-items-center tw-max-h-fit tw-max-w-[850px] max-lg:tw-max-h-fit max-lg:tw-max-w-[320px] tw-overflow-hidden">
                <h2 class="tw-text-5xl tw-font-serif tw-text-center tw-font-medium max-md:tw-text-3xl">
                    {{ __('Key Statistics') }}
                </h2>
                <a href="{{ route('property.home', ['code' => $user->code]) }}" class="btn !tw-mt-8 !tw-bg-transparent !tw-text-black !tw-border-[1px] !tw-border-black dark:!tw-border-white dark:!tw-text-white">
                    {{ __('View All') }}
                </a>
            </div>
        </div>
        <div class="tw-flex tw-flex-col tw-gap-10 tw-h-full tw-max-w-1/2 max-lg:tw-max-w-full tw-px-[10%] max-lg:tw-px-4 max-lg:tw-gap-3 max-lg:tw-w-full lg:tw-top-[20%] tw-place-items-center">
            @for ($boxNum = 1; $boxNum <= 4; $boxNum++)
                @if (!empty($Section_2_content_value['Box' . $boxNum . '_number']) || !empty($Section_2_content_value['Box' . $boxNum . '_title']))
                    <div class="reveal-up tw-h-[240px] tw-w-[450px] max-md:tw-w-full">
                        <a href="{{ route('property.home', ['code' => $user->code]) }}" class="tw-flex tw-w-full tw-h-full tw-gap-8 tw-rounded-xl hover:tw-shadow-lg dark:tw-shadow-[#080808] tw-duration-300 tw-transition-all tw-p-8 tw-group/card">
                            <div class="tw-text-4xl max-md:tw-text-2xl">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="tw-flex tw-flex-col tw-gap-4">
                                <h3 class="tw-text-2xl max-md:tw-text-xl">
                                    {{ $Section_2_content_value['Box' . $boxNum . '_title'] ?? '' }}
                                </h3>
                                <p class="tw-text-gray-800 dark:tw-text-gray-100 max-md:tw-text-sm">
                                    <span class="tw-text-4xl tw-font-bold">{{ $Section_2_content_value['Box' . $boxNum . '_number'] ?? '0' }}</span>
                                </p>
                                <div class="tw-mt-auto tw-flex tw-gap-2 tw-underline tw-underline-offset-4">
                                    <span>{{ __('Learn more') }}</span>
                                    <i class="bi bi-arrow-up-right group-hover/card:tw--translate-y-1 group-hover/card:tw-translate-x-1 tw-duration-300 tw-transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>
@endif

@if (empty($Section_3_content_value['section_enabled']) || $Section_3_content_value['section_enabled'] == 'active')
<section class="tw-relative tw-flex tw-w-full tw-min-h-[110vh] max-md:tw-min-h-[80vh] tw-flex-col tw-place-content-center tw-place-items-center tw-overflow-hidden">
    <div class="tw-w-full max-lg:tw-max-w-full tw-place-content-center tw-items-center tw-flex tw-flex-col tw-max-w-[80%] tw-gap-4 tw-p-4">
        <h3 class="reveal-up tw-text-5xl tw-font-medium max-md:tw-text-3xl tw-text-center tw-leading-normal">
            {{ $Section_3_content_value['Sec3_title'] ?? __('Additional Features') }}
        </h3>
        <div class="tw-mt-8 tw-relative tw-gap-10 tw-p-4 tw-grid tw-place-items-center tw-grid-cols-3 max-lg:tw-flex max-lg:tw-flex-col">
            @if (isset($allAmenities) && count($allAmenities) > 0)
                @foreach ($allAmenities->take(6) as $amenity)
                    @php
                        $image = !empty($amenity->image) ? $amenity->image : 'default.png';
                        $imageUrl = fetch_file($image, 'upload/amenity/');
                    @endphp
                    <div class="reveal-up tw-w-full tw-border-[1px] tw-h-[350px] tw-rounded-md tw-place-items-center tw-p-4 tw-bg-[#f2f3f4] dark:tw-bg-[#080808] dark:tw-border-[#1f2123] tw-flex tw-flex-col tw-gap-3">
                        <div class="tw-w-full tw-h-[150px] tw-p-4 tw-rounded-xl tw-backdrop-blur-2xl tw-overflow-hidden tw-flex tw-place-content-center">
                            @if (!empty($imageUrl) && $image != 'default.png')
                                <img src="{{ $imageUrl }}" alt="{{ ucfirst($amenity->name) }}" class="tw-w-auto tw-h-full tw-object-contain" onerror="this.style.display='none';">
                            @endif
                        </div>
                        <h3 class="tw-text-2xl">{{ ucfirst($amenity->name) }}</h3>
                        <p class="tw-text-gray-700 dark:tw-text-gray-300 tw-px-4 tw-text-center tw-text-sm">
                            {{ \Illuminate\Support\Str::limit(strip_tags($amenity->description ?? ''), 80, '...') }}
                        </p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endif

{{-- @if (!empty($subscriptions) && count($subscriptions) > 0)
<section class="tw-mt-5 tw-flex tw-w-full tw-flex-col tw-gap-6 tw-place-items-center tw-p-[2%]" id="pricing">
    <h3 class="reveal-up tw-text-5xl tw-font-medium max-md:tw-text-2xl">
        {{ __('Choose the right plan for you') }}
    </h3>
    
    <!-- Pricing Toggle -->
    <div class="reveal-up tw-mt-6 tw-flex tw-gap-4 tw-items-center">
        <span class="tw-text-gray-700 dark:tw-text-gray-300">Bill Monthly</span>
        <label class="tw-relative tw-inline-flex tw-items-center tw-cursor-pointer">
            <input type="checkbox" id="pricing-toggle" class="tw-sr-only tw-peer" onchange="togglePricing()">
            <div class="tw-w-11 tw-h-6 tw-bg-gray-200 peer-focus:tw-outline-none peer-focus:tw-ring-4 peer-focus:tw-ring-blue-300 dark:peer-focus:tw-ring-blue-800 dark:tw-bg-gray-700 peer-checked:after:tw-translate-x-full peer-checked:after:tw-border-white after:tw-content-[''] after:tw-absolute after:tw-top-[2px] after:tw-left-[2px] after:tw-bg-white after:tw-border-gray-300 after:tw-border after:tw-rounded-full after:tw-h-5 after:tw-w-5 after:tw-transition-all dark:tw-border-gray-600 peer-checked:tw-bg-blue-600"></div>
        </label>
        <span class="tw-text-gray-700 dark:tw-text-gray-300">Bill Annually</span>
        <span id="save-percentage" class="tw-text-primary tw-font-semibold" style="display: none;"></span>
    </div>
    
    <div class="tw-mt-10 tw-flex tw-flex-wrap tw-place-content-center tw-gap-8 max-lg:tw-flex-col">
        @foreach ($subscriptions as $subscription)
            @php
                $yearlyDiscount = $subscription->yearly_discount ?? 20;
                $discountMultiplier = (100 - $yearlyDiscount) / 100;
                
                if ($subscription->interval == 'Monthly') {
                    $monthlyPrice = $subscription->package_amount;
                    $yearlyTotal = round($monthlyPrice * 12 * $discountMultiplier, 0);
                    $yearlyPricePerMonth = round($yearlyTotal / 12, 0);
                } elseif ($subscription->interval == 'Yearly') {
                    $yearlyTotal = $subscription->package_amount;
                    $monthlyPrice = round($yearlyTotal / 12, 0);
                    $yearlyPricePerMonth = round($yearlyTotal / 12, 0);
                } else {
                    $monthlyPrice = $subscription->package_amount;
                    $yearlyTotal = round($monthlyPrice * 12 * $discountMultiplier, 0);
                    $yearlyPricePerMonth = round($yearlyTotal / 12, 0);
                }
                $isMostPopular = !empty($subscription->most_popular) && $subscription->most_popular == 1;
            @endphp
            <div class="reveal-up tw-flex tw-w-[350px] tw-flex-col tw-place-items-center tw-gap-2 tw-rounded-lg tw-border-{{ $isMostPopular ? '2' : '[1px]' }} tw-border-outlineColor tw-bg-white dark:tw-bg-[#080808] dark:tw-border-[{{ $isMostPopular ? '#595858' : '#1f2123' }}] tw-p-8 tw-shadow-xl max-lg:tw-w-[320px]">
                @if ($isMostPopular)
                    <div class="tw-mb-2 tw-text-primary tw-font-semibold">{{ __('Most Popular') }}</div>
                @endif
                <h3 class="">
                    <span class="monthlyPrice tw-text-5xl max-md:tw-text-3xl tw-font-semibold">${{ number_format($monthlyPrice, 0) }}</span>
                    <span class="yearlyPrice tw-text-5xl max-md:tw-text-3xl tw-font-semibold" style="display: none;">${{ number_format($yearlyPricePerMonth, 0) }}</span>
                    <span class="tw-text-2xl tw-text-gray-600 dark:tw-text-gray-300">/mo</span>
                </h3>
                <p class="tw-mt-3 tw-text-center tw-text-gray-800 dark:tw-text-gray-100">
                    {{ $subscription->description ?: $subscription->title }}
                </p>
                <hr />
                <ul class="tw-mt-4 tw-flex tw-flex-col tw-gap-4 tw-text-base tw-text-gray-800 dark:tw-text-gray-200">
                    <li class="tw-flex tw-gap-2">
                        <i class="bi bi-check-circle-fill {{ !empty($subscription->email_notification) && $subscription->email_notification == 1 ? '' : 'tw-text-gray-400 dark:tw-text-gray-500' }}"></i>
                        <span>{{ __('Email notification') }}</span>
                    </li>
                    <li class="tw-flex tw-gap-2">
                        <i class="bi bi-check-circle-fill {{ !empty($subscription->subdomain) && $subscription->subdomain == 1 ? '' : 'tw-text-gray-400 dark:tw-text-gray-500' }}"></i>
                        <span>{{ __('Subdomain') }}</span>
                    </li>
                    <li class="tw-flex tw-gap-2">
                        <i class="bi bi-check-circle-fill {{ !empty($subscription->custom_domain) && $subscription->custom_domain == 1 ? '' : 'tw-text-gray-400 dark:tw-text-gray-500' }}"></i>
                        <span>{{ __('Add Custom Domain') }}</span>
                    </li>
                </ul>
                <a href="{{ route('property.home', ['code' => $user->code]) }}" class="btn tw-mt-auto !tw-w-full tw-transition-transform tw-duration-[0.3s] hover:tw-scale-x-[1.02]">
                    {{ __('Choose plan') }}
                </a>
            </div>
        @endforeach
    </div>
</section>
@endif --}}

@if (!empty($blogs) && count($blogs) > 0)
<section class="tw-mt-5 tw-flex tw-min-h-[80vh] tw-w-full tw-flex-col tw-place-content-center tw-place-items-center tw-p-[2%] max-lg:tw-p-3">
    <h3 class="reveal-up tw-text-4xl tw-font-medium max-md:tw-text-2xl">
        {{ __('Read resources by experts') }} ✨
    </h3>
    <div class="reveal-up tw-mt-10 tw-flex tw-flex-wrap tw-place-content-center tw-gap-10 max-lg:tw-flex-col">
        @foreach ($blogs as $blog)
            <a href="{{ route('blog.detail', ['code' => $user->code, 'slug' => $blog->slug]) }}" class="tw-flex tw-h-[500px] tw-w-[400px] tw-flex-col tw-gap-2 tw-overflow-clip tw-rounded-lg tw-p-4 max-lg:tw-w-[350px]">
                <div class="tw-h-[350px] tw-min-h-[350px] tw-w-full tw-overflow-hidden tw-rounded-2xl">
                    @if (!empty($blog->cover_image))
                        <img src="{{ fetch_file($blog->cover_image, 'upload/blog/') }}" alt="{{ $blog->title }}" class="tw-h-full tw-w-full tw-object-cover tw-transition-transform tw-duration-700 hover:tw-scale-[1.3]" onerror="this.style.display='none';">
                    @endif
                </div>
                <div class="tw-text-gray-600 dark:tw-text-gray-300 tw-justify-between tw-flex tw-gap-2">
                    <div class="tw-text-gray-800 dark:tw-text-gray-200">{{ __('Blog') }}</div>
                    <div class="tw-text-gray-600 dark:tw-text-gray-400">{{ $blog->created_at->format('M d, Y') }}</div>
                </div>
                <h3 class="tw-mt-1 tw-font-medium tw-text-xl max-md:tw-text-xl">
                    {{ $blog->title }}
                </h3>
            </a>
        @endforeach
    </div>
</section>
@endif

@if (!empty($testimonials) && count($testimonials) > 0)
<section class="tw-flex tw-min-h-[100vh] tw-w-full tw-flex-col tw-place-content-center tw-place-items-center tw-p-[2%]">
    <h3 class="reveal-up tw-text-4xl tw-font-medium tw-text-center max-md:tw-text-2xl">
        {{ $Section_7_content_value['Sec7_title'] ?? __('Join the professionals using our platform') }}
    </h3>
    <div class="tw-mt-20 tw-gap-10 tw-space-y-8 max-md:tw-columns-1 lg:tw-columns-2 xl:tw-columns-3">
        @foreach ($testimonials as $num)
            @php
                $imagePath = $Section_7_content_value["Sec7_box{$num}_image_path"] ?? '';
                $imageUrl = !empty($imagePath) ? fetch_file(basename($imagePath), 'upload/fronthomepage/') : asset('assets/images/admin/user.png');
                $name = $Section_7_content_value["Sec7_box{$num}_name"] ?? '';
                $tag = $Section_7_content_value["Sec7_box{$num}_tag"] ?? '';
                $review = $Section_7_content_value["Sec7_box{$num}_review"] ?? '';
            @endphp
            @if (!empty($review))
                <div class="reveal-up tw-flex tw-h-fit tw-w-[350px] tw-break-inside-avoid tw-flex-col tw-gap-4 tw-rounded-lg tw-border-[1px] tw-bg-[#f2f3f4] dark:tw-bg-[#080808] dark:tw-border-[#1f2123] tw-p-4 max-lg:tw-w-[320px]">
                    <div class="tw-flex tw-place-items-center tw-gap-3">
                        <div class="tw-h-[50px] tw-w-[50px] tw-overflow-hidden tw-rounded-full">
                            <img src="{{ $imageUrl }}" class="tw-h-full tw-w-full tw-object-cover" alt="{{ $name }}" onerror="this.src='{{ asset('assets/images/admin/user.png') }}';">
                        </div>
                        <div class="tw-flex tw-flex-col tw-gap-1">
                            <div class="tw-font-semibold">{{ $name }}</div>
                            <div class="tw-text-gray-700 dark:tw-text-gray-300">{{ $tag }}</div>
                        </div>
                    </div>
                    <p class="tw-mt-4 tw-text-gray-800 dark:tw-text-gray-200">
                        {{ $review }}
                    </p>
                </div>
            @endif
        @endforeach
    </div>
</section>
@endif

<section class="tw-relative tw-flex tw-w-full tw-flex-col tw-place-content-center tw-place-items-center tw-gap-[10%] tw-p-[5%] tw-px-[10%]">
    <h3 class="tw-text-4xl tw-font-medium max-md:tw-text-2xl">
        {{ __('FAQ') }}
    </h3>
    <div class="tw-mt-5 tw-flex tw-min-h-[300px] tw-w-full tw-max-w-[850px] tw-flex-col tw-gap-4">
        <div class="faq tw-w-full">
            <h4 class="faq-accordion tw-flex tw-w-full tw-select-none tw-text-xl max-md:tw-text-lg">
                <span>{{ __('What is property management?') }}</span>
                <i class="bi bi-plus tw-text-xl tw-origin-center tw-duration-300 tw-transition-transform tw-ml-auto tw-font-semibold"></i>
            </h4>
            <div class="content max-lg:tw-text-sm">
                {{ __('Property management refers to the administration, operation, and oversight of real estate properties on behalf of property owners.') }}
            </div>
        </div>
        <hr>
        <div class="faq tw-w-full">
            <h4 class="faq-accordion tw-flex tw-w-full tw-select-none tw-text-xl max-md:tw-text-lg">
                <span>{{ __('How do I list my property?') }}</span>
                <i class="bi bi-plus tw-text-xl tw-origin-center tw-duration-300 tw-transition-transform tw-ml-auto tw-font-semibold"></i>
            </h4>
            <div class="content max-lg:tw-text-sm">
                {{ __('You can list your property by contacting us through our contact page or by signing up for an account.') }}
            </div>
        </div>
        <hr>
        <div class="faq tw-w-full">
            <h4 class="faq-accordion tw-flex tw-w-full tw-select-none tw-text-xl max-md:tw-text-lg">
                <span>{{ __('What features are included?') }}</span>
                <i class="bi bi-plus tw-text-xl tw-origin-center tw-duration-300 tw-transition-transform tw-ml-auto tw-font-semibold"></i>
            </h4>
            <div class="content max-lg:tw-text-sm">
                {{ __('Our platform includes tenant management, automated billing, maintenance tracking, and comprehensive reporting features.') }}
            </div>
        </div>
        <hr>
        <div class="faq tw-w-full">
            <h4 class="faq-accordion tw-flex tw-w-full tw-select-none tw-text-xl max-md:tw-text-lg">
                <span>{{ __('Is there a free trial?') }}</span>
                <i class="bi bi-plus tw-text-xl tw-origin-center tw-duration-300 tw-transition-transform tw-ml-auto tw-font-semibold"></i>
            </h4>
            <div class="content max-lg:tw-text-sm">
                {{ __('Yes, you can start using our platform for free, and later upgrade your plan to access all its features.') }}
            </div>
        </div>
        <hr>
    </div>
    <div class="purple-bg-grad max-md:tw-hidden reveal-up tw-absolute tw-bottom-14 tw-right-[20%] tw-h-[150px] tw-w-[150px] tw-rounded-full"></div>
</section>

<section class="tw-relative tw-flex tw-p-2 tw-w-full tw-min-h-[60vh] tw-flex-col tw-place-content-center tw-place-items-center tw-overflow-hidden">
    <div class="reveal-up tw-w-full tw-h-full tw-min-h-[350px] max-lg:tw-max-w-full tw-rounded-md lg:tw-py-[5%] tw-bg-[#f2f3f4] dark:tw-bg-[#080808] tw-place-content-center tw-items-center tw-flex tw-flex-col tw-max-w-[80%] tw-gap-4 tw-p-4">
        <h3 class="reveal-up tw-text-5xl tw-font-medium max-md:tw-text-3xl tw-text-center tw-leading-normal">
            {{ __('Access and manage multiple properties') }}
        </h3>
        <div class="tw-mt-8 tw-relative tw-flex max-lg:tw-flex-col tw-gap-5">
            <a href="{{ route('property.home', ['code' => $user->code]) }}" class="btn reveal-up !tw-rounded-full !tw-p-4 tw-font-medium">
                {{ __('Explore Properties') }}
            </a>
        </div>
    </div>
</section>

<section class="tw-flex tw-w-full tw-flex-col tw-place-content-center tw-place-items-center tw-gap-[10%] tw-p-[5%] tw-px-[10%] max-md:tw-px-2">
    <div class="tw-flex tw-w-full tw-max-w-[80%] tw-place-content-center tw-place-items-center tw-justify-between tw-gap-3 tw-rounded-lg tw-bg-[#f2f3f4] dark:tw-bg-[#080808] tw-p-6 max-md:tw-max-w-full max-md:tw-flex-col">
        <div class="tw-flex tw-flex-col max-lg:tw-text-center tw-gap-1">
            <h2 class="tw-text-2xl tw-text-gray-800 dark:tw-text-gray-200 max-md:tw-text-xl">
                {{ __('Join our newsletter') }}
            </h2>
            <div class="tw-text-gray-700 dark:tw-text-gray-300">{{ __('Get product insights and updates.') }}</div>
        </div>
        <div class="tw-flex tw-h-[60px] tw-place-items-center tw-gap-2 tw-overflow-hidden tw-p-2">
            <input type="email" class="input tw-h-full tw-w-full !tw-border-gray-600 tw-p-2 tw-outline-none" placeholder="{{ __('email') }}" />
            <a class="btn !tw-rounded-full !tw-border-[1px] !tw-text-black !tw-border-solid !tw-border-black dark:!tw-text-white dark:!tw-border-gray-300 !tw-bg-transparent tw-transition-colors tw-duration-[0.3s]" href="">
                {{ __('Signup') }}
            </a>
        </div>
    </div>
</section>

@push('script-page')
<script>
    // Hero section scroll animation - partially visible at bottom on load, fully visible on scroll
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
            
            const heroSection = document.getElementById('hero-section');
            const dashboard = document.getElementById('dashboard');
            
            if (heroSection) {
                // Set initial state - hero section partially visible at bottom (show bottom 30%)
                const initialY = window.innerHeight * 0.3;
                gsap.set(heroSection, {
                    y: initialY,
                    opacity: 0.8
                });
                
                // Animate hero section to fully visible on scroll
                gsap.to(heroSection, {
                    y: 0,
                    opacity: 1,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: heroSection,
                        start: "top 90%",
                        end: "top 10%",
                        scrub: 1,
                    }
                });
            }
            
            if (dashboard) {
                // Remove tilt from dashboard - keep it normal
                gsap.set(dashboard, {
                    transform: "perspective(1200px) translateX(0px) translateY(0px) scale(1) rotate(0deg) rotateX(0deg)"
                });
            }
        }
    });
    
    // Update typed.js prompts for property management
    if (typeof Typed !== 'undefined') {
        const typed = new Typed('#prompts-sample', {
            strings: [
                "{{ __('Find properties for rent') }}",
                "{{ __('Search properties for sale') }}",
                "{{ __('Explore available amenities') }}",
                "{{ __('View property details') }}"
            ],
            typeSpeed: 80,
            smartBackspace: true,
            loop: true,
            backDelay: 2000,
        });
    }
    
    // Pricing toggle functionality
    function togglePricing() {
        const toggle = document.getElementById('pricing-toggle');
        const monthlyPrices = document.querySelectorAll('.monthlyPrice');
        const yearlyPrices = document.querySelectorAll('.yearlyPrice');
        const savePercentage = document.getElementById('save-percentage');
        
        if (toggle.checked) {
            // Show yearly prices (per month equivalent)
            monthlyPrices.forEach(el => el.style.display = 'none');
            yearlyPrices.forEach(el => el.style.display = 'inline');
            
            // Show save percentage - get from first subscription with discount
            @if (!empty($subscriptions) && $subscriptions->first())
                @php $firstSub = $subscriptions->first(); @endphp
                @if (!empty($firstSub->yearly_discount))
                    savePercentage.textContent = 'Save {{ $firstSub->yearly_discount }}%';
                    savePercentage.style.display = 'inline';
                @endif
            @endif
        } else {
            // Show monthly prices
            monthlyPrices.forEach(el => el.style.display = 'inline');
            yearlyPrices.forEach(el => el.style.display = 'none');
            savePercentage.style.display = 'none';
        }
    }
    
    // Initialize pricing display on page load
    document.addEventListener('DOMContentLoaded', function() {
        const monthlyPrices = document.querySelectorAll('.monthlyPrice');
        const yearlyPrices = document.querySelectorAll('.yearlyPrice');
        monthlyPrices.forEach(el => el.style.display = 'inline');
        yearlyPrices.forEach(el => el.style.display = 'none');
    });
</script>
@endpush

@endsection
