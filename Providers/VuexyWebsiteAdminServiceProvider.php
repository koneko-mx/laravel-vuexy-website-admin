<?php

namespace Koneko\VuexyWebsiteAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use OwenIt\Auditing\AuditableObserver;

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


        // Registrar Livewire Components
        $components = [
            //'user-count' => UserCount::class,
        ];

        foreach ($components as $alias => $component) {
            Livewire::component($alias, $component);
        }


        // Registrar auditoría en usuarios
        //User::observe(AuditableObserver::class);
    }
}
