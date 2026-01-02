<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($properties as $property)
        @php
            $thumbnail = !empty($property->thumbnail) && !empty($property->thumbnail->image) ? $property->thumbnail->image : '';
            $thumbnailUrl = !empty($thumbnail) ? fetch_file($thumbnail, 'upload/property/thumbnail/') : asset('assets/images/default-image.png');
            $listingType = !empty($property->listing_type) ? $property->listing_type : '';
            $price = !empty($property->price) ? $property->price : 0;
        @endphp
        <div class="property-card bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-lg dark:shadow-slate-900/50 border border-slate-200 dark:border-slate-700 hover:shadow-xl dark:hover:shadow-slate-900/70 transition-all duration-300 hover:-translate-y-1">
            <a href="{{ route('property.detail', ['code' => $user->code, \Crypt::encrypt($property->id)]) }}" class="block">
                <div class="relative h-56 overflow-hidden">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        src="{{ $thumbnailUrl }}" 
                        alt="{{ $property->name }}"
                        onerror="this.src='{{ asset('assets/images/default-image.png') }}';">
                    <div class="absolute top-4 right-4">
                        @if ($listingType == 'rent')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-500/90 dark:bg-purple-600/90 text-white text-xs font-semibold backdrop-blur-sm">
                                {{ __('Lease Property') }}
                            </span>
                        @elseif ($listingType == 'sell')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-500/90 dark:bg-blue-600/90 text-white text-xs font-semibold backdrop-blur-sm">
                                {{ __('Own Property') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-5">
                    <div class="mb-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-medium">
                            {{ \App\Models\Property::$Type[$property->type] ?? __('Property') }}
                        </span>
                    </div>
                    <h5 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-1 hover:text-primary dark:hover:text-emerald-400 transition-colors">
                        {{ ucfirst($property->name) }}
                    </h5>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit(strip_tags($property->description ?? ''), 80, '...') }}
                    </p>
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="line-clamp-1">{{ $property->address ?? __('No address') }}</span>
                    </div>
                    @if ($price > 0)
                        <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <p class="text-lg font-bold text-slate-900 dark:text-white">
                                @if ($listingType == 'rent')
                                    ${{ number_format($price) }}/{{ __('month') }}
                                @else
                                    ${{ number_format($price) }}
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </a>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-slate-400 dark:text-slate-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ __('No Properties Found') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ $noPropertiesMessage ?? __('Try adjusting your search filters.') }}</p>
            </div>
        </div>
    @endforelse
</div>

<style>
    .property-card {
        background-color: white;
        border: 1px solid #e2e8f0;
    }
    .dark .property-card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2) !important;
    }
    .dark .property-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3) !important;
    }
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Pagination -->
@if ($properties->hasPages())
    <div class="mt-12 md:mt-16">
        <nav class="flex flex-col items-center gap-4">
            <ul class="flex flex-wrap items-center justify-center gap-2">
                @if ($properties->onFirstPage())
                    <li>
                        <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $properties->previousPageUrl() }}" 
                           class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    </li>
                @endif

                @foreach ($properties->links()->elements[0] as $page => $url)
                    @if (is_string($page))
                        <li>
                            <span class="px-4 py-2 text-slate-500 dark:text-slate-400">{{ $page }}</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" 
                               class="px-4 py-2 rounded-lg {{ $page == $properties->currentPage() ? 'bg-primary text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary' }} transition-all shadow-md hover:shadow-lg">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach

                @if ($properties->hasMorePages())
                    <li>
                        <a href="{{ $properties->nextPageUrl() }}" 
                           class="px-4 py-2 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </li>
                @endif
            </ul>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                {{ __('Showing') }} {{ ($properties->currentPage() - 1) * $properties->perPage() + 1 }} – 
                {{ min($properties->currentPage() * $properties->perPage(), $properties->total()) }} 
                {{ __('of') }} {{ $properties->total() }} {{ __('properties') }}
            </p>
        </nav>
    </div>
@endif
