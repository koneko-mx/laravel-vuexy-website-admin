<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Support\Facades\{Auth, URL};
use Koneko\VuexyAdmin\Support\Traits\Audit\{HasCreator, HasUpdater};
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteContentType;
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
        'type',
        'keywords',

        'title',
        'slug',

        'description',
        'author',
        'copyright',
        'canonical_url',
        'favicon_ns',
        'seo_profile_id',
        'template_id',

        'header_blocks',
        'content_blocks',
        'footer_blocks',

        'noindex',
        'nofollow',

        'schema_org',

        'locale',
        'geo_location',

        'og_type',
        'og_title',
        'og_description',
        'og_image',
        'og_url',
        'og_site_name',

        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_site',
        'twitter_creator',

        'json_ld',

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
        'type'           => WebsiteContentType::class,
        'keywords'       => 'array',
        'header_blocks'  => 'array',
        'content_blocks' => 'array',
        'footer_blocks'  => 'array',
        'is_draft'       => 'boolean',
        'is_sensitive'   => 'boolean',
        'is_partial'     => 'boolean',
        'roles'          => 'array',
        'permissions'    => 'array',
        'hide_if_authenticated' => 'boolean',
        'hide_if_guest'  => 'boolean',
        'visible_from'   => 'timestamp',
        'visible_until'  => 'timestamp',
        'enable_cache'   => 'boolean',
        'cache_ttl'      => 'integer',
    ];

    protected $auditInclude = [
    ];

    // ===================== RELACIONES =====================

    public function site() : BelongsTo
    {
        return $this->belongsTo(WebsiteSite::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(WebsiteTemplate::class);
    }

    public function seoProfile(): BelongsTo
    {
        return $this->belongsTo(WebsiteSeoProfile::class);
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

    public function getEffectiveTitle(?WebsiteSite $site = null): string
    {
        $titleDomain = $site?->title?? $this->site?->title?? config('app.name');

        return $titleDomain . ($this->title ? ' | ' . $this->title : '');
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
