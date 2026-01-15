<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\SitemapController;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'description',
        'content',
        'image',
        'category',
        'tags',
        'author',
        'views',
        'enabled',
        'parent_id',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear sitemap cache when blog is created, updated, or deleted
        static::saved(function ($blog) {
            SitemapController::clearCache();
        });

        static::deleted(function ($blog) {
            SitemapController::clearCache();
        });
    }
}
