<div id="page" class="mobilie_header_nav stylehome1" style="display: none;">
    <div class="mobile-menu">
        <div class="header bdrb1">
            <div class="menu_and_widgets">
                <div class="mobile_menu_bar d-flex justify-content-between align-items-center">
                    <a class="mobile_logo" href="{{ route('web.page', $user->code) }}">
                        @php
                            // Check Section 9 for logo first, then fall back to settings
                            $logoUrl = asset('logo.png'); // Default fallback
                            $section9 = \App\Models\FrontHomePage::where('parent_id', $user->id)->where('section', 'Section 9')->first();
                            
                            if ($section9 && !empty($section9->content_value)) {
                                $section9_content = json_decode($section9->content_value, true);
                                $logo_path = !empty($section9_content['logo_path']) ? $section9_content['logo_path'] : '';
                                
                                if (!empty($logo_path)) {
                                    $logoUrl = fetch_file(basename($logo_path), 'upload/logo/');
                                    // If fetch_file returns empty, fall back to settings
                                    if (empty($logoUrl)) {
                                        $admin_logo = getSettingsValByName('company_logo');
                                        $logoUrl = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
                                    }
                                } else {
                                    // No logo in Section 9, fall back to settings
                                    $admin_logo = getSettingsValByName('company_logo');
                                    $logoUrl = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
                                }
                            } else {
                                // Section 9 doesn't exist, use settings
                                $admin_logo = getSettingsValByName('company_logo');
                                $logoUrl = !empty($admin_logo) ? fetch_file($admin_logo, 'upload/logo/') : asset('logo.png');
                            }
                            
                            // Final fallback
                            if (empty($logoUrl)) {
                                $logoUrl = asset('logo.png');
                            }
                        @endphp
                        <img src="{{ $logoUrl }}"
                            alt="" class="img-fluid" style="max-width: 150px; max-height: 50px; object-fit: contain;"
                            onerror="this.style.display='none';">
                    </a>



                    <div class="right-side text-end">
                        {{-- <a class=""
                            href="{{ route('login.home', ['code' => $user->code]) }}">{{ __('Login') }}</a> --}}
                        <a class="menubar ml30" href="#menu"><img
                                src="{{ asset('assets/web/images/mobile-dark-nav-icon.svg') }}" alt=""></a>

                    </div>
                </div>
            </div>
            <div class="posr">
                <div class="mobile_menu_close_btn"><span class="far fa-times"></span></div>
            </div>
        </div>
    </div>
    <!-- /.mobile-menu -->
    <nav id="menu" class="">
        <ul>

            <li><a href="{{ route('web.page', $user->code) }}">{{ __('Home') }}</a>

            </li>

            <li><a href="{{ route('property.home', ['code' => $user->code]) }}">{{ __('Properties') }}</a>

            </li>
            <li><a href="{{ route('blog.home', ['code' => $user->code]) }}">{{ __('Blog') }}</a>

            </li>
              <li><a href="{{ route('contact.home', ['code' => $user->code]) }}">{{ __('Contact') }}</a>

            </li>
            <!-- Only for Mobile View -->
        </ul>
    </nav>
</div>
