<?php

use Illuminate\Support\Facades\Route;
use Koneko\VuexyWebsiteAdmin\Http\Controllers\{LegalNoticesController,FaqController,ImagesController};
use Koneko\VuexyWebsiteAdmin\Http\Controllers\{SocialMediaController,ChatController,GoogleAnalyticsController};
use Koneko\VuexyWebsiteAdmin\Http\Controllers\{ContactInfoController,ContactFormController,VuexyWebsiteAdminController,SitemapController};

// Grupo raíz para admin con middleware y prefijos comunes
Route::prefix('admin/sitio-web')->name('admin.website-admin.')->middleware(['web', 'auth', 'admin'])->group(function () {
    // ajustes generales
    Route::controller(VuexyWebsiteAdminController::class)->prefix('ajustes-generales')->group(function () {
        Route::get('ajustes-generales', 'index')->name('general-settings.index');
    });

    // Avisos legales
    Route::controller(LegalNoticesController::class)->prefix('avisos-legales')->group(function () {
        Route::get('/', 'index')->name('legal-notices.index');
    });

    // Preguntas frecuentes
    Route::controller(FaqController::class)->prefix('preguntas-frecuentes')->group(function () {
        Route::get('/', 'index')->name('faq.index');
    });

    // Redes sociales
    Route::controller(SocialMediaController::class)->prefix('redes-sociales')->group(function () {
        Route::get('/', 'index')->name('social-media.index');
    });

    // Chat
    Route::controller(ChatController::class)->prefix('chat')->group(function () {
        Route::get('/', 'index')->name('chat.index');
    });

    // Galería de imágenes
    Route::controller(ImagesController::class)->prefix('galeria-de-imagenes')->group(function () {
        Route::get('/', 'index')->name('images.index');
    });

    // Google Analytics
    Route::controller(GoogleAnalyticsController::class)->prefix('google-analytics')->group(function () {
        Route::get('/', 'index')->name('google-analytics.index');
    });

    // Información de contacto
    Route::controller(ContactInfoController::class)->prefix('informacion-de-contacto')->group(function () {
        Route::get('/', 'index')->name('contact-info.index');
    });

    // Formulario de contacto
    Route::controller(ContactFormController::class)->prefix('formulario-de-contacto')->group(function () {
        Route::get('/', 'index')->name('contact-form.index');
    });

    // Mapa del sitio
    Route::controller(SitemapController::class)->prefix('mapa-del-sitio')->group(function () {
        Route::get('/', 'index')->name('sitemap.index');
    });
});
