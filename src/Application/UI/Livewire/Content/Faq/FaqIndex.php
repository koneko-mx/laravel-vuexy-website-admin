<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Content\Faq;

use Koneko\VuexyAdmin\Support\Livewire\Components\Table\AbstractTableComponent;
use Koneko\VuexyWebsiteAdmin\Application\ConfigBuilders\Faq\FaqTableConfigBuilder;

class FaqIndex extends AbstractTableComponent
{
    /**
     * Define la clase del builder de configuración.
     */
    protected function configBuilderClass(): ?string
    {
        return FaqTableConfigBuilder::class;
    }

    /**
     * Vista Blade que debe renderizar este componente.
     */
     protected function viewPath(): string
     {
         return 'vuexy-website-admin::livewire.content.faq.index';
     }
}
