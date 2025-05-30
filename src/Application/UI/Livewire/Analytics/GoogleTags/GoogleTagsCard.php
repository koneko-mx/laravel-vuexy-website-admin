<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Analytics\GoogleTags;

use Koneko\VuexyAdmin\Application\Settings\SettingsService;
use Koneko\VuexyWebsiteAdmin\Application\Services\WebsiteTemplateService;
use Livewire\Component;

class GoogleTagsCard extends Component
{
    private $targetNotify = "#website-analytics-settings-card .notification-container";

    public $google_analytics_enabled,
        $google_analytics_id;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        if ($this->google_analytics_enabled) {
            $this->validate([
                'google_analytics_id' => 'required|string|min:12|max:30',
            ]);
        }

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('google.analytics_enabled', $this->google_analytics_enabled, null, 'vuexy-website-admin');
        $SettingsService->set('google.analytics_id', $this->google_analytics_id, null, 'vuexy-website-admin');

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
        $settings = app(WebsiteTemplateService::class)->getWebsiteVars('google');

        $this->google_analytics_enabled = $settings['analytics']['enabled'];
        $this->google_analytics_id      = $settings['analytics']['id'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.analytics.google-tags.google-tags-card');
    }
}
