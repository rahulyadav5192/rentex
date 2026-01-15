@extends('landing.layout')

@section('page-title', $blog->meta_title ?? $blog->title)
@section('meta-description', $blog->meta_description ?? Str::limit(strip_tags($blog->content), 160))
@section('meta-keywords', $blog->tags ?? 'property management, tenant management, real estate')
@section('og-title', $blog->title)
@if(!empty($blog->image))
    @php
        $ogImage = asset('storage/upload/blog/image/' . $blog->image);
    @endphp
    @section('og-image', $ogImage)
@endif

@section('content')
<!-- Start Page Heading -->
    <section class="cs_page_heading cs_style_hero text-center position-relative">
        <div class="cs_page_heading_content cs_bg_filed cs_radius_50 position-relative z-1" data-src="{{ asset('landing/assets/img/page-heading-bg.svg') }}">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold cs_mb_8">{{ $blog->title }}</h1>
            <ol class="breadcrumb cs_fs_18 cs_heading_font">
                <li class="breadcrumb-item"><a aria-label="Back to home page link" href="/">Home</a></li>
                <li class="breadcrumb-item"><a aria-label="Back to blog page link" href="{{ route('landing.blog') }}">Blog</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($blog->title, 30) }}</li>
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
    <!-- Start Blog Details Section -->
    <section>
        <div class="cs_height_120 cs_height_lg_80"></div>
        <div class="container">
            <div class="row cs_row_gap_30 cs_gap_y_60">
                <aside class="col-xl-4 col-lg-5">
                    <div class="cs_sidebar cs_style_1 cs_type_1">
                        <div class="cs_sidebar_widget cs_gray_bg cs_radius_10">
                            <h3 class="cs_sidebar_widget_title cs_fs_22 cs_semibold cs_mb_22">Search</h3>
                            <form action="{{ route('landing.blog') }}" method="GET" class="cs_search cs_white_bg position-relative">
                                <input type="text" name="search" placeholder="Search here" value="{{ request('search') }}">
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
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('landing.blog', ['category' => $category->category]) }}">
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
                                    ->where('id', '!=', $blog->id)
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
                        @if($blog->tags)
                        <div class="cs_sidebar_widget cs_gray_bg cs_radius_10">
                            <div class="cs_sidebar_tags">
                                <h3 class="cs_sidebar_widget_title cs_fs_22 cs_semibold cs_mb_22">Tags</h3>
                                <div class="cs_tags_links cs_fs_14 cs_heading_color cs_heading_font">
                                        @php
                                            $tags = explode(',', $blog->tags);
                                        @endphp
                                        @foreach($tags as $tag)
                                            @if(trim($tag))
                                                <a href="{{ route('landing.blog', ['tag' => trim($tag)]) }}" class="cs_tag_link cs_white_bg cs_radius_4">
                                                    <span>{{ trim($tag) }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
                <div class="col-xl-8 col-lg-7">
                    <div class="cs_post_details">
                        <div class="cs_post_banner cs_radius_10 cs_mb_40 position-relative">
                            @if(!empty($blog->image))
                                @php
                                    $bannerImageUrl = asset('storage/upload/blog/image/' . $blog->image);
                                @endphp
                                <img src="{{ $bannerImageUrl }}" alt="{{ $blog->title }}" onerror="this.src='{{ asset('landing/assets/img/post-img-10.jpg') }}'">
                            @else
                                <img src="{{ asset('landing/assets/img/post-img-10.jpg') }}" alt="{{ $blog->title }}">
                            @endif
                            <div class="cs_posted_by cs_center_column cs_heading_font cs_radius_8 position-absolute">
                                <span class="cs_fs_24 cs_bold cs_white_color">{{ $blog->created_at->format('d') }}</span>
                                <span class="cs_fs_12 cs_white_color">{{ $blog->created_at->format('M') }}</span>
                            </div>
                        </div>
                        <div class="cs_post_meta_wrapper cs_mb_17">
                            @if($blog->author)
                            <div class="cs_post_meta">
                                <span class="cs_blue_color"><i class="fa-regular fa-user"></i></span>
                                    <span class="cs_heading_color">{{ $blog->author }}</span>
                            </div>
                            @endif
                            <div class="cs_post_meta">
                                <span class="cs_blue_color"><i class="fa-solid fa-eye"></i></span>
                                <span class="cs_heading_color">{{ $blog->views ?? 0 }} {{ __('Views') }}</span>
                            </div>
                            @if($blog->category)
                            <div class="cs_post_meta">
                                <span class="cs_blue_color"><i class="fa-solid fa-tag"></i></span>
                                    <span class="cs_heading_color">{{ $blog->category }}</span>
                            </div>
                            @endif
                        </div>
                        <h2>{{ $blog->title }}</h2>
                        @if($blog->description)
                            <p class="lead">{{ $blog->description }}</p>
                        @endif
                        <div class="blog-content">
                            {!! $blog->content !!}
                        </div>
                        <div class="cs_post_share_wrapper">
                            @if($blog->tags)
                            <div class="cs_post_tags cs_style_1">
                                <h3 class="cs_fs_16 cs_semibold">Tags:</h3>
                                <div class="cs_tags_links cs_fs_14 cs_heading_color cs_heading_font">
                                        @php
                                            $tags = explode(',', $blog->tags);
                                        @endphp
                                        @foreach($tags as $tag)
                                            @if(trim($tag))
                                                <a href="{{ route('landing.blog', ['tag' => trim($tag)]) }}" class="cs_tag_link cs_white_bg">
                                                    <span>{{ trim($tag) }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="cs_post_socials">
                                <h3 class="cs_fs_16 cs_semibold">Share:</h3>
                                <div class="cs_social_links cs_style_2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($blog->title) }}" target="_blank" rel="noopener">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                    <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode(url()->current()) }}" target="_blank" rel="noopener">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($relatedBlogs && $relatedBlogs->count() > 0)
                    <div class="cs_height_70 cs_height_lg_60"></div>
                        <div class="cs_related_posts">
                            <h2 class="cs_fs_24 cs_mb_30">{{ __('Related Posts') }}</h2>
                            <div class="row cs_row_gap_30 cs_gap_y_30">
                                @foreach($relatedBlogs as $relatedBlog)
                                    <div class="col-md-4">
                                        <article class="cs_post cs_style_1 cs_radius_20">
                                            <a href="{{ route('landing.blog-details', $relatedBlog->slug) }}" aria-label="Reading details post link" class="cs_post_thumbnail cs_mb_15 position-relative overflow-hidden">
                                                @if(!empty($relatedBlog->image))
                                                    @php
                                                        $relatedImageUrl = asset('storage/upload/blog/image/' . $relatedBlog->image);
                                                    @endphp
                                                    <img src="{{ $relatedImageUrl }}" alt="{{ $relatedBlog->title }}" onerror="this.src='{{ asset('landing/assets/img/post-img-1.jpg') }}'">
                                                @else
                                                    <img src="{{ asset('landing/assets/img/post-img-1.jpg') }}" alt="{{ $relatedBlog->title }}">
                                                @endif
                                            </a>
                                            <div class="cs_post_content">
                                                <h3 class="cs_post_title cs_fs_18 cs_semibold cs_mb_13">
                                                    <a href="{{ route('landing.blog-details', $relatedBlog->slug) }}" aria-label="Reading details post link">{{ Str::limit($relatedBlog->title, 60) }}</a>
                                                </h3>
                                                <a href="{{ route('landing.blog-details', $relatedBlog->slug) }}" aria-label="Reading details post link" class="cs_post_btn cs_heading_color">
                                                    <span>Read More</span>
                                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                                </a>
                                </div>
                                        </article>
                                    </div>
                                @endforeach
                                </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="cs_height_120 cs_height_lg_80"></div>
    </section>
    <!-- End Blog Details Section -->
    
    <!-- Start Scroll Up Button -->
    <button type="button" aria-label="Scroll to top button" class="cs_scrollup cs_purple_bg cs_white_color cs_radius_100">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 10L1.7625 11.7625L8.75 4.7875V20H11.25V4.7875L18.225 11.775L20 10L10 0L0 10Z" fill="currentColor" />
      </svg>
    </button>
    <!-- End Scroll Up Button -->
    
    @endsection
