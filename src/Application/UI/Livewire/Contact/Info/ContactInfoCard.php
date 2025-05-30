<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Contact\Info;

use Koneko\VuexyAdmin\Application\Settings\SettingsService;
use Koneko\VuexyWebsiteAdmin\Application\Services\WebsiteTemplateService;
use Livewire\Component;

class ContactInfoCard extends Component
{
    private $targetNotify = "#website-contact-info-card-card .notification-container";

    public $phone_number,
        $phone_number_ext,
        $phone_number_2,
        $phone_number_2_ext,
        $email,
        $horario;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'phone_number' => 'nullable|string',
            'phone_number_ext' => 'nullable|string',
            'phone_number_2' => 'nullable|string',
            'phone_number_2_ext' => 'nullable|string',
            'email' => 'nullable|email',
            'horario' => 'nullable|string',
        ]);

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('contact.phone_number', $this->phone_number, null, 'vuexy-website-admin');
        $SettingsService->set('contact.phone_number_ext', $this->phone_number_ext, null, 'vuexy-website-admin');
        $SettingsService->set('contact.phone_number_2', $this->phone_number_2, null, 'vuexy-website-admin');
        $SettingsService->set('contact.phone_number_2_ext', $this->phone_number_2_ext, null, 'vuexy-website-admin');
        $SettingsService->set('contact.email', $this->email, null, 'vuexy-website-admin');
        $SettingsService->set('contact.horario', $this->horario, null, 'vuexy-website-admin');

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

        $this->phone_number       = $settings['phone_number'];
        $this->phone_number_ext   = $settings['phone_number_ext'];
        $this->phone_number_2     = $settings['phone_number_2'];
        $this->phone_number_2_ext = $settings['phone_number_2_ext'];
        $this->email              = $settings['email'];
        $this->horario            = $settings['horario'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.contact.info.contact-info-card');
    }
}
