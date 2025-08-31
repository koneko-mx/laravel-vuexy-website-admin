<?php

use Illuminate\Support\Facades\Route;
use Koneko\VuexyAdmin\Support\Routing\RouteScope;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\AnalyticsController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\ComunicationController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\ContactController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\ContentController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\SeoController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\SettingsController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\TranstaleController;
use Koneko\VuexyWebsiteAdmin\Application\Http\Controllers\WebsitesController;

RouteScope::auto(__FILE__, 'website-admin', function (RouteScope $r) {
    // Web & SEO / Configuración general
    $r->route('sitios-web', 'websites.manager.', WebsitesController::class, function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{site}/{tab}', 'site')->name('site');
    });

    /*
    // Web & SEO / Configuración general
    $r->route('configuracion-general', 'settings.', SettingsController::class, function () {
        Route::get('ajustes-generales', 'generalIndex')->name('general.index');
        Route::get('enlaces-sociales', 'socialIndex')->name('social.index');
        Route::get('visibilidad-en-buscadores', 'indexingIndex')->name('indexing.index');
    });

    // Web & SEO / Contacto
    $r->route('contacto', 'contact.', ContactController::class, function () {
        Route::get('informacion-de-contacto', 'infoIndex')->name('info.index');
        Route::get('formulario-de-contacto', 'formIndex')->name('form.index');
    });

    // Web & SEO / Analítica y seguimiento
    $r->route('analitica-y-seguimiento', 'analytics.', AnalyticsController::class, function () {
        Route::get('google-analytics', 'googleAnalyticsIndex')->name('google-analytics.index');
        Route::get('google-tags', 'googleTagsIndex')->name('google-tags.index');
        Route::get('google-search-console', 'googleSearchConsoleIndex')->name('google-search-console.index');
        Route::get('pixel-meta', 'pixelMetaIndex')->name('pixel-meta.index');
    });

    // Web & SEO / Chat & Comunicación
    $r->route('chat-y-comunicacion', 'comunication.', ComunicationController::class, function () {
        Route::get('facebook-messenger', 'messengerIndex')->name('messenger.index');
        Route::get('whatsapp-chat', 'whatsappIndex')->name('whatsapp.index');
        Route::get('tawk-to', 'tawkToIndex')->name('tawk-to.index');
        Route::get('twitter-api', 'twitterIndex')->name('twitter.index');
    });

    // Web & SEO / Traducciones e internacional
    $r->route('traducciones-e-internacional', 'translate.', TranstaleController::class, function () {
        Route::get('google-translate', 'googleIndex')->name('google.index');
    });

    // Web & SEO / Contenido
    $r->route('contenido', 'content.', ContentController::class, function () {
        Route::get('preguntas-frecuentes', 'faqIndex')->name('faq.index');
        Route::get('galeria-de-imagenes', 'galleryIndex')->name('gallery.index');
        Route::get('avisos-legales', 'legalIndex')->name('legal.index');
    });

    // Web & SEO / Herramientas SEO
    $r->route('herramientas-seo', 'seo.', SeoController::class, function () {
        Route::get('mapa-del-sitio', 'sitemapIndex')->name('sitemap.index');
        Route::get('google-json-ld', 'jsonldIndex')->name('jsonld.index');
        Route::get('robots-txt', 'robotsIndex')->name('robots.index');
        Route::get('manifest-json', 'manifestIndex')->name('manifest.index');
        Route::get('cannonical-urls', 'canonicalIndex')->name('canonical.index');
        Route::get('preview-social-cards', 'socialCardsIndex')->name('social-cards.index');
    });
    */
});
