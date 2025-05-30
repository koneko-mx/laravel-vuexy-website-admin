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

class WebsiteContent extends Model implements AuditableContract
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
        'site_id',
        'seo_profile_id',
        'title',
        'slug',
        'description',
        'keywords',
        'template',
        'template_variant',
        'type',
        'render_mode',
        'block_mode',
        'resource',
        'render_as',
        'canonical_url',
        'content_blocks',
        'seo_overrides',
        'is_draft',
        'is_sensitive',
        'is_partial',
        'roles',
        'permissions',
        'hide_if_authenticated',
        'hide_if_guest',
        'visible_from',
        'visible_until',
        'enable_cache',
        'cache_ttl',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'keywords'       => 'array',
        'content_blocks' => 'array',
        'seo_overrides'  => 'array',
        'roles'          => 'array',
        'permissions'    => 'array',
        'is_draft'       => 'boolean',
        'is_sensitive'   => 'boolean',
        'is_partial'     => 'boolean',
        'hide_if_authenticated' => 'boolean',
        'hide_if_guest'  => 'boolean',
        'visible_from'   => 'timestamp',
        'visible_until'  => 'timestamp',
        'enable_cache'   => 'boolean',
        'cache_ttl'      => 'integer',
    ];

    protected $auditInclude = [
        'site_id',
        'seo_profile_id',
        'title',
        'slug',
        'description',
        'keywords',
        'template',
        'template_variant',
        'type',
        'render_mode',
        'block_mode',
        'resource',
        'render_as',
        'canonical_url',
        'content_blocks',
        'seo_overrides',
        'is_draft',
        'is_sensitive',
        'is_partial',
        'roles',
        'permissions',
        'hide_if_authenticated',
        'hide_if_guest',
        'visible_from',
        'visible_until',
        'enable_cache',
        'cache_ttl',
    ];

    // ===================== RELACIONES =====================

    public function site() : BelongsTo
    {
        return $this->belongsTo(WebsiteSite::class);
    }

    public function seoProfile() : BelongsTo
    {
        return $this->belongsTo(WebsiteSeoProfile::class, 'seo_profile_id');
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
