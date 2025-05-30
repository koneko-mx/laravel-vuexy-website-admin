<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class SitemapUrl extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'sitemap_profile_id',
        'url',
        'changefreq',
        'priority',
        'lastmod',
        'is_active',
        'alternate_locales',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lastmod' => 'datetime',
        'alternate_locales' => 'array',
        'priority' => 'float',
    ];

    protected $auditInclude = [
        'url',
        'changefreq',
        'priority',
        'lastmod',
        'is_active',
        'alternate_locales',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(SitemapProfile::class, 'sitemap_profile_id');
    }
}
