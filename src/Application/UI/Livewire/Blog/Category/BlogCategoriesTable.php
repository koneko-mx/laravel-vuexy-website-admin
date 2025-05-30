<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Blog\Category;

use Koneko\VuexyAdmin\Support\Livewire\Components\Table\AbstractTableComponent;
use Koneko\VuexyWebsiteAdmin\Application\ConfigBuilders\Blog\CategoriesTableConfigBuilder;

class BlogCategoriesTable extends AbstractTableComponent
{
    /**
     * Define la clase del builder de configuración.
     */
    protected function configBuilderClass(): ?string
    {
        return CategoriesTableConfigBuilder::class;
    }

    /**
     * Vista Blade que debe renderizar este componente.
     */
     protected function viewPath(): string
     {
         return 'vuexy-website-admin::livewire.blog.category.index';
     }
}
