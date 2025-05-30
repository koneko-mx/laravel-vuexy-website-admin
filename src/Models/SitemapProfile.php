<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class SitemapProfile extends Model implements AuditableContract
{
    use HasVuexyModelMetadata,
        Auditable;

    protected $fillable = [
        'site_id',
        'name',
        'slug',
        'entity_type',
        'generator_class',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $auditInclude = [
        'site_id',
        'name',
        'slug',
        'entity_type',
        'generator_class',
        'is_active',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(WebsiteSite::class);
    }

    public function rules(): HasMany
    {
        return $this->hasMany(SitemapRule::class);
    }

    public function urls(): HasMany
    {
        return $this->hasMany(SitemapUrl::class);
    }

    public function indexFiles(): HasMany
    {
        return $this->hasMany(SitemapIndexFile::class);
    }
}
