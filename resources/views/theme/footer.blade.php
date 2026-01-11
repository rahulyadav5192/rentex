@php
    $Section_8 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 8')->first();
    $Section_8_content_value = !empty($Section_8->content_value)
        ? json_decode($Section_8->content_value, true)
        : [];
    
    $appName = !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME');
    
    $logoUrl = asset('logo.png');
    $section9 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 9')->first();
    
    if ($section9 && !empty($section9->content_value)) {
        $section9_content = json_decode($section9->content_value, true);
        $light_logo_path = !empty($section9_content['light_logo_path']) ? $section9_content['light_logo_path'] : '';
        
        if (!empty($light_logo_path)) {
            $logoUrl = fetch_file(basename($light_logo_path), 'upload/logo/');
        }
        
        if (empty($logoUrl) || $logoUrl == asset('logo.png')) {
            $logo_path = !empty($section9_content['logo_path']) ? $section9_content['logo_path'] : '';
            if (!empty($logo_path)) {
                $logoUrl = fetch_file(basename($logo_path), 'upload/logo/');
            }
        }
        
        if (empty($logoUrl) || $logoUrl == asset('logo.png')) {
            $admin_logo = getSettingsValByName('company_logo');
            $logoUrl = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
        }
    } else {
        $admin_logo = getSettingsValByName('company_logo');
        $logoUrl = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
    }
    
    if (empty($logoUrl)) {
        $logoUrl = asset('logo.png');
    }
    
    $hasSocialMedia = false;
    $socialLinks = [
        'fb_link' => $Section_8_content_value['fb_link'] ?? '',
        'twitter_link' => $Section_8_content_value['twitter_link'] ?? '',
        'insta_link' => $Section_8_content_value['insta_link'] ?? '',
        'linkedin_link' => $Section_8_content_value['linkedin_link'] ?? '',
    ];
    foreach ($socialLinks as $link) {
        if (!empty($link) && $link !== '#' && $link !== '') {
            $hasSocialMedia = true;
            break;
        }
    }
@endphp

@if (empty($Section_8_content_value['section_enabled']) || $Section_8_content_value['section_enabled'] == 'active')
<footer class="tw-mt-auto tw-flex tw-flex-col tw-w-full tw-gap-4 tw-text-sm tw-pt-[5%] tw-pb-10 tw-px-[10%] 
                tw-text-black dark:tw-text-white max-md:tw-flex-col">
    <div class="tw-flex max-md:tw-flex-col max-md:tw-gap-6 tw-gap-3 tw-w-full tw-place-content-around">
        <div class="tw-flex tw-h-full tw-w-[250px] tw-flex-col tw-place-items-center tw-gap-6 max-md:tw-w-full">
            <a href="{{ route('web.page', $user->code) }}" class="tw-w-full tw-place-items-center tw-flex tw-flex-col tw-gap-6">
                <img src="{{ $logoUrl }}" alt="logo" class="tw-max-w-[120px] dark:tw-invert" onerror="this.style.display='none';">
                <div class="tw-max-w-[120px] tw-text-center tw-text-3xl tw-h-fit">
                    {{ strtoupper($appName) }}
                </div>
            </a>
            @if ($hasSocialMedia)
                <div class="tw-flex tw-gap-4 tw-text-lg">
                    @if (!empty($Section_8_content_value['fb_link']) && $Section_8_content_value['fb_link'] !== '#')
                        <a href="{{ $Section_8_content_value['fb_link'] }}" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if (!empty($Section_8_content_value['twitter_link']) && $Section_8_content_value['twitter_link'] !== '#')
                        <a href="{{ $Section_8_content_value['twitter_link'] }}" aria-label="Twitter-X" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    @endif
                    @if (!empty($Section_8_content_value['insta_link']) && $Section_8_content_value['insta_link'] !== '#')
                        <a href="{{ $Section_8_content_value['insta_link'] }}" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if (!empty($Section_8_content_value['linkedin_link']) && $Section_8_content_value['linkedin_link'] !== '#')
                        <a href="{{ $Section_8_content_value['linkedin_link'] }}" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div class="tw-flex max-md:tw-flex-col tw-flex-wrap tw-gap-6 tw-h-full tw-w-full tw-justify-around">
            <div class="tw-flex tw-h-full tw-w-[200px] tw-flex-col tw-gap-4">
                <h2 class="tw-text-xl">{{ __('Quick Links') }}</h2>
                <div class="tw-flex tw-flex-col tw-gap-3">
                    <a href="{{ route('web.page', $user->code) }}" class="footer-link">{{ __('Home') }}</a>
                    <a href="{{ route('property.home', ['code' => $user->code]) }}" class="footer-link">{{ __('Properties') }}</a>
                    <a href="{{ route('blog.home', ['code' => $user->code]) }}" class="footer-link">{{ __('Blog') }}</a>
                    <a href="{{ route('contact.home', ['code' => $user->code]) }}" class="footer-link">{{ __('Contact') }}</a>
                </div>
            </div>

            <div class="tw-flex tw-h-full tw-w-[200px] tw-flex-col tw-gap-4">
                <h2 class="tw-text-xl">{{ __('About') }}</h2>
                <div class="tw-flex tw-flex-col tw-gap-3">
                    <a href="{{ route('web.page', $user->code) }}#features" class="footer-link">{{ __('Features') }}</a>
                    <a href="{{ route('web.page', $user->code) }}#about" class="footer-link">{{ __('About Us') }}</a>
                    <a href="{{ route('blog.home', ['code' => $user->code]) }}" class="footer-link">{{ __('Blog') }}</a>
                    <a href="{{ route('contact.home', ['code' => $user->code]) }}" class="footer-link">{{ __('Contact Us') }}</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="tw-mt-8">
    <div class="tw-mt-2 tw-flex tw-gap-2 tw-flex-col tw-text-gray-700 dark:tw-text-gray-300 tw-place-items-center 
                tw-text-[12px] tw-w-full tw-text-center tw-place-content-around">
        <span>Copyright © {{ date('Y') }} {{ $appName }}</span>
        <span>{{ __('All rights reserved.') }}</span>
    </div>
</footer>
@endif
