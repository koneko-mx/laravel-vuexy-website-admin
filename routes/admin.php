<?php

use Illuminate\Support\Facades\Route;
use Koneko\VuexyAdmin\Http\Controllers\UUserController;

// Grupo raíz para admin con middleware y prefijos comunes
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'admin.settings'])->group(function () {

});
