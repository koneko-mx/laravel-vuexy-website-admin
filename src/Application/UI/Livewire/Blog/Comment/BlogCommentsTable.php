<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Blog\Comment;

use Koneko\VuexyAdmin\Support\Livewire\Components\Table\AbstractTableComponent;
use Koneko\VuexyWebsiteAdmin\Application\ConfigBuilders\Blog\CommentsTableConfigBuilder;

class BlogCommentsTable extends AbstractTableComponent
{
    /**
     * Define la clase del builder de configuración.
     */
    protected function configBuilderClass(): ?string
    {
        return CommentsTableConfigBuilder::class;
    }

    /**
     * Vista Blade que debe renderizar este componente.
     */
     protected function viewPath(): string
     {
         return 'vuexy-website-admin::livewire.content.faq.index';
     }
}
