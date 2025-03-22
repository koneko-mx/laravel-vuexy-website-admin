<?php

namespace Koneko\VuexyWebsiteAdmin\Livewire\Faq;

use Koneko\VuexyAdmin\Livewire\Table\AbstractIndexComponent;
use Koneko\VuexyWebsiteAdmin\Models\Faq;

class FaqIndex extends AbstractIndexComponent
{
    /**
     * Retorna la clase del modelo asociado.
     *
     * @return string
     */
    protected function model(): string
    {
        return Faq::class;
    }

    /**
     * Configura el encabezado (header) de la tabla (las columnas).
     *
     * @return array
     */
    protected function columns(): array
    {
        return [
            'action'             => 'Acciones',
            'status'             => 'Estatus',
            'created_at'         => 'Fecha de Creación',
            'updated_at'         => 'Última Actualización',
        ];
    }

    /**
     * Define los formatos de cada columna (se inyectará en $bt_datatable['format']).
     *
     * @return array
     */
    protected function format(): array
    {
        return [
            'action' => [
                'formatter' => 'FaqActionFormatter',
                'onlyFormatter' => true,
            ],

            'status' => [
                'formatter' => [
                    'name' => 'dynamicBooleanFormatter',
                    'params' => ['tag' => 'activo']
                ],
                'align' => 'center',
            ],
            'created_at' => [
                'formatter' => 'textNowrapFormatter',
                'align' => 'center',
                'visible' => false,
            ],
            'updated_at' => [
                'formatter' => 'textNowrapFormatter',
                'align' => 'center',
                'visible' => false,
            ],
        ];
    }

    /**
     * Retorna la configuración base (común) para la tabla Bootstrap Table.
     *
     * @return array
     */
    protected function bootstraptableConfig(): array
    {
        return [
            'sortName' => 'code',
            'exportFileName' => 'Almacenes',
            'showFullscreen' => false,
            'showPaginationSwitch' => false,
            'showRefresh' => false,
            'pagination' => false,
        ];
    }

    /**
     * Retorna la ruta de la vista Blade.
     *
     * @return string
     */
    protected function viewPath(): string
    {
        // La vista que ya tienes creada para FaqIndex
        return 'vuexy-website-admin::livewire.faq.index';
    }

    /**
     * Métodos que necesites sobreescribir o extender.
     */
    public function mount(): void
    {
        parent::mount();
    }
}
