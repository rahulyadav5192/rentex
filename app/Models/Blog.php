<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
