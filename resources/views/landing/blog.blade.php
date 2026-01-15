@extends('landing.layout')

@section('page-title', 'Blog')
@section('meta-description', 'Read the latest articles, tips, and insights about property management, tenant management, and real estate industry trends. Stay updated with Propilor blog for best practices and expert advice.')
@section('meta-keywords', 'property management blog, tenant management articles, property management tips, real estate blog, property management news')
@section('og-title', 'Blog - Propilor')

@section('content')
<!-- Start Page Heading -->
        <section class="cs_page_heading cs_style_hero text-center position-relative">
            <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
            <div class="container">
                <h1 class="cs_fs_64 cs_bold cs_mb_8">Our Blog</h1>
                <ol class="breadcrumb cs_fs_18 cs_heading_font">
                    <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ol>
                    <div class="cs_hero_shape_1 position-absolute">
                        <img src="{{ asset('landing/assets/img/dna-shape.png') }}" alt="Shape">
                    </div>
                    <div class="cs_hero_shape_2 position-absolute">
                        <img src="{{ asset('landing/assets/img/spring-shape-3.svg') }}" alt="Shape">
                    </div>
                </div>
            </div>
        </section>
        <!-- End Page Heading -->
        <!-- Start Blog Section -->
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row cs_row_gap_30 cs_gap_y_60">
                <aside class="col-xl-4 col-lg-5">
                    <div class="cs_sidebar cs_style_1 cs_type_1">
                        <div class="cs_sidebar_widget cs_gray_bg cs_radius_10">
                            <h3 class="cs_sidebar_widget_title cs_fs_22 cs_semibold cs_mb_22">Search</h3>
                            <form action="{{ route('landing.blog') }}" method="GET" class="cs_search cs_white_bg position-relative">
                                <input type="text" name="search" placeholder="Search here" value="{{ request('search') }}">
                                @if(request()->filled('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request()->filled('tag'))
                                    <input type="hidden" name="tag" value="{{ request('tag') }}">
                                @endif
                                <button type="submit" class="cs_search_button cs_center cs_blue_bg cs_white_color">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                        <div class="cs_sidebar_widget cs_gray_bg cs_radius_10">
                            <h3 class="cs_sidebar_widget_title cs_fs_22 cs_semibold cs_mb_22">Categories</h3>
                            @php
                                $categories = \App\Models\Blog::where('parent_id', 0)
                                    ->where('enabled', 1)
                                    ->whereNotNull('category')
                                    ->select('category', \DB::raw('count(*) as count'))
                                    ->groupBy('category')
                                    ->get();
                            @endphp
                            @if($categories->count() > 0)
                                <ul class="cs_service_category_list cs_heading_color cs_heading_font cs_mp_0">
                                    <li>
                                        <a href="{{ route('landing.blog') }}">
                                            <span>{{ __('All Categories') }}</span>
                                            <span>({{ \App\Models\Blog::where('parent_id', 0)->where('enabled', 1)->count() }})</span>
                                        </a>
                                    </li>
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('landing.blog', ['category' => $category->category]) }}" class="{{ request('category') == $category->category ? 'active' : '' }}">
                                                <span>{{ $category->category }}</span>
                                                <span>({{ $category->count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">{{ __('No categories available') }}</p>
                            @endif
                        </div>
                        <div class="cs_sidebar_widget cs_gray_bg cs_radius_10">
                            <h3 class="cs_sidebar_widget_title cs_fs_22 cs_semibold cs_mb_22">Recent Posts</h3>
                            @php
                                $recentBlogs = \App\Models\Blog::where('parent_id', 0)
                                    ->where('enabled', 1)
                                    ->latest()
                                    ->take(3)
                                    ->get();
                            @endphp
                            @if($recentBlogs->count() > 0)
                                <div class="cs_recent_post_wrapper">
                                    @foreach($recentBlogs as $recentBlog)
                                        <div class="cs_recent_post">
                                            <a aria-label="Click to read post" class="cs_recent_post_thumb cs_radius_10" href="{{ route('landing.blog-details', $recentBlog->slug) }}">
                                                @if(!empty($recentBlog->image))
                                                    @php
                                                        $recentImageUrl = asset('storage/upload/blog/image/' . $recentBlog->image);
                                                    @endphp
                                                    <img src="{{ $recentImageUrl }}" alt="{{ $recentBlog->title }}" onerror="this.src='{{ asset('landing/assets/img/post-img-13.jpg') }}'">
                                                @else
                                                    <img src="{{ asset('landing/assets/img/post-img-13.jpg') }}" alt="{{ $recentBlog->title }}">
                                                @endif
                                            </a>
                                            <div class="cs_recent_post_right">
                                                <div class="cs_post_meta cs_fs_14 cs_mb_9">
                                                    <i class="fa-solid fa-calendar-alt"></i>{{ $recentBlog->created_at->format('M d, Y') }}
                                                </div>
                                                <h3 class="cs_fs_16 cs_bold mb-0">
                                                    <a aria-label="Click to read post" href="{{ route('landing.blog-details', $recentBlog->slug) }}">{{ Str::limit($recentBlog->title, 50) }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">{{ __('No recent posts available') }}</p>
                            @endif
                        </div>
                        @php
                            // Get all unique tags from blogs
                            $allTags = [];
                            $blogsWithTags = \App\Models\Blog::where('parent_id', 0)
                                ->where('enabled', 1)
                                ->whereNotNull('tags')
                                ->pluck('tags')
                                ->toArray();
                            
                            foreach($blogsWithTags as $tagsString) {
                                if($tagsString) {
                                    $tags = explode(',', $tagsString);
                                    foreach($tags as $tag) {
                                        $tag = trim($tag);
                                        if($tag) {
                                            $allTags[] = $tag;
                                        }
                                    }
                                }
                            }
                            $allTags = array_unique($allTags);
                            $allTags = array_slice($allTags, 0, 10); // Limit to 10 tags
                        @endphp
                        @if(count($allTags) > 0)
                            <div class="cs_sidebar_widget cs_gray_bg cs_radius_10">
                                <div class="cs_sidebar_tags">
                                    <h3 class="cs_sidebar_widget_title cs_fs_22 cs_semibold cs_mb_22">Tags</h3>
                                    <div class="cs_tags_links cs_fs_14 cs_heading_color cs_heading_font">
                                        @foreach($allTags as $tag)
                                            <a href="{{ route('landing.blog', ['tag' => $tag]) }}" class="cs_tag_link cs_white_bg cs_radius_4 {{ request('tag') == $tag ? 'active' : '' }}">
                                                <span>{{ $tag }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
                <div class="col-xl-8 col-lg-7">
                    @if(request()->filled('search') || request()->filled('category') || request()->filled('tag'))
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <div>
                                    <h4 class="mb-0">{{ __('Filtered Results') }}</h4>
                                    @if(request()->filled('search'))
                                        <small class="text-muted">{{ __('Search:') }} "{{ request('search') }}"</small>
                                    @endif
                                    @if(request()->filled('category'))
                                        <small class="text-muted">{{ __('Category:') }} {{ request('category') }}</small>
                                    @endif
                                    @if(request()->filled('tag'))
                                        <small class="text-muted">{{ __('Tag:') }} {{ request('tag') }}</small>
                                    @endif
                                </div>
                                <a href="{{ route('landing.blog') }}" class="btn btn-sm btn-outline-secondary">{{ __('Clear Filters') }}</a>
                            </div>
                        </div>
                    @endif
                    <div class="row cs_row_gap_30 cs_gap_y_30">
                        @forelse($blogs as $blog)
                            <div class="col-md-6">
                                <article class="cs_post cs_style_1 cs_radius_20">
                            <a href="{{ route('landing.blog-details', $blog->slug) }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
                                @if(!empty($blog->image))
                                    @php
                                        $imageUrl = asset('storage/upload/blog/image/' . $blog->image);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $blog->title }}" onerror="this.src='{{ asset('landing/assets/img/post-img-1.jpg') }}'">
                                @else
                                    <img src="{{ asset('landing/assets/img/post-img-1.jpg') }}" alt="{{ $blog->title }}">
                                @endif
                                @if($blog->category)
                                    <span class="cs_post_category cs_heading_bg cs_fs_14 cs_medium cs_white_color position-absolute">{{ $blog->category }}</span>
                                @endif
                            </a>
                            <div class="cs_post_content">
                                <div class="cs_post_meta_wrapper cs_mb_12">
                                    @if($blog->author)
                                        <div class="cs_post_meta">
                                            <span><i class="fa-regular fa-user"></i></span>
                                            <span>{{ $blog->author }}</span>
                                        </div>
                                    @endif
                                    <div class="cs_post_meta">
                                        <span><i class="fa-solid fa-calendar-days"></i></span>
                                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <h3 class="cs_post_title cs_fs_24 cs_semibold cs_mb_13">
                                    <a href="{{ route('landing.blog-details', $blog->slug) }}" aria-label="Reading details post link">{{ $blog->title }}</a>
                                </h3>
                                @if($blog->description)
                                    <p class="cs_mb_13" style="color: #666; font-size: 14px;">{{ Str::limit($blog->description, 120) }}</p>
                                @endif
                                <a href="{{ route('landing.blog-details', $blog->slug) }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
                                    <span>Learn More</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                                </div>
                            </article>
                        </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center" style="padding: 60px 20px;">
                                    <h3 class="cs_fs_32 cs_semibold cs_mb_15">{{ __('No blog posts found.') }}</h3>
                                    <p class="text-muted">
                                        @if(request()->filled('search') || request()->filled('category') || request()->filled('tag'))
                                            {{ __('Try adjusting your search or filter criteria.') }}<br>
                                            <a href="{{ route('landing.blog') }}" class="cs_post_btn_wrapper btn btn-sm btn-primary mt-2">{{ __('View All Blogs') }}</a>
                                        @else
                                            {{ __('Check back soon for new articles and updates.') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @if($blogs->hasPages())
                        <div class="cs_height_60 cs_height_lg_50"></div>
                        <div class="d-flex justify-content-center">
                            {{ $blogs->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <!-- End Blog Section -->
        
        <!-- Start Scroll Up Button -->
        <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
  </svg>
  </button>
        <!-- End Scroll Up Button -->
    @endsection
