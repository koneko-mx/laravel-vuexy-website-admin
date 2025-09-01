<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Seo;

use Koneko\VuexyWebsiteAdmin\Models\{WebsiteSeoProfile, WebsiteSite, WebsiteContent};
use Livewire\Attributes\Rule;
use Livewire\Component;

final class LocaleCard extends Component
{
    public string $seoableType;   // 'site' | 'content'
    public int    $seoableId;
    public bool   $isSite = false;

    public ?WebsiteSeoProfile $profile = null;

    #[Rule('string|in:inherit,override,disable')]
    public string $locale_mode = 'inherit'; // default para Content; Site se corrige en mount()

    #[Rule('required|string|in:es-MX,es-ES,en-US,en-GB')]
    public string $locale = 'es-MX';

    public array $localeOptions = [
        'es-MX' => 'Español (MX)',
        'es-ES' => 'Español (ES)',
        'en-US' => 'English (US)'
    ];

    public string $targetNotify = '#website-seo-locale-card .notification-container';

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

        $this->locale_mode = $p->locale_mode->value;
        $this->locale      = $p->locale;
    }

    public function save(): void
    {
        $this->validate();

        $this->profile->fill([
            'locale_mode' => $this->locale_mode,
            'locale'      => $this->locale,
        ])->save();

        $this->dispatch('notification', target: $this->targetNotify, type: 'success', message: 'SEO (Idioma/Geo) guardado.');
    }

    public function resetForm(): void
    {
        $this->profile->refresh();
        $this->loadForm();
        $this->resetValidation();
        $this->dispatch('notification', target: $this->targetNotify, type: 'info', message: 'Cambios descartados.');
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.sites.seo.locale-card');
    }
}
