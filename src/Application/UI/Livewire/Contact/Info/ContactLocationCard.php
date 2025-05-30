<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Contact\Info;

use Koneko\VuexyAdmin\Application\Settings\SettingsService;
use Koneko\VuexyWebsiteAdmin\Application\Services\WebsiteTemplateService;
use Livewire\Component;

class ContactLocationCard extends Component
{
    private $targetNotify = "#website-location-card-card .notification-container";

    public $direccion,
        $location_lat,
        $location_lng;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'direccion' => ['nullable', 'string', 'max:255'],
            'location_lat' => ['nullable', 'numeric'],
            'location_lng' => ['nullable', 'numeric'],
        ]);

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $location_lat = $this->location_lat? (float) $this->location_lat: null;
        $location_lng = $this->location_lng? (float) $this->location_lng: null;

        $SettingsService->set('contact.direccion', $this->direccion, null, 'vuexy-website-admin');
        $SettingsService->set('contact.location.lat', $location_lat, null, 'vuexy-website-admin');
        $SettingsService->set('contact.location.lng', $location_lng, null, 'vuexy-website-admin');

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
        $settings = app(WebsiteTemplateService::class)->getWebsiteVars('contact');

        $this->direccion    = $settings['direccion'];
        $this->location_lat = $settings['location']['lat'];
        $this->location_lng = $settings['location']['lng'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.contact.info.location-card');
    }
}
