<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class SitemapIndexFile extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'sitemap_profile_id',
        'file_name',
        'url',
        'generated_at',
        'url_count',
        'is_current',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'is_current' => 'boolean',
    ];

    protected $auditInclude = [
        'file_name',
        'url',
        'generated_at',
        'url_count',
        'is_current',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(SitemapProfile::class, 'sitemap_profile_id');
    }
}
