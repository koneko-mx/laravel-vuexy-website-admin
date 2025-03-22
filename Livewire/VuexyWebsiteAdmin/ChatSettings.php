<?php

namespace Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin;

use Koneko\VuexyAdmin\Services\SettingsService;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteTemplateService;
use Livewire\Component;

class ChatSettings extends Component
{
    private $targetNotify = "#website-chat-settings-card .notification-container";

    public $chat_provider,
        $chat_whatsapp_number,
        $chat_whatsapp_message;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        if ($this->chat_provider == 'whatsapp') {
            $this->validate([
                'chat_whatsapp_number' => 'required|string|max:20',
                'chat_whatsapp_message' => 'required|string|max:255',
            ]);
        }

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('chat.provider', $this->chat_provider, null, 'vuexy-website-admin');
        $SettingsService->set('chat.whatsapp_number', $this->chat_whatsapp_number, null, 'vuexy-website-admin');
        $SettingsService->set('chat.whatsapp_message', $this->chat_whatsapp_message, null, 'vuexy-website-admin');

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
        $settings = app(WebsiteTemplateService::class)->getWebsiteVars('chat');

        $this->chat_provider         = $settings['provider'];
        $this->chat_whatsapp_number  = $settings['whatsapp_number'];
        $this->chat_whatsapp_message = $settings['whatsapp_message'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.vuexy.chat-settings');
    }
}
