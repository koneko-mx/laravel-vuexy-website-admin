<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Seo;

use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile\WebsiteSeoProfileScope;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteSeoProfile, WebsiteSite};
use Livewire\Attributes\Rule;
use Livewire\Component;

final class LocalLocationCard extends Component
{
    public WebsiteSite $site;
    public ?WebsiteSeoProfile $profile = null;

    #[Rule('boolean')] public bool $overwrite_locale = false;
    #[Rule('required|string|in:es-MX,es-ES,en-US,en-GB')] public string $locale = 'es-MX'; // ajusta a tus opciones

    public function mount(WebsiteSite $site): void
    {
        $this->site = $site;
        $this->profile = $site->seoProfile()->firstOrCreate([], [
            'scope' => WebsiteSeoProfileScope::Site->value,
        ]);
        $this->loadForm();
    }

    public function loadForm(): void
    {
        $p = $this->profile;
        $this->overwrite_locale = (bool) $p->overwrite_locale;
        $this->locale           = $p->locale ?? 'es-MX';
    }

    public function save(): void
    {
        $this->validate();
        $this->profile->fill([
            'overwrite_locale' => $this->overwrite_locale,
            'locale'           => $this->locale,
        ])->save();

        $this->dispatch('notification', target: '#website-local-location-card .notification-container', type: 'success', message: 'SEO (Idioma/Geo) guardado.');
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.sites.seo.local-location-card');
    }
}
