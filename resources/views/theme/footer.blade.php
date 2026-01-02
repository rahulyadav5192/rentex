



    <!-- Footer -->
    @php
        $Section_8 = App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 8')->first();
        $Section_8_content_value = !empty($Section_8->content_value)
            ? json_decode($Section_8->content_value, true)
            : [];
        
        $appName = !empty($settings['app_name']) ? $settings['app_name'] : 'Rentex';
    @endphp
    @if (empty($Section_8_content_value['section_enabled']) || $Section_8_content_value['section_enabled'] == 'active')
        <footer class="bg-slate-900 dark:bg-[#0B0F19] text-gray-300 border-t border-slate-800 dark:border-gray-800">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-12">
                    <div class="lg:col-span-4 space-y-6">
                        <a class="flex items-center space-x-2" href="{{ route('web.page', $user->code) }}">
                            <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center text-primary">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                            </div>
                            <span class="text-2xl font-display font-bold text-white">{{ $appName }}</span>
                        </a>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                            {{ $Section_8_content_value['Sec8_info'] ?? __('The all-in-one platform designed for modern property managers. Automate, organize, and grow your real estate portfolio with ease.') }}
                        </p>
                    </div>
                    <div class="lg:col-span-2 space-y-4">
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider">{{ __('Product') }}</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a class="hover:text-primary transition-colors duration-200" href="{{ route('property.home', ['code' => $user->code]) }}">{{ __('Properties') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Features') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Pricing') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Case Studies') }}</a></li>
                        </ul>
                    </div>
                    <div class="lg:col-span-2 space-y-4">
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider">{{ __('Company') }}</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('About Us') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Careers') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="{{ route('blog.home', ['code' => $user->code]) }}">{{ __('Blog') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="{{ route('contact.home', ['code' => $user->code]) }}">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                    <div class="lg:col-span-2 space-y-4">
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider">{{ __('Support') }}</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Help Center') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Status') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Privacy Policy') }}</a></li>
                            <li><a class="hover:text-primary transition-colors duration-200" href="#">{{ __('Terms of Service') }}</a></li>
                        </ul>
                    </div>
                    <div class="lg:col-span-2 space-y-4">
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider">{{ __('Follow Us') }}</h4>
                        <div class="flex flex-wrap gap-3">
                            @if (!empty($Section_8_content_value['fb_link']))
                                <a aria-label="Facebook" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm" href="{{ $Section_8_content_value['fb_link'] }}" target="_blank">
                                    <svg class="w-4 h-4" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                                </a>
                            @endif
                            @if (!empty($Section_8_content_value['twitter_link']))
                                <a aria-label="Twitter" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm" href="{{ $Section_8_content_value['twitter_link'] }}" target="_blank">
                                    <svg class="w-4 h-4" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
                                </a>
                            @endif
                            @if (!empty($Section_8_content_value['insta_link']))
                                <a aria-label="Instagram" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm" href="{{ $Section_8_content_value['insta_link'] }}" target="_blank">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"><rect height="20" rx="5" ry="5" width="20" x="2" y="2"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path></svg>
                                </a>
                            @endif
                            @if (!empty($Section_8_content_value['linkedin_link']))
                                <a aria-label="LinkedIn" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all duration-300 shadow-sm" href="{{ $Section_8_content_value['linkedin_link'] }}" target="_blank">
                                    <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" stroke="none"></path><circle cx="4" cy="4" r="2" stroke="none"></circle></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="pt-8 mt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                    <p>© {{ date('Y') }} {{ $appName }}. {{ __('All rights reserved.') }}</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a class="hover:text-gray-300 transition-colors" href="#">{{ __('Privacy') }}</a>
                        <a class="hover:text-gray-300 transition-colors" href="#">{{ __('Terms') }}</a>
                        <a class="hover:text-gray-300 transition-colors" href="#">{{ __('Cookies') }}</a>
                    </div>
                </div>
            </div>
        </footer>
    @endif

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('assets/web/js/jquery-migrate-3.5.2.min.js') }}"></script>
<script src="{{ asset('assets/web/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/web/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/web/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/web/js/jquery.mmenu.all.js') }}"></script>
<script src="{{ asset('assets/web/js/ace-responsive-menu.js') }}"></script>
<script src="{{ asset('assets/web/js/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('assets/web/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/web/js/isotop.js') }}"></script>

<script src="{{ asset('assets/web/js/owl.js') }}"></script>

<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

<script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
<script src="{{ asset('assets/web/js/script.js') }}"></script>
@stack('script-page')

<script>
    var successImg='{{ asset("assets/images/notification/ok-48.png") }}';
    var errorImg='{{ asset("assets/images/notification/high_priority-48.png") }}';
</script>
<script src="{{ asset('js/custom.js') }}"></script>
@if ($statusMessage = Session::get('success'))
    <script>
        notifier.show('Success!', '{!! $statusMessage !!}', 'success',
        successImg, 4000);
    </script>
@endif
@if ($statusMessage = Session::get('error'))
    <script>
         notifier.show('Error!', '{!! $statusMessage !!}', 'error',
         errorImg, 4000);
    </script>
@endif

