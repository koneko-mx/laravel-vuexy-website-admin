<?php

namespace Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteSettingsService;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteTemplateService;

class WebsiteFaviconSettings extends Component
{
    use WithFileUploads;

    private $targetNotify = "#website-favicon-settings-card .notification-container";

    public $website_favicon_16x16,
        $website_favicon_76x76,
        $website_favicon_120x120,
        $website_favicon_152x152,
        $website_favicon_180x180,
        $website_favicon_192x192;

    public $upload_image_favicon;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'upload_image_favicon' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:20480',
        ]);

        // Procesar favicon
        app(WebsiteSettingsService::class)->processAndSaveFavicon($this->upload_image_favicon);

        // Limpiar cache de plantilla
        app(WebsiteTemplateService::class)->clearWebsiteVarsCache();

        // Recargamos el formulario
        $this->resetForm();

        // Notificación de éxito
        $this->dispatch(
            'notification',
            target: $this->targetNotify,
            type: 'success',
            message: 'Se han guardado los cambios en las configuraciones.'
        );
    }

    public function resetForm()
    {
        // Obtener los valores de las configuraciones de la base de datos
        $settings = app(WebsiteTemplateService::class)->getWebsiteVars();

        $this->upload_image_favicon    = null;
        $this->website_favicon_16x16   = $settings['favicon']['16x16'];
        $this->website_favicon_76x76   = $settings['favicon']['76x76'];
        $this->website_favicon_120x120 = $settings['favicon']['120x120'];
        $this->website_favicon_152x152 = $settings['favicon']['152x152'];
        $this->website_favicon_180x180 = $settings['favicon']['180x180'];
        $this->website_favicon_192x192 = $settings['favicon']['192x192'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.vuexy.website-favicon-settings');
    }
}
