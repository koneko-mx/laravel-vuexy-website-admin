<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Koneko\VuexyAdmin\Support\Traits\Audit\HasCreator;
use Koneko\VuexyAdmin\Support\Traits\Model\HasVuexyModelMetadata;

class WebsiteContentVersion extends Model
{
    use HasVuexyModelMetadata;
    use HasCreator;

    // ===================== METADATOS =====================

    public string $sortColumn        = 'version_label';
    public string $defaultSortOrder  = 'desc';
    public string $singularName      = 'versión';
    public string $focusColumnOnOpen = 'version_label';

    // ===================== CONFIGURACIÓN =====================

    protected $fillable = [
        'website_content_id',
        'version_label',
        'content',
        'is_current',
        'metadata',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // ===================== RELACIONES =====================

    public function content(): BelongsTo
    {
        return $this->belongsTo(WebsiteContent::class, 'website_content_id');
    }


    // ===================== GETTERS =====================

    public function getDisplayName(): string
    {
        return $this->version_label;
    }
}
