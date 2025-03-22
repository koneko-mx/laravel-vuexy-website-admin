<?php

namespace Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin;

use Koneko\VuexyAdmin\Services\SettingsService;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteTemplateService;
use Livewire\Component;

class ContactFormSettings extends Component
{
    private $targetNotify = "#website-contact-form-settings-card .notification-container";

    public $to_email,
        $to_email_cc,
        $subject,
        $submit_message;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'to_email' => 'required|email',
            'to_email_cc' => 'nullable|email',
            'subject' => 'required|string',
            'submit_message' => 'required|string'
        ]);

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('contact.form.to_email', $this->to_email, null, 'vuexy-website-admin');
        $SettingsService->set('contact.form.to_email_cc', $this->to_email_cc, null, 'vuexy-website-admin');
        $SettingsService->set('contact.form.subject', $this->subject, null, 'vuexy-website-admin');
        $SettingsService->set('contact.form.submit_message', $this->submit_message, null, 'vuexy-website-admin');

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

        $this->to_email       = $settings['form']['to_email'];
        $this->to_email_cc    = $settings['form']['to_email_cc'];
        $this->subject        = $settings['form']['subject'];
        $this->submit_message = $settings['form']['submit_message'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.vuexy.contact-form-settings');
    }
}
