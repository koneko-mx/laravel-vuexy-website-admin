<?php

namespace Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin;

use Koneko\VuexyAdmin\Services\SettingsService;
use Koneko\VuexyWebsiteAdmin\Services\WebsiteTemplateService;
use Livewire\Component;

class SocialMediaSettings extends Component
{
    private $targetNotify = "#website-social-settings-card .notification-container";

    public $social_whatsapp,
        $social_whatsapp_message,
        $social_facebook,
        $social_instagram,
        $social_linkedin,
        $social_tiktok,
        $social_x_twitter,
        $social_google,
        $social_pinterest,
        $social_youtube,
        $social_vimeo;

    public function mount()
    {
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'social_whatsapp' => 'string|max:20',
            'social_whatsapp_message' => 'string|max:255',
            'social_facebook' => 'url',
            'social_instagram' => 'url',
            'social_linkedin' => 'url',
            'social_tiktok' => 'url',
            'social_x_twitter' => 'url',
            'social_google' => 'url',
            'social_pinterest' => 'url',
            'social_youtube' => 'url',
            'social_vimeo' => 'url',
        ]);

        // Guardar título del sitio en configuraciones
        $SettingsService = app(SettingsService::class);

        $SettingsService->set('social.whatsapp', $this->social_whatsapp, null, 'vuexy-website-admin');
        $SettingsService->set('social.whatsapp_message', $this->social_whatsapp_message, null, 'vuexy-website-admin');
        $SettingsService->set('social.facebook', $this->social_facebook, null, 'vuexy-website-admin');
        $SettingsService->set('social.instagram', $this->social_instagram, null, 'vuexy-website-admin');
        $SettingsService->set('social.linkedin', $this->social_linkedin, null, 'vuexy-website-admin');
        $SettingsService->set('social.tiktok', $this->social_tiktok, null, 'vuexy-website-admin');
        $SettingsService->set('social.x_twitter', $this->social_x_twitter, null, 'vuexy-website-admin');
        $SettingsService->set('social.google', $this->social_google, null, 'vuexy-website-admin');
        $SettingsService->set('social.pinterest', $this->social_pinterest, null, 'vuexy-website-admin');
        $SettingsService->set('social.youtube', $this->social_youtube, null, 'vuexy-website-admin');
        $SettingsService->set('social.vimeo', $this->social_vimeo, null, 'vuexy-website-admin');

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
        $settings = app(WebsiteTemplateService::class)->getSocialVars();

        $this->social_whatsapp         = $settings['whatsapp'];
        $this->social_whatsapp_message = $settings['whatsapp_message'];
        $this->social_facebook         = $settings['facebook'];
        $this->social_instagram        = $settings['instagram'];
        $this->social_linkedin         = $settings['linkedin'];
        $this->social_tiktok           = $settings['tiktok'];
        $this->social_x_twitter        = $settings['x_twitter'];
        $this->social_google           = $settings['google'];
        $this->social_pinterest        = $settings['pinterest'];
        $this->social_youtube          = $settings['youtube'];
        $this->social_vimeo            = $settings['vimeo'];
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.vuexy.social-media-settings');
    }
}
