<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\General;

use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Koneko\VuexyWebsiteAdmin\Application\Template\WebsiteImageHandler;
use Koneko\VuexyAdmin\Application\Settings\Manager\KonekoSettingManager;
use Koneko\VuexyWebsiteAdmin\Application\LocalModule as WebsiteModule;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

final class FaviconCard extends Component
{
    use WithFileUploads;

    public WebsiteSite $site;

    /** Notificador */
    public string $targetNotify = '#website-favicon-card .notification-container';

    private const GROUP    = 'layout';
    private const SECTION  = 'website';
    private const SUBGROUP = 'favicon';

    // Previews
    public string $website_favicon_16x16 = '';
    public string $website_favicon_76x76 = '';
    public string $website_favicon_120x120 = '';
    public string $website_favicon_152x152 = '';
    public string $website_favicon_180x180 = '';
    public string $website_favicon_192x192 = '';

    /** Upload temporal (v3) */
    #[Rule(['nullable', 'image', 'mimes:jpeg,png,webp', 'max:20480'])]
    public $upload_image_favicon = null;

    public function mount(WebsiteSite $site): void
    {
        $this->site = $site;
        $this->loadForm();
    }

    private function settings(): KonekoSettingManager
    {
        return settings(WebsiteModule::class)
            ->context(self::GROUP, self::SECTION, self::SUBGROUP)
            ->scope($this->site);
    }

    public function loadForm(): void
    {
        $favicons = $this->settings()->asArray()->all();

        $fallback = '../vendor/vuexy-admin/img/logo/koneko-04.png';
        $basePath = WebsiteImageHandler::FAVICON_BASE_PATH;

        $this->upload_image_favicon   = null;
        $this->website_favicon_16x16   = isset($favicons['16x16'])   ? $basePath.$favicons['16x16']   : $fallback;
        $this->website_favicon_76x76   = isset($favicons['76x76'])   ? $basePath.$favicons['76x76']   : $fallback;
        $this->website_favicon_120x120 = isset($favicons['120x120']) ? $basePath.$favicons['120x120'] : $fallback;
        $this->website_favicon_152x152 = isset($favicons['152x152']) ? $basePath.$favicons['152x152'] : $fallback;
        $this->website_favicon_180x180 = isset($favicons['180x180']) ? $basePath.$favicons['180x180'] : $fallback;
        $this->website_favicon_192x192 = isset($favicons['192x192']) ? $basePath.$favicons['192x192'] : $fallback;
    }

    public function save(): void
    {
        $this->validate([
            'upload_image_favicon' => 'required|image|mimes:jpeg,png,webp|max:20480',
        ]);

        app(WebsiteImageHandler::class)
            ->processAndSaveFavicon($this->upload_image_favicon, $this->site);

        $this->loadForm();

        $this->dispatch('notification', target: $this->targetNotify, type: 'success', message: 'Favicon actualizado.');
    }

    public function resetForm(): void
    {
        $this->resetValidation();
        $this->loadForm();
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.sites.general.favicon-card');
    }
}
