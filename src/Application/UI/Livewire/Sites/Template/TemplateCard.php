<?php

/**
 * COMPONENT: TemplateCard (refactor UI/UX)
 * - Mueve la carga de datos a mount()
 * - Elimina consultas duplicadas
 * - Valida template y theme_color
 * - Notificaciones y estados de carga
 * - Preparado para select mejorado (Choices/Select2) sin romper Livewire
 */

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Template;

use Koneko\VuexyWebsiteAdmin\Application\Template\TemplateRegistry;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;
use Livewire\Attributes\Rule;
use Livewire\Component;

final class TemplateCard extends Component
{
    public string $targetNotify = '#website-template-card .notification-container';

    public WebsiteSite $site;

    /**
     * Opciones agrupadas: ["Grupo" => ["items" => ["pkg:layout" => "Label"]]]
     */
    public array $template_options = [];

    #[Rule('required|string|max:64')]
    public string $template = '';

    #[Rule('required')]
    #[Rule('regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/')]
    public string $theme_color = '#0ea5e9';

    /**
     * Cargar datos iniciales una vez que $site ya está vinculado.
     */
    public function mount(WebsiteSite $site): void
    {
        $this->site = $site->withoutRelations();
        $this->template_options = TemplateRegistry::groupedOptions();
        $this->loadForm();
    }

    /**
     * (Re)carga los valores desde el modelo
     */
    public function loadForm(): void
    {
        // Asignación directa sin segunda consulta
        $this->template    = ($this->site->package ?: '') . ':' . ($this->site->layout ?: '');
        $this->template    = trim($this->template, ':');
        $this->theme_color = $this->site->theme_color ?: $this->theme_color;
    }

    /**
     * Guardar cambios con validaciones extra
     */
    public function save(): void
    {
        // Valida atributos
        $this->validate();

        // Validación estructural del template: "pkg:layout"
        if (!str_contains($this->template, ':')) {
            $this->addError('template', 'Formato inválido. Usa paquete:layout.');
            return;
        }

        [$package, $layout] = explode(':', $this->template, 2);
        $package = trim($package);
        $layout  = trim($layout);

        // Validar contra opciones disponibles (evita valores arbitrarios)
        $allowed = [];
        foreach ($this->template_options as $group) {
            foreach ($group['items'] as $key => $_label) {
                $allowed[$key] = true;
            }
        }
        if (!isset($allowed[$this->template])) {
            $this->addError('template', 'Plantilla no válida.');
            return;
        }

        try {
            $this->site->fill([
                'package'     => $package,
                'layout'      => $layout,
                'theme_color' => $this->theme_color,
            ])->save();

            // Notificación UI
            $this->dispatch(
                'notification',
                target: $this->targetNotify,
                type: 'success',
                message: 'Configuración guardada correctamente.'
            );

        } catch (\Throwable $e) {
            report($e);
            $this->dispatch(
                'notification',
                target: $this->targetNotify,
                type: 'danger',
                message: 'No se pudo guardar. Intenta de nuevo.'
            );
        }
    }

    public function resetForm(): void
    {
        $this->site->refresh();
        $this->loadForm();
        $this->resetValidation();
        $this->dispatch('notification', target: $this->targetNotify, type: 'info', message: 'Se descartaron los cambios.');
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.sites.template.template-card');
    }
}
