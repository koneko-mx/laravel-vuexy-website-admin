<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Koneko\VuexyAdmin\Support\Traits\Audit\{HasCreator, HasUpdater};
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class WebsiteContentBlock extends Model implements AuditableContract
{
    use HasVuexyModelMetadata;
    use Auditable;
    use HasCreator,
        HasUpdater;

    // ===================== METADATOS =====================

    public string $sortColumn        = 'title';
    public string $defaultSortOrder  = 'asc';
    public string $singularName      = 'contenido web';
    public string $focusColumnOnOpen = 'title';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'content_id',
        'parent_id',
        'slug',
        'type',
        'mode',
        'view',
        'view_path',
        'component_class',
        'is_enabled',
        'enable_cache',
        'cache_ttl',
        'settings',
        'data',
        'order'
    ];

    protected $casts = [
        'settings'       => 'array',
        'data' => 'array',
        'is_enabled'     => 'boolean',
        'enable_cache'   => 'boolean',
        'cache_ttl'      => 'integer',
    ];

    protected $auditInclude = [
        'content_id',
        'parent_id',
        'slug',
        'type',
        'mode',
        'view',
        'view_path',
        'component_class',
        'is_enabled',
        'enable_cache',
        'cache_ttl',
        'settings',
        'data',
        'order',
    ];


    // ===================== RELACIONES =====================

    public function content() : BelongsTo
    {
        return $this->belongsTo(WebsiteContent::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(WebsiteContentBlock::class, 'parent_id');
    }

    public function versions() : HasMany
    {
        return $this->hasMany(WebsiteContentVersion::class);
    }

    // ===================== GETTERS =====================

    public function getDisplayName(): string
    {
        return $this->title;
    }

    public function getEffectiveSeoMetadata(): array
    {
        $base = $this->seoProfile?->getMetaTags() ?? [];

        return array_merge($base, $this->seo_overrides ?? []);
    }

    public function getCanonicalUrl(): ?string
    {
        return $this->canonical_url ?: ($this->seoProfile->og_url ?? null);
    }

    public function toHtml(): string
    {
        return view('website::templates.' . ($this->template ?? 'default'), [
            'content' => $this,
        ])->render();
    }

    // ===================== SCOPES =====================

    public function scopePublished($query) : Builder
    {
        return $query
            ->where('is_draft', false)
            ->where(function ($q) {
                $q->whereNull('visible_from')->orWhere('visible_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('visible_until')->orWhere('visible_until', '>=', now());
            });
    }

    public function scopeBySlug($query, string $slug) : Builder
    {
        return $query->where('slug', $slug);
    }

    public function scopeDraft($query) : Builder
    {
        return $query->where('is_draft', true);
    }


    // ===================== PREVIEW =====================

    public function previewUrl(?int $userId = null, int $ttl = 30): string
    {
        return URL::temporarySignedRoute(
            'website.preview',
            now()->addMinutes($ttl),
            [
                'slug' => $this->slug,
                'user_id' => $userId ?? Auth::id()
            ]
        );
    }

}
