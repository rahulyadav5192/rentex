<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        // Cache sitemap for 1 hour, but invalidate when blogs change
        $sitemap = Cache::remember('sitemap_xml', 3600, function () {
            return $this->generateSitemap();
        });

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function generateSitemap()
    {
        $baseUrl = config('app.url');
        $now = now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages - High priority
        $staticPages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('landing.about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('landing.services'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('landing.service-details'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('landing.pricing'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('landing.contact'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('landing.faqs'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('landing.blog'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => route('landing.team'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('landing.team-details'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        // Service detail pages
        $servicePages = [
            route('landing.service.property-automation'),
            route('landing.service.tenant-management'),
            route('landing.service.rent-billing'),
            route('landing.service.maintenance-tasks'),
            route('landing.service.lease-contract'),
            route('landing.service.visibility-reports'),
        ];

        foreach ($staticPages as $page) {
            $xml .= $this->addUrl($page['url'], $page['priority'], $page['changefreq'], $now);
        }

        foreach ($servicePages as $serviceUrl) {
            $xml .= $this->addUrl($serviceUrl, '0.7', 'monthly', $now);
        }

        // Blog posts - Dynamic, updated when blogs change
        $blogs = Blog::where('parent_id', 0)
            ->where('enabled', 1)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($blogs as $blog) {
            $lastmod = $blog->updated_at ? $blog->updated_at->toAtomString() : $now;
            $xml .= $this->addUrl(
                route('landing.blog-details', $blog->slug),
                '0.8',
                'weekly',
                $lastmod
            );
        }

        // User-specific pages (web/{code} routes) - Only include if there are active users
        $users = \App\Models\User::where('type', 'owner')
            ->where('parent_id', 0)
            ->where('is_active', 1)
            ->get();

        foreach ($users as $user) {
            if ($user->code) {
                $xml .= $this->addUrl(
                    route('web.page', $user->code),
                    '0.6',
                    'weekly',
                    $now
                );
                
                // Add user's blog page if they have blogs
                $userBlogs = Blog::where('parent_id', $user->id)
                    ->where('enabled', 1)
                    ->count();
                
                if ($userBlogs > 0) {
                    $xml .= $this->addUrl(
                        route('blog.home', $user->code),
                        '0.7',
                        'weekly',
                        $now
                    );
                }
            }
        }

        $xml .= '</urlset>';

        return $xml;
    }

    private function addUrl($url, $priority, $changefreq, $lastmod)
    {
        return "  <url>\n" .
               "    <loc>" . htmlspecialchars($url, ENT_XML1, 'UTF-8') . "</loc>\n" .
               "    <lastmod>" . htmlspecialchars($lastmod, ENT_XML1, 'UTF-8') . "</lastmod>\n" .
               "    <changefreq>" . htmlspecialchars($changefreq, ENT_XML1, 'UTF-8') . "</changefreq>\n" .
               "    <priority>" . htmlspecialchars($priority, ENT_XML1, 'UTF-8') . "</priority>\n" .
               "  </url>\n";
    }

    /**
     * Clear sitemap cache (called when blogs are updated)
     */
    public static function clearCache()
    {
        Cache::forget('sitemap_xml');
    }
}
