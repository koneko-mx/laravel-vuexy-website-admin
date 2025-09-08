<?php

use Illuminate\Support\Facades\Route;
use Koneko\VuexyWebsiteAdmin\Website\Http\Controllers\WebsitePageController;

// Contenido publico
Route::get('/{slug}', WebsitePageController::class)
    ->where('slug', '^(?!admin|login|register|logout|email|user|storage|api|livewire|_debugbar|sanctum|preview)(.*)$')
    ->name('website.content');

// Vista previa con firma
Route::get('/preview/{slug}', [WebsitePageController::class, 'preview'])
    ->middleware(['signed']) // Protege con firma
    ->name('website.preview');
