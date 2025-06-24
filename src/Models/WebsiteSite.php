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

    public string $sortColumn        = 'domain';
    public string $defaultSortOrder  = 'asc';
    public string $singularName      = 'sitio web';
    public string $focusColumnOnOpen = 'domain';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'domain',
        'keywords',
        'title',
        'description',
        'author',
        'copyright',
        'noindex',
        'nofollow',
        'allow_overwrite_robots',
        'force_https',
        'www_alias',
        'template_id',
        'config',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'status' => WebsiteSiteStatus::class,
        'keywords' => 'array',
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
        'allow_overwrite_robots' => 'boolean',
        'force_https' => 'boolean',
        'config' => 'array',
    ];

    protected $auditInclude = [
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

    public function template(): BelongsTo
    {
        return $this->belongsTo(WebsiteTemplate::class);
    }

    // ===================== GETTERS =====================

    public function getDisplayName(): string
    {
        return $this->domain;
    }
}
