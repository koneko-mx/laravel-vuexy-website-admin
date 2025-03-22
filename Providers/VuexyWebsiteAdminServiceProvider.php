<?php

namespace Koneko\VuexyWebsiteAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Koneko\VuexyWebsiteAdmin\Console\Commands\SitemapGenerate;

use Koneko\VuexyWebsiteAdmin\Livewire\Faq\{FaqIndex,FaqOffCanvasForm};
use Koneko\VuexyWebsiteAdmin\Livewire\Images\ImagesIndex;
use Koneko\VuexyWebsiteAdmin\Livewire\LegalNotices\{LegalNoticesIndex,LegalNoticeOffCanvasForm};
use Koneko\VuexyWebsiteAdmin\Livewire\SitemapManager\{SitemapManagerIndex,SitemapUrlOffcanvasForm};

use Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin\{WebsiteDescriptionSettings,WebsiteFaviconSettings,LogoOnLightBgSettings,LogoOnDarkBgSettings};
use Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin\{SocialMediaSettings,ChatSettings,GoogleAnalyticsSettings};
use Koneko\VuexyWebsiteAdmin\Livewire\VuexyWebsiteAdmin\{ContactInfoSettings,LocationSettings,ContactFormSettings};

class VuexyWebsiteAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the module's routes
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');


        // Cargar vistas del paquete
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vuexy-website-admin');


        // Register the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Registrar comandos de consola
        if ($this->app->runningInConsole()) {
            $this->commands([
                SitemapGenerate::class,
            ]);
        }


        // Registrar Livewire Components
        $components = [
            // ajustes generales
            'vuexy-website-admin::website-description-settings'  => WebsiteDescriptionSettings::class,
            'vuexy-website-admin::website-favicon-settings'      => WebsiteFaviconSettings::class,
            'vuexy-website-admin::logo-on-light-bg-settings'     => LogoOnLightBgSettings::class,
            'vuexy-website-admin::logo-on-dark-bg-settings'      => LogoOnDarkBgSettings::class,

            // Avisos legales
            'vuexy-website-admin::legal-notices-index'         => LegalNoticesIndex::class,
            'vuexy-website-admin::legal-notice-offcanvas-form' => LegalNoticeOffCanvasForm::class,

            // Preguntas frecuentes
            'vuexy-website-admin::faq-index'          => FaqIndex::class,
            'vuexy-website-admin::faq-offcanvas-form' => FaqOffCanvasForm::class,

            // Redes sociales
            'vuexy-website-admin::social-media-settings' => SocialMediaSettings::class,

            // Chat
            'vuexy-website-admin::chat-settings' => ChatSettings::class,

            // Galería de imágenes
            'vuexy-website-admin::images-index' => ImagesIndex::class,

            // Google Analytics
            'vuexy-website-admin::google-analytics-settings' => GoogleAnalyticsSettings::class,

            // Información de contacto
            'vuexy-website-admin::contact-info-settings' => ContactInfoSettings::class,
            'vuexy-website-admin::location-settings'     => LocationSettings::class,

            // Formulario de contacto
            'vuexy-website-admin::contact-form-settings' => ContactFormSettings::class,

            // Mapa del sitio
            'vuexy-website-admin::sitemap-manager-index'          => SitemapManagerIndex::class,
            'vuexy-website-admin::sitemap-manager-offcanvas-form' => SitemapUrlOffcanvasForm::class,
        ];

        foreach ($components as $alias => $component) {
            Livewire::component($alias, $component);
        }

    }
}
