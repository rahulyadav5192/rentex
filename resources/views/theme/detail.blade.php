@extends('theme.main')
@section('content')
    @php
        // Get main property image (thumbnail or first image)
        $mainImage = null;
        if (!empty($property->thumbnail) && !empty($property->thumbnail->image)) {
            $mainImage = fetch_file($property->thumbnail->image, 'upload/property/thumbnail/');
        } elseif ($property->propertyImages->count() > 0) {
            $firstImage = $property->propertyImages->first();
            $mainImage = fetch_file($firstImage->image, 'upload/property/image/');
        }
        if (empty($mainImage)) {
            $mainImage = asset('assets/images/default-image.png');
        }
        
        // Get all property images for gallery
        $allImages = collect();
        if (!empty($property->thumbnail) && !empty($property->thumbnail->image)) {
            $allImages->push([
                'image' => fetch_file($property->thumbnail->image, 'upload/property/thumbnail/'),
                'alt' => $property->name
            ]);
        }
        foreach ($property->propertyImages as $img) {
            $imgUrl = fetch_file($img->image, 'upload/property/image/');
            if (!empty($imgUrl)) {
                $allImages->push([
                    'image' => $imgUrl,
                    'alt' => $property->name . ' - Image ' . ($allImages->count() + 1)
                ]);
            }
        }
        
        // Calculate totals from units
        $totalBedrooms = $units->sum('bedroom');
        $totalKitchens = $units->sum('kitchen');
        $totalBathrooms = $units->sum('baths');
        
        // Property type badge
        $listingTypeText = '';
        $listingTypeBadge = '';
        if ($property->listing_type == 'rent') {
            $listingTypeText = __('For Lease');
            $listingTypeBadge = 'bg-blue-500/90 dark:bg-blue-600/90';
        } elseif ($property->listing_type == 'sell') {
            $listingTypeText = __('For Sale');
            $listingTypeBadge = 'bg-emerald-500/90 dark:bg-emerald-600/90';
        }
        
        // Property type
        $propertyTypeText = \App\Models\Property::$Type[$property->type] ?? __('Property');
        
        // Price display
        $priceDisplay = '';
        $priceLabel = '';
        if (!empty($property->price) && $property->price > 0) {
            if ($property->listing_type == 'rent') {
                $priceLabel = __('Rent Price');
                $priceDisplay = priceformat($property->price) . '/ ' . __('month');
            } else {
                $priceLabel = __('Sell Price');
                $priceDisplay = priceformat($property->price);
            }
        } else {
            $priceLabel = __('Price');
            $priceDisplay = '$0 / ' . __('negotiable');
        }
        
        // Full address
        $fullAddress = trim(implode(', ', array_filter([
            $property->address,
            $property->city,
            $property->state,
            $property->country,
            $property->zip_code
        ])));
        
        // Google Maps URL
        $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($fullAddress);
        
        // App name from settings
        $appName = !empty($settings['app_name']) ? $settings['app_name'] : 'PropManage';
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="margin-top: 110px;">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-text-sub-light dark:text-text-sub-dark mb-6 flex-wrap gap-2">
            <a class="hover:text-primary dark:hover:text-emerald-400 transition" href="{{ route('web.page', $user->code) }}">{{ __('Home') }}</a>
            <span class="material-icons-outlined text-base">chevron_right</span>
            <a class="hover:text-primary dark:hover:text-emerald-400 transition" href="{{ route('property.home', $user->code) }}">{{ __('Properties') }}</a>
            <span class="material-icons-outlined text-base">chevron_right</span>
            <span class="font-medium text-text-main-light dark:text-text-main-dark">{{ ucfirst($property->name) }}</span>
                            </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Image Gallery -->
                <div class="relative group">
                    <div class="aspect-w-16 aspect-h-9 w-full overflow-hidden rounded-xl shadow-lg dark:shadow-slate-900/50">
                        <img id="main-property-image" 
                             alt="{{ ucfirst($property->name) }}" 
                             class="w-full h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700 ease-in-out" 
                             src="{{ $mainImage }}"
                             onerror="this.src='{{ asset('assets/images/default-image.png') }}';">
                        </div>
                    <div class="absolute top-4 left-4 flex gap-2 flex-wrap">
                        @if ($property->listing_type)
                            <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">{{ __('Featured') }}</span>
                        @endif
                        @if ($listingTypeText)
                            <span class="bg-surface-light dark:bg-surface-dark text-text-main-light dark:text-text-main-dark text-xs font-semibold px-3 py-1 rounded-full shadow-lg flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-secondary"></span> {{ $listingTypeText }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    @if ($allImages->count() > 1)
                        <div class="flex gap-4 mt-4 overflow-x-auto pb-2 scrollbar-hide">
                            @foreach ($allImages->take(4) as $index => $img)
                                <button onclick="changeMainImage('{{ $img['image'] }}', this)" 
                                        class="thumbnail-btn relative flex-none w-24 h-16 rounded-lg overflow-hidden {{ $index === 0 ? 'ring-2 ring-primary ring-offset-2 dark:ring-offset-gray-900 opacity-100' : 'opacity-70 hover:opacity-100' }} hover:ring-2 hover:ring-primary/50 transition-all">
                                    <img alt="{{ $img['alt'] }}" 
                                         class="w-full h-full object-cover" 
                                         src="{{ $img['image'] }}"
                                         onerror="this.src='{{ asset('assets/images/default-image.png') }}';">
                                </button>
                            @endforeach
                            @if ($allImages->count() > 4)
                                <div class="flex-none w-24 h-16 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-text-muted-light dark:text-text-muted-dark hover:bg-gray-300 dark:hover:bg-gray-600 transition cursor-pointer">
                                    <span class="text-xs font-semibold">+{{ $allImages->count() - 4 }} {{ __('Photos') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Property Overview -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                    <h2 class="text-xl font-display font-bold mb-4 text-text-main-light dark:text-text-main-dark">{{ __('Property Overview') }}</h2>
                    <div class="text-text-sub-light dark:text-text-sub-dark leading-relaxed mb-6 prose dark:prose-invert max-w-none">
                        {!! $property->description ?? __('No description available.') !!}
                                    </div>

                    <!-- Advantages -->
                    <h3 class="text-lg font-semibold mb-3 text-text-main-light dark:text-text-main-dark">{{ __('Why This Property Stands Out') }}</h3>
                    @if ($selectedAdvantages->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($selectedAdvantages as $advantage)
                                <div class="flex items-center gap-2 text-text-main-light dark:text-text-main-dark">
                                    <span class="material-icons-outlined text-secondary">check_circle</span>
                                    <span>{{ $advantage->name }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                    @else
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-6 border border-dashed border-gray-300 dark:border-gray-700 text-center">
                            <span class="material-icons-outlined text-4xl text-text-muted-light dark:text-text-muted-dark mb-2">star_border</span>
                            <p class="text-text-muted-light dark:text-text-muted-dark">{{ __('No specific advantages listed for this property yet.') }}</p>
                                                </div>
                                                    @endif
                                            </div>

                <!-- Amenities -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                    <h2 class="text-xl font-display font-bold mb-4 text-text-main-light dark:text-text-main-dark">{{ __('Amenities') }}</h2>
                    @if ($selectedAmenities->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                                        @foreach ($selectedAmenities as $amenity)
                                <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition">
                                                                    @if ($amenity->image)
                                        <img src="{{ fetch_file($amenity->image, 'upload/amenity/') }}" 
                                                                            alt="{{ $amenity->name }}"
                                             class="w-16 h-16 object-cover rounded-lg mb-2"
                                             onerror="this.style.display='none';">
                                    @else
                                        <span class="material-icons-outlined text-4xl text-primary mb-2">check_circle_outline</span>
                                                                    @endif
                                    <span class="text-sm font-medium text-text-main-light dark:text-text-main-dark text-center">{{ $amenity->name }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-6 border border-dashed border-gray-300 dark:border-gray-700 text-center">
                            <span class="material-icons-outlined text-4xl text-text-muted-light dark:text-text-muted-dark mb-2">check_circle_outline</span>
                            <p class="text-text-muted-light dark:text-text-muted-dark">{{ __('No amenities selected for this property.') }}</p>
                        </div>
                                                @endif
                                        </div>

                <!-- Location -->
                <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                    <h2 class="text-xl font-display font-bold mb-4 text-text-main-light dark:text-text-main-dark">{{ __('Location') }}</h2>
                    <div class="flex items-start gap-3 mb-4">
                        <span class="material-icons-outlined text-primary mt-1">location_on</span>
                        <div>
                            <p class="text-text-main-light dark:text-text-main-dark font-medium">{{ $fullAddress }}</p>
                                            </div>
                                        </div>
                    <div class="h-64 bg-gray-200 dark:bg-gray-700 rounded-lg w-full overflow-hidden relative">
                        <img alt="{{ __('Map Preview') }}" 
                             class="w-full h-full object-cover opacity-80 dark:opacity-60 grayscale" 
                             src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($fullAddress) }}&zoom=15&size=600x400&markers=color:red|{{ urlencode($fullAddress) }}&key={{ env('GOOGLE_MAPS_API_KEY', '') }}"
                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'400\'%3E%3Crect fill=\'%23e5e7eb\' width=\'600\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%236b7280\' font-family=\'sans-serif\' font-size=\'16\'%3EMap Preview%3C/text%3E%3C/svg%3E';">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <a href="{{ $googleMapsUrl }}" target="_blank" 
                               class="bg-white dark:bg-gray-800 text-primary px-4 py-2 rounded-lg shadow-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                {{ __('View on Google Maps') }}
                            </a>
                                                </div>
                                            </div>
                                        </div>

                <!-- Property Unit Specification -->
                @if ($units->count() > 0)
                    <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft dark:shadow-none dark:border dark:border-border-dark">
                        <h2 class="text-xl font-display font-bold mb-6 text-text-main-light dark:text-text-main-dark">{{ __('Property Unit Specification') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="group bg-gray-50 dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-sub-light dark:text-text-sub-dark font-medium">{{ __('Bedrooms') }}</span>
                                    <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-2 rounded-full">
                                        <span class="material-icons-outlined text-xl">bed</span>
                                    </span>
                                </div>
                                <p class="text-3xl font-display font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors">{{ $totalBedrooms }}</p>
                                <p class="text-xs text-text-sub-light dark:text-text-sub-dark mt-1">{{ __('Total Rooms') }}</p>
                            </div>
                            <div class="group bg-gray-50 dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-sub-light dark:text-text-sub-dark font-medium">{{ __('Kitchens') }}</span>
                                    <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 p-2 rounded-full">
                                        <span class="material-icons-outlined text-xl">kitchen</span>
                                    </span>
                                </div>
                                <p class="text-3xl font-display font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors">{{ $totalKitchens }}</p>
                                <p class="text-xs text-text-sub-light dark:text-text-sub-dark mt-1">{{ __('Fully Equipped') }}</p>
                                                                    </div>
                            <div class="group bg-gray-50 dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition duration-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-text-sub-light dark:text-text-sub-dark font-medium">{{ __('Bathrooms') }}</span>
                                    <span class="bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 p-2 rounded-full">
                                        <span class="material-icons-outlined text-xl">bathtub</span>
                                    </span>
                                                                </div>
                                <p class="text-3xl font-display font-bold text-text-main-light dark:text-text-main-dark group-hover:text-primary transition-colors">{{ $totalBathrooms }}</p>
                                <p class="text-xs text-text-sub-light dark:text-text-sub-dark mt-1">{{ __('Luxury Fittings') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <!-- Property Info Card -->
                    <div class="bg-card-light dark:bg-card-dark rounded-xl p-6 shadow-soft-hover dark:shadow-none dark:border dark:border-border-dark">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-2xl font-display font-bold text-text-main-light dark:text-text-main-dark mb-1">{{ ucfirst($property->name) }}</h1>
                                <div class="flex items-center text-sm text-text-sub-light dark:text-text-sub-dark">
                                    <span class="material-icons-outlined text-sm mr-1">place</span>
                                    <span>{{ $property->city ?? __('Location not specified') }}</span>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-red-500 transition" aria-label="{{ __('Add to favorites') }}">
                                <span class="material-icons-outlined">favorite_border</span>
                            </button>
                                            </div>
                        
                        <!-- Price -->
                        <div class="my-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-text-sub-light dark:text-text-sub-dark uppercase tracking-wide">{{ $priceLabel }}</p>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-bold text-primary">{{ $priceDisplay }}</span>
                            </div>
                        </div>
                        
                        <!-- Property Details -->
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div class="flex items-center gap-2 text-text-sub-light dark:text-text-sub-dark">
                                <span class="material-icons-outlined">home</span>
                                <span>{{ $propertyTypeText }}</span>
                                    </div>
                            @if ($property->created_at)
                                <div class="flex items-center gap-2 text-text-sub-light dark:text-text-sub-dark">
                                    <span class="material-icons-outlined">calendar_today</span>
                                    <span>{{ __('Built') }} {{ $property->created_at->format('Y') }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-2 text-secondary">
                                <span class="material-icons-outlined">verified</span>
                                <span>{{ __('Verified') }}</span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="{{ route('contact.home', ['code' => $user->code, 'property_id' => \Crypt::encrypt($property->id)]) }}" 
                               class="w-full bg-primary hover:bg-primary-hover text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <span class="material-icons-outlined">mail_outline</span>
                                {{ __('Contact Owner') }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- Owner/Manager Card -->
                    <div class="bg-card-light dark:bg-card-dark rounded-xl p-5 shadow-soft dark:shadow-none dark:border dark:border-border-dark flex items-center gap-4">
                        <div class="relative">
                            @php
                                $ownerAvatar = !empty($user->avatar) ? fetch_file($user->avatar, 'upload/avatar/') : asset('assets/images/admin/user.png');
                            @endphp
                            <img alt="{{ __('Owner Avatar') }}" 
                                 class="w-12 h-12 rounded-full object-cover" 
                                 src="{{ $ownerAvatar }}"
                                 onerror="this.src='{{ asset('assets/images/admin/user.png') }}';">
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-secondary border-2 border-white dark:border-gray-800 rounded-full"></span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-text-main-light dark:text-text-main-dark">{{ __('Managed by') }}</p>
                            <p class="text-xs text-text-sub-light dark:text-text-sub-dark">{{ $appName }}</p>
                        </div>
                        <button class="ml-auto text-primary hover:bg-blue-50 dark:hover:bg-blue-900/20 p-2 rounded-full transition" aria-label="{{ __('Chat') }}">
                            <span class="material-icons-outlined">chat</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .aspect-w-16 {
            position: relative;
            padding-bottom: 56.25%;
        }
        .aspect-w-16 > * {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
    </style>

    <script>
        function changeMainImage(imageUrl, buttonElement) {
            document.getElementById('main-property-image').src = imageUrl;
            // Update active state on thumbnails
            document.querySelectorAll('.thumbnail-btn').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-primary', 'ring-offset-2', 'dark:ring-offset-gray-900');
                btn.classList.add('opacity-70');
            });
            if (buttonElement) {
                buttonElement.classList.add('ring-2', 'ring-primary', 'ring-offset-2', 'dark:ring-offset-gray-900');
                buttonElement.classList.remove('opacity-70');
            }
        }
    </script>
@endsection
