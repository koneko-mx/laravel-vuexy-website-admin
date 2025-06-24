<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Koneko\VuexyAdmin\Support\Traits\Audit\{HasCreator,HasUpdater};
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile\WebsiteSeoProfileType;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class WebsiteSeoProfile extends Model implements AuditableContract
{
    use HasVuexyModelMetadata;
    use Auditable;
    use HasCreator,
        HasUpdater;

    // ===================== METADATOS =====================

    public string $sortColumn        = 'title';
    public string $defaultSortOrder  = 'asc';
    public string $singularName      = 'perfil SEO';
    public string $focusColumnOnOpen = 'title';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'title',
        'slug',
        'type',
        'keywords',
        'description',

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
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'type'          => WebsiteSeoProfileType::class,
        'keywords'      => 'array',
        'schema_org'    => 'array',
        'geo_location'  => 'array',
        'json_ld'       => 'array',
    ];

    protected $auditInclude = [
        'title',
        'slug',
        'type',
        'keywords',
        'description',
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
];

    // ===================== RELACIONES =====================

    public function site(): BelongsTo
    {
        return $this->belongsTo(WebsiteSite::class);
    }

    // ===================== GETTERS =====================

    public function getMetaTags(): array
    {
        return [
            //'robots'      => ($this->noindex ? 'noindex' : 'index') . ', ' . ($this->nofollow ? 'nofollow' : 'follow'),
            'og'          => [
                'type'        => $this->og_type,
                'title'       => $this->og_title,
                'description' => $this->og_description,
                'image'       => $this->og_image,
                'url'         => $this->og_url,
                'site_name'   => $this->og_site_name,
            ],
            'twitter'     => [
                'card'        => $this->twitter_card,
                'title'       => $this->twitter_title,
                'description' => $this->twitter_description,
                'image'       => $this->twitter_image,
                'site'        => $this->twitter_site,
                'creator'     => $this->twitter_creator,
            ]
        ];
    }

    public function toJsonLd(): array
    {
        return $this->json_ld ?? [];
    }
}
