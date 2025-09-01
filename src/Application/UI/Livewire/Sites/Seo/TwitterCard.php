<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Seo;

use Koneko\VuexyAdmin\Support\Media\Image\ImageCore;
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile\MetaMode;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteSeoProfile, WebsiteSite, WebsiteContent};
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

final class TwitterCard extends Component
{
    use WithFileUploads;

    public string $seoableType; // 'site' | 'content'
    public int    $seoableId;
    public bool   $isSite = false;

    public ?WebsiteSeoProfile $profile = null;

    // Modo
    #[Rule('string|in:inherit,override,disable')]
    public string $twitter_mode = 'inherit'; // para site lo forzamos luego a override|disable

    // Campos twitter
    public ?string $twitter_card    = 'summary_large_image'; // summary | summary_large_image
    public ?string $twitter_site    = null; // @sitio (opcional)
    public ?string $twitter_creator = null; // @autor (solo content)
    public ?string $twitter_image   = null;
    public ?string $twitter_url     = null;

    // Procesado (compartido con image-processor)
    #[Rule('in:cover,keep,contain')]
    public string $image_fit = 'cover';

    #[Rule('numeric|min:0.1|max:10')]
    public float $target_aspect = 1.91;

    #[Rule('numeric|min:10000|max:5000000')]
    public int $pixel_area = 334400; // 800x418 por defecto para X

    #[Rule('in:auto,jpg,webp,png')]
    public string $image_format = 'auto';

    #[Rule('integer|min:60|max:95')]
    public int $image_quality = 82;

    #[Rule(['nullable','image','mimes:jpeg,png,webp','max:20480'])]
    public $upload_twitter_image = null;

    public ?float $source_aspect = null;

    // UI helpers
    public array $cardOptions = [
        'summary'             => 'summary',
        'summary_large_image' => 'summary_large_image',
    ];
    public string $targetNotify = '#website-twitter-card .notification-container';

    public function mount(string $seoableType, int $seoableId): void
    {
        $this->seoableType = $seoableType;
        $this->seoableId   = $seoableId;
        $this->isSite      = $seoableType === 'site';

        $owner = $this->isSite
            ? WebsiteSite::query()->findOrFail($seoableId)
            : WebsiteContent::query()->findOrFail($seoableId);

        $scope = $this->isSite ? 'site' : 'content';
        $this->profile = $owner->seoProfile()->firstOrCreate([], ['scope' => $scope]);

        $this->loadForm();
    }

    public function loadForm(): void
    {
        $p = $this->profile;

        $this->twitter_mode = $p->twitter_mode->value;

        $this->twitter_card    = $p->twitter_card ?: 'summary_large_image';
        $this->twitter_site    = $p->twitter_site;
        $this->twitter_creator = $p->twitter_creator;
        $this->twitter_image   = $p->twitter_image;
        $this->twitter_url     = $p->twitter_url;

        // defaults de procesado (X)
        $this->image_fit     = 'cover';
        $this->target_aspect = $this->twitter_card === 'summary' ? 1.0 : 1.91;
        $this->pixel_area    = $this->twitter_card === 'summary' ? 256000 : 334400; // ej 512x500 vs 800x418
        $this->image_format  = 'auto';
        $this->image_quality = 82;

        $this->upload_twitter_image = null;
        $this->source_aspect = null;

        // En site no permitimos inherit
        if ($this->isSite && $this->twitter_mode === MetaMode::Inherit->value) {
            $this->twitter_mode = MetaMode::Override->value;
        }
    }

    /** Al subir imagen, forzamos override y calculamos aspecto origen */
    public function updatedUploadTwitterImage(): void
    {
        if (!$this->upload_twitter_image) return;

        if ($this->twitter_mode !== MetaMode::Override->value) {
            $this->twitter_mode = MetaMode::Override->value;
        }

        try {
            [$w,$h] = getimagesize($this->upload_twitter_image->getRealPath());
            if ($w && $h) $this->source_aspect = $w / max(1, $h);
        } catch (\Throwable) {
            $this->source_aspect = null;
        }
    }

