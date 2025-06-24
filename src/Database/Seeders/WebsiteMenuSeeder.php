<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteMenu, WebsiteSite};

class WebsiteMenuSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteMenu::class;
    protected string|array $uniqueBy = ['site_id', 'slug'];

    // Ruta del archivo de datos
    //protected string $targetFile = 'website_menus.json';

    protected function sanitizeRow(array $row): array
    {
        return array_merge($row, [
            'site_id' => $this->findSiteId($row['site_domain']),
        ]);
    }

    protected function findSiteId($domain): ?int
    {
        return WebsiteSite::where('domain', $domain)->first()?->id;
    }

}
