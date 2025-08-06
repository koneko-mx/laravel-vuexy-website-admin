<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Koneko\VuexyAdmin\Support\Traits\Audit\{HasCreator,HasUpdater};
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;

class WebsiteTemplate extends Model
{
    use HasVuexyModelMetadata;
    use HasCreator,
        HasUpdater;

    // ===================== METADATOS =====================

    public string $sortColumn        = 'title';
    public string $defaultSortOrder  = 'asc';
    public string $singularName      = 'plantilla';
    public string $focusColumnOnOpen = 'title';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'title',
        'slug',
        'package',
        'layout',
        'theme_color',
        'favicon',
        'config',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'favicon' => 'array',
        'config'  => 'array',
        'is_active' => 'boolean',
    ];
}
