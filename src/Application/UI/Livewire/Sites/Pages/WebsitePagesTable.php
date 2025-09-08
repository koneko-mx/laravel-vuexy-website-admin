<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Pages;

use Illuminate\Contracts\View\View;
use Koneko\VuexyAdmin\Support\Livewire\Components\Table\AbstractTableComponent;
use Koneko\VuexyWebsiteAdmin\Application\UX\ConfigBuilders\Pages\PagesTableConfigBuilder;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

class WebsitePagesTable extends AbstractTableComponent
{
    public WebsiteSite $site;

    public $statusOptions;

    protected function configBuilderClass(): ?string
    {
        return PagesTableConfigBuilder::class;
    }

    public function mount(): void
    {
        parent::mount();

        $this->statusOptions = \Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteContents\WebsiteContentStatus::optionsForForm();
    }

    public function render(): View
    {
        return view('vuexy-website-admin::livewire.sites.pages.table-index');
    }
}
