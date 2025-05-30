<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Koneko\VuexyAdmin\Support\Traits\Audit\{HasCreator,HasUpdater};
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;
use Koneko\VuexyWebsiteAdmin\Website\Enums\WebsiteSiteStatus;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class WebsiteSite extends Model implements AuditableContract
{
    use HasVuexyModelMetadata;
    use Auditable;
    use HasCreator,
        HasUpdater;

    // ===================== METADATOS =====================

    public string $sortColumn        = 'name';
    public string $defaultSortOrder  = 'asc';
    public string $singularName      = 'sitio web';
    public string $focusColumnOnOpen = 'name';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'template',
        'status',
        'is_indexable',
        'seo_profile_id',
        'canonical_url',
        'config',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'status'       => WebsiteSiteStatus::class,
        'is_indexable' => 'boolean',
        'config'       => 'array',
    ];

    protected $auditInclude = [
        'name',
        'slug',
        'domain',
        'template',
        'status',
        'is_indexable',
        'seo_profile_id',
        'canonical_url',
        'config',
    ];

    // ===================== RELACIONES =====================

    public function menus(): HasMany
    {
        return $this->hasMany(WebsiteMenu::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(WebsiteContent::class);
    }

    public function seoProfiles(): BelongsTo
    {
        return $this->belongsTo(WebsiteSeoProfile::class);
    }

    // ===================== GETTERS =====================

    public function getDisplayName(): string
    {
        return $this->name;
    }
}
