<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Settings\General;

use Livewire\Component;
use Koneko\VuexyAdmin\Application\Settings\SettingsService;
use Koneko\VuexyWebsiteAdmin\Application\Services\WebsiteTemplateService;

class WebsiteDescriptionCard extends Component
{
    private $targetNotify = "#website-description-card-card .notification-container";

    public $title;

    public function mount()
    {
        $this->loadForm();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('website.title', $this->title, null, 'vuexy-website-admin');
        $SettingsService->set('website.description', $this->description, null, 'vuexy-website-admin');

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

        //$this->title       = $settings['title'];
        //$this->description = $settings['description'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.settings.general.website-description-card');
    }
}
