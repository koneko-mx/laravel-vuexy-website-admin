<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Manager;

use Koneko\VuexyAdmin\Support\Livewire\Components\Form\AbstractFormOffCanvasComponent;
use Illuminate\Validation\Rule;
use Koneko\VuexyAdmin\Support\Validation\DomainRule;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

/**
 * Class SiteOffCanvasForm
 *
 * Componente Livewire para gestionar permisos.
 * Extiende AbstractFormOffCanvasComponent para proporcionar una interfaz
 * eficiente para la gestión de permisos en el ERP.
 *
 * @package App\Http\Livewire\Forms
 */
class SiteOffCanvasForm extends AbstractFormOffCanvasComponent
{
    /**
     * Propiedades del formulario.
     */
    public $domain,
        $title,
        $prevent_indexed,
        $www_redirect,
        $force_https;

    /**
     * Eventos de escucha de Livewire.
     */
    /*
    protected $listeners = [
        'editSite' => 'loadFormModel',
        'confirmDeletionSite' => 'loadFormModelForDeletion',
    ];
    */

    /**
     * Define el modelo Eloquent asociado con el formulario.
     */
    protected function model(): string
    {
        return WebsiteSite::class;
    }

    /**
     * Valores por defecto para el formulario.
     */
    protected function defaults(): array
    {
        return [
            'prevent_indexed' => false,
            'www_redirect' => true,
            'force_https' => true,
        ];
    }

    /**
     * Campo que se debe enfocar cuando se abra el formulario.
     */
    protected function focusColumnOnOpen(): string
    {
        return 'domain';
    }

    /**
     * Define reglas de validación dinámicas basadas en el modo actual.
     */
    protected function dynamicRules(string $mode): array
    {
        switch ($mode) {
            case 'create':
            case 'edit':
                return [
                    'domain' => [
                        'required',
                        'string',
                        new DomainRule,
                        Rule::unique('website_sites', 'domain')->ignore($this->id)
                    ],
                    'title' => ['required', 'string' , 'max:50'],
                ];

            case 'delete':
                return ['confirmDeletion' => 'accepted'];

            default:
                return [];
        }
    }

    /**
     * Define los atributos personalizados para los errores de validación.
     */
    protected function attributes(): array
    {
        return [
            'domain' => 'dominio',
            'title' => 'titulo',
        ];
    }

    /**
     * Define los mensajes de error personalizados para la validación.
     */
    protected function messages(): array
    {
        return [
            'domain.required' => 'El dominio es obligatorio.',
            'domain.unique' => 'Este dominio ya existe.',
            'domain.regex' => 'El dominio debe ser un dominio valido.',
            'title.required' => 'El titulo es obligatorio.',
        ];
    }

    /**
     * Carga el formulario con datos de un permiso específico.
     */
    /*
    public function loadFormModel($id): void
    {
        parent::loadFormModel($id);
    }
    */

    /**
     * Carga el formulario para eliminar un permiso específico.
     */
    /*
    public function loadFormModelForDeletion($id): void
    {
        parent::loadFormModelForDeletion($id);
    }
    */

    /**
     * Ruta de la vista asociada con este formulario.
     */
    protected function viewPath(): string
    {
        return 'vuexy-website-admin::livewire.sites.manager.offcanvas-form';
    }
}
