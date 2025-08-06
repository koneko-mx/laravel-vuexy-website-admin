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

    public string $sortColumn        = 'slug';
    public string $defaultSortOrder  = 'asc';
    public string $singularName      = 'bloque de contenido';
    public string $focusColumnOnOpen = 'slug';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'slug',
        'description',
        'data',
        'settings',
        'enable_cache',
        'cache_ttl',
    ];

    protected $casts = [
        'data'         => 'array',
        'settings'     => 'array',
        'enable_cache' => 'boolean',
    ];

    protected $auditInclude = [
        'slug',
        'description',
        'data',
        'settings',
        'enable_cache',
        'cache_ttl',
    ];

    public function versions() : HasMany
    {
        return $this->hasMany(WebsiteContentVersion::class);
    }

    // ===================== GETTERS =====================

    public function getDisplayName(): string
    {
        return $this->slug;
    }

}
