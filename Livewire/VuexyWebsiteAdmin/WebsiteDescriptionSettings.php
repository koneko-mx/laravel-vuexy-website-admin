<?php

namespace Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin;

use Livewire\Component;
use Koneko\VuexyAdmin\Services\SettingsService;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteTemplateService;

class WebsiteDescriptionSettings extends Component
{
    private $targetNotify = "#website-description-settings-card .notification-container";

    public $title,
        $description;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('website.title', $this->title, null, 'vuexy-website-admin');
        $SettingsService->set('website.description', $this->description, null, 'vuexy-website-admin');

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

        $this->title       = $settings['title'];
        $this->description = $settings['description'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.vuexy.website-description-settings');
    }
}
