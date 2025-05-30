<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Settings\General;

use Livewire\Component;
use Livewire\WithFileUploads;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteSettingsService;
use Koneko\VuexyWebsiteAdmin\Application\Services\WebsiteTemplateService;

class LogoOnDarkBgCard extends Component
{
    use WithFileUploads;

    private $targetNotify = "#logo-on-dark-bg-card-card .notification-container";

    public $website_image_logo_dark,
        $upload_image_logo_dark;

    public function mount()
    {
        $this->loadForm();
    }

    public function save()
    {
        $this->validate([
            'upload_image_logo_dark' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:20480',
        ]);

        // Procesar favicon si se ha cargado una imagen
        app(WebsiteSettingsService::class)->processAndSaveImageLogo($this->upload_image_logo_dark, 'dark');

        // Limpiar cache de plantilla
        app(WebsiteTemplateService::class)->clearWebsiteVarsCache();

        // Recargamos el formulario
        $this->loadForm();

        // Notificación de éxito
        $this->dispatch(
            'notification',
            target: $this->targetNotify,
            type: 'success',
            message: 'Se han guardado los cambios en las configuraciones.'
        );
    }

    public function loadForm()
    {
        // Obtener los valores de las configuraciones de la base de datos
        //$settings = app(WebsiteTemplateService::class)->getWebsiteVars();

        $this->upload_image_logo_dark = null;
        //$this->website_image_logo_dark  = $settings['image_logo']['large_dark'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.settings.general.logo-on-dark-bg-card');
    }
}