    public function resetForm(): void
    {
        $this->profile->refresh();
        $this->loadForm();
        $this->resetValidation();
        $this->dispatch('notification', target: $this->targetNotify, type: 'info', message: 'Cambios descartados.');
    }

    public function save(): void
    {
        // URL absolutas
        $abs = fn (?string $u) => !$u || preg_match('#^https?://#i', $u);
        if (!$abs($this->twitter_url))   { $this->addError('twitter_url','URL debe ser absoluta (http/https).'); return; }
        if (!$abs($this->twitter_image)) { $this->addError('twitter_image','La imagen debe ser URL absoluta.'); return; }

        // Normaliza @
        $norm = fn(?string $h) => $h ? (str_starts_with($h,'@') ? $h : '@'.$h) : null;
        $this->twitter_site = $norm($this->twitter_site);
        $this->twitter_creator = $this->isSite ? null : $norm($this->twitter_creator);

        if ($this->twitter_mode === MetaMode::Disable->value) {
            // Deshabilitada: limpia (no guardar restos)
            $this->upload_twitter_image = null;
            //$this->twitter_image = null;
            $this->profile->fill([
                'twitter_mode'    => MetaMode::Disable->value,
            ])->save();

            $this->dispatch('notification', target: $this->targetNotify, type: 'success', message: 'Twitter Card deshabilitada.');
            return;
        }

        if (!$this->isSite && $this->twitter_mode === MetaMode::Inherit->value) {
            // Content heredando: no procesa ni requiere imagen
            $this->upload_twitter_image = null;
            $this->profile->fill([
                'twitter_mode' => MetaMode::Inherit->value,
            ])->save();

            $this->dispatch('notification', target: $this->targetNotify, type: 'success', message: 'Twitter Card heredando del sitio.');
            return;
        }

        // Habilitada / Sobrescribir ⇒ procesa si hay upload
        if ($this->upload_twitter_image) {
            $disk = config('koneko.media.default_disk', 'public');
            $core = app(ImageCore::class)->withDisk($disk)->forContext([
                'module' => 'website',
                'scope'  => $this->isSite ? 'site' : 'content',
                'owner'  => $this->seoableId,
            ]);

            $effectiveAspect = $this->image_fit === 'keep'
                ? ($this->source_aspect ?: (float) $this->target_aspect)
                : (float) $this->target_aspect;

            $path = $core->makeShare($this->upload_twitter_image, [
                'area'    => $this->pixel_area,
                'aspect'  => $effectiveAspect,
                'fit'     => $this->image_fit,   // 'cover'|'keep'|'contain'
                'format'  => $this->image_format,
                'quality' => $this->image_quality,
                'dirKey'  => 'share',
                'prefix'  => 'tw',
                'upscale' => false
            ]);

            try {
                $this->twitter_image = \Storage::disk($disk)->url($path);
            } catch (\Throwable) {
                $this->twitter_image = asset('storage/' . ltrim($path, '/'));
            }
        }

        // Requeridos mínimos solo si está habilitado/sobrescribe
        if (!filled($this->twitter_image)) {
            $this->addError('twitter_image', 'Proporciona una imagen o súbela.');
            return;
        }

        $this->profile->fill([
            'twitter_mode'    => MetaMode::Override->value, // “Habilitada” en website
            'twitter_card'    => $this->twitter_card,
            'twitter_site'    => $this->twitter_site ?: null,
            'twitter_creator' => $this->twitter_creator ?: null,
            'twitter_image'   => $this->twitter_image ?: null,
            'twitter_url'     => $this->twitter_url ?: null,
        ])->save();

        $this->dispatch('notification', target: $this->targetNotify, type: 'success', message: 'Twitter Card guardada.');
        $this->upload_twitter_image = null;
    }


    public function render()
    {
        return view('vuexy-website-admin::livewire.sites.seo.twitter-card');
    }
}
