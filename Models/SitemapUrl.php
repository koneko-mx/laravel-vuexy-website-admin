<?php

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'changefreq',
        'priority',
        'lastmod',
        'is_active',
    ];
}